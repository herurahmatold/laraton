<?php
namespace App\Libraries\Core;

use App\Models\Core\Users;
use App\Models\Core\UserGroup;
use App\Libraries\Core\Hashing;
use App\Libraries\Core\File;

use Intervention\Image\ImageManager;

class UserLib
{

    public function get_user_info($id,$field)
    {
        $output="";
        $item=Users::where('id',$id)->select($field)->first();
        if(!empty($item))
        {
            $output=$item->$field;
        }

        return $output;
    }

    public function get_user_avatar($id,$size='')
    {
        $path=laraconfig('global','upload_path');
        $url=laraconfig('global','upload_url');
        $default=laraconfig('global','avatar');
        $avatar=$this->get_user_info($id,'avatar');
        $file_path=$path.$avatar;
        $file_url=$url.$avatar;
        if(!empty($size))
        {
            $file_path=$path.'/thumbs/'.$size.'/'.$avatar;
            $file_url=$url.'/thumbs/'.$size.'/'.$avatar;
        }
        if(file_exists($file_path) && is_file($file_path))
        {
            $default=$file_url;
        }

        return $default;
    }

    public function get_group_info($groupid,$field)
    {
        $output="";
        $item=UserGroup::where('id',$groupid)->select($field)->first();
        if(!empty($item))
        {
            $output=$item->$field;
        }

        return $output;
    }

    public function user_email_exists($email)
    {
        $count=User::where('email',$email)->count();
        return $count;
    }

    public function user_edit($id,$name,$email,$password_old='',$password_new='',$password_confirm='')
    {
        $output=array();
        try {
            $last_email=$this->get_user_info($id,'email');
            $check=FALSE;
            if($last_email==$email)
            {
                $check=TRUE;
            }else{
                if(!$this->user_email_exists($email))
                {
                    $check=TRUE;
                }
            }
            if($check)
            {
                $save=Users::where('id',$id)->update([
                    'name'=>$name,
                    'email'=>$email
                ]);
                if($save)
                {
                    if(!empty($password_old) && !empty($password_new))
                    {
                        $action=$this->user_change_password($id,$password_old,$password_new,$password_confirm);
                        if($action['status']==true)
                        {
                            $output=array('status'=>true,'type'=>'success','message'=>'Success Update Profile. Password Change Success');
                        }else{
                            $output=array('status'=>true,'type'=>'warning','message'=>'Success Update Profile. But Password Change Invalid');
                        }
                    }else{
                        $output=array('status'=>true,'type'=>'success','message'=>'Success Update Profile');
                    }
                }else{
                    $output=array('status'=>false,'type'=>'error','message'=>'Error System');
                }
            }else{
                $output=array('status'=>false,'type'=>'error','message'=>'Email Exists');
            }
            
        } catch (\Exception $e) {
            $output=array('status'=>false,'message'=>$e->getMessage());
        }

        return $output;
    }

    public function user_change_password($id,$password_old,$password_new,$password_confirm)
    {
        $output=array();
        try {
            if($password_new==$password_confirm)
            {
                $db_pass=$this->get_user_info($id,'password');
                $hashing=new Hashing();
                if($hashing->CheckPassword($password_old,$db_pass))
                {
                    $new_pass=$hashing->HashPassword($password_new);
                    $save=Users::where('id',$id)->update([
                        'password'=>$new_pass
                    ]);
                    if($save)
                    {
                        $output=array('status'=>true,'message'=>'Success Update Profile');
                    }else{
                        $output=array('status'=>false,'message'=>'Error System');
                    }
                }else{
                    $output=array('status'=>false,'message'=>'Old Password Invalid');
                }
            }else{
                $output=array('status'=>false,'message'=>'Confirmation Password Invalid');
            }
        } catch (\Exception $e) {
            $output=array('status'=>false,'message'=>$e->getMessage());
        }
        

        return $output;
    }

    public function user_change_avatar($id)
    {
        $output=array();
        if(isset($_FILES['file']['name']))
        {
            $extension=pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
            $default_thumbnail=[200,800];
            $thumbnail_size=laraconfig('global','thumbnail_size');
            if(empty($thumbnail_size))
            {
                $thumbnail_size=$default_thumbnail;
            }
            $path=laraconfig('global','upload_path');
            $url=laraconfig('global','upload_url');
            $avatar_name='avatar-'.md5($id).".".$extension;
            $avatar_file=$path.$avatar_name;
            $avatar_url=$url.'/'.$avatar_name;
            $manager=new ImageManager();
            $save=$manager->make($_FILES['file']['tmp_name'])->save($avatar_file);
            //$save=$manager->make($_FILES['file']['tmp_name'])->resize($thumbnail_size)->save($avatar_file);
            if($save)
            {
                $fileLib=new File();
                $fileLib->create_directory($path.'thumbs');
                foreach($thumbnail_size as $k)
                {
                    $thumb_folder=$path.'thumbs/'.$k;
                    $fileLib->create_directory($thumb_folder);
                    $thumb_file=$thumb_folder.'/'.$avatar_name;
                    $manager->make($avatar_file)->fit($k)->save($thumb_file);
                }
                Users::where('id',$id)->update(['avatar'=>$avatar_name]);
                $output=array('status'=>true,'message'=>'Success Upload','img'=>$avatar_url.'?time='.time());
            }else{
                $output=array('status'=>false,'message'=>'Failed Upload');
            }
        }else{
            $output=array('status'=>false,'message'=>'Invalid Image');
        }
        return $output;
    }

    public function user_group_add($name,$value)
    {
        $output=array();
        $check=UserGroup::where('group_name',$name)->count();
        if($check)
        {
            $output=array(
                'status'=>false,
                'message'=>'User Group Exists'
            );
        }else{
            $group=new UserGroup();
            $group->group_name = $name;
            $group->group_value = $value;
            $save=$group->save();
            if($save)
            {
                $output=array(
                    'status'=>true,
                    'message'=>'User Group Added'
                );
            }else{
                $output=array(
                    'status'=>false,
                    'message'=>'System Error'
                );
            }
        }
        return $output;
    }

    public function user_group_edit($group_id,$name,$value)
    {
        $output=array();
        $check=UserGroup::where('id',$group_id)->first(['id','group_name']);
        if($check)
        {
            $next=false;
            $last_name=$check->group_name;
            if($last_name==$name)
            {
                $next=true;
            }else{
                $check_name=UserGroup::where('group_name',$name)->count();
                if(!$check_name)
                {
                    $next=true;
                }
            }
            if($next==true)
            {
                $save=UserGroup::where('id',$group_id)
                    ->update([
                    'group_name'=>$name,
                    'group_value'=>$value
                ]);
                if($save >=0)
                {
                    $output=array(
                        'status'=>true,
                        'message'=>'User Group Updated'
                    );
                }else{
                    $output=array(
                        'status'=>false,
                        'message'=>'System Error'
                    );
                }
            }else{
                $output=array(
                    'status'=>false,
                    'message'=>'User Group Exists'
                );
            }
        }else{
            $output=array(
                'status'=>false,
                'message'=>'User Group Not Exists'
            );
        }
        return $output;
    }

    public function user_group_delete($group_id)
    {
        $output=array();
        $check=UserGroup::where('id',$group_id)->first('id');
        if($check)
        {
            $delete=UserGroup::where('id',$group_id)
                ->delete();
            if($delete)
            {
                $output=array(
                    'status'=>true,
                    'message'=>'User Group Deleted'
                );
            }else{
                $output=array(
                    'status'=>false,
                    'message'=>'System Error'
                );
            }
        }else{
            $output=array(
                'status'=>false,
                'message'=>'User Group Not Exists'
            );
        }
        return $output;
    }

}