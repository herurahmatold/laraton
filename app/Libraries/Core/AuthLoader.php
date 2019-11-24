<?php
namespace App\Libraries\Core;

use Session;
use App\Models\Core\Users;
use App\Models\Core\UserGroup;
use App\Libraries\Core\Hashing;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class AuthLoader
{
    public $session_name;
    protected $username_min_length=2;
    protected $password_min_length=3;
    public $user_status=array(0=>'Non Active',1=>'Active');
    protected $session_var;

    public function __construct()
    {
        $this->session_name=laraconfig('global','session_name');
        
    }

    public function has_login()
    {
        if(Session::get($this->session_name)){
            return true;
        }
    }

    public function check_access_route($route_name)
    {
        $groupID = user_info('user_group_id');
        if($groupID !=1)
        {
            $check = DB::table('page_access')->where('route_name', $route_name)->first();
            if (!empty($check->id)) {
                $check_detail = DB::table('page_access_detail')->where('page_access_id', $check->id)->where('user_group_id', $groupID)->count();
                if ($check_detail > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }else{
            return true;
        }
    }

    public function check_access_page($access)
    {
        $session_data=Session::get($this->session_name);   
        $group_name=$session_data['group_name'];
        if(!in_array($group_name,$access))
        {
            header('Location: '.route('dashboard'));
            exit();
        }
    }

    public function login($username,$password)
    {
        $output=array();
        $check_username=$this->username_valid($username);
        $check_password=$this->password_valid($password);
        if($check_username==TRUE && $check_password==TRUE)
        {
            $checker=Users::where('username',$username)->select('id','username','email','name','user_group_id','password','status')->first();
            if(!empty($checker))
            {
                if($checker->status ==1)
                {
                    $password_db=$checker->password;
                    $hash=new Hashing();
                    if($hash->CheckPassword($password,$password_db))
                    {
                        $user_group_id=$checker->user_group_id;
                        $user_group=UserGroup::where('id',$user_group_id)->select('group_name','group_value')->first();
                        if(!empty($user_group))
                        {
                            $arr_session=array(
                                'id'=>$checker->id,
                                'name'=>$checker->name,
                                'email'=>$checker->email,
                                'group_id'=>$checker->user_group_id,
                                'group_name'=>$user_group->group_name,
                                'group_value'=>$user_group->group_value
                            );
                            Session::put($this->session_name,$arr_session);
                            Users::where('id',$checker->id)->update(['last_login'=>date_now(TRUE)]);
                            $output=array(
                                'status'=>TRUE,
                                'message'=>'User Valid'
                            );
                        }else{
                            $output=array(
                                'status'=>FALSE,
                                'message'=>'User Group Invalid'
                            );    
                        }
                    }else{
                        $output=array(
                            'status'=>FALSE,
                            'message'=>'Password Invalid'
                        );
                    }
                }else{
                    $output=array(
                        'status'=>FALSE,
                        'message'=>'User Non Active'
                    );
                }
            }else{
                $output=array(
                    'status'=>FALSE,
                    'message'=>'User Not Found'
                );
            }
        }else{
            $output=array(
                'status'=>FALSE,
                'message'=>'Invalid Specified username and password'
            );
        }
        return $output;
    }

    public function logout()
    {
        Session::forget($this->session_name);
    }

    private function username_valid($username)
    {
        if(strlen($username) >= $this->username_min_length)
        {
            return true;
        }
    }

    private function password_valid($password)
    {
        if(strlen($password) >= $this->password_min_length)
        {
            return true;
        }
    }
    
}