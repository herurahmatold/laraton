<?php
namespace App\Libraries\Core;

use App\Models\Core\Options;
use App\Libraries\Core\File;

use Intervention\Image\ImageManager;


class Laraton
{
    public function option_get($key)
    {
        $output='';
        $item=Options::where('option_key',$key)->select('option_value')->first();
        if(!empty($item))
        {
            $output=$item->option_value;
        }

        return $output;
    }

    public function version()
    {
        return $this->option_get('app_version');
    }

    public function get_logo($type,$size='')
    {
        $path=laraconfig('global','upload_path');
        $url=laraconfig('global','upload_url');
        $default=laraconfig('global','logo');
        $avatar=option_get($type);
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

    public function app_change_logo($field_custom='logo')
    {
        $output=array();
        if(isset($_FILES[$field_custom]['name']))
        {
            $extension=pathinfo($_FILES[$field_custom]['name'],PATHINFO_EXTENSION);
            $default_thumbnail=[200,800];
            $thumbnail_size=laraconfig('global','thumbnail_size');
            if(empty($thumbnail_size))
            {
                $thumbnail_size=$default_thumbnail;
            }
            $path=laraconfig('global','upload_path');
            $url=laraconfig('global','upload_url');
            $avatar_name=$field_custom.".".$extension;
            $avatar_file=$path.$avatar_name;
            $avatar_url=$url.'/'.$avatar_name;
            $manager=new ImageManager();
            $save=$manager->make($_FILES[$field_custom]['tmp_name'])->save($avatar_file);
            if($save)
            {
                $fileLib=new File();
                $fileLib->create_directory($path.'thumbs');
                foreach($thumbnail_size as $k)
                {
                    $thumb_folder=$path.'thumbs/'.$k;
                    $fileLib->create_directory($thumb_folder);
                    $thumb_file=$thumb_folder.'/'.$avatar_name;
                    $manager->make($avatar_file)->resize($k)->save($thumb_file);
                }
                Options::where('option_key',$field_custom)->update(['option_value'=>$avatar_name]);
                $output=array('status'=>true,'message'=>'Success Upload','img'=>$avatar_url.'?time='.time());
            }else{
                $output=array('status'=>false,'message'=>'Failed Upload');
            }
        }else{
            $output=array('status'=>false,'message'=>'Invalid Image');
        }
        return $output;
    }

    

}