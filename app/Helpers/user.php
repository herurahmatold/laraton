<?php
use App\Models\Core\Options;
use App\Models\Core\Users;
use App\Models\Core\UserGroup;
use App\Libraries\Core\AuthLoader;

function user_info($output='id')
{
    $auth=new AuthLoader();
    $session_name=$auth->session_name;
    if(Session::get($session_name)['id'])
    {
        $userid=Session::get($session_name)['id'];
        $db=Users::select($output)->where('id',$userid)->first();
        if(!empty($db->$output))
        {
            return $db->$output;
        }
    }
}

function user_group_name()
{
    $user_group_id=user_info('user_group_id');
    if(!empty($user_group_id))
    {
        $db=UserGroup::select('group_name')->where('id',$user_group_id)->first();
        if(!empty($db->group_name))
        {
            return $db->group_name;
        }
    }

}

function user_group_value()
{
    $user_group_id=user_info('user_group_id');
    if(!empty($user_group_id))
    {
        $db=UserGroup::select('group_value')->where('id',$user_group_id)->first();
        if(!empty($db->group_value))
        {
            return $db->group_value;
        }
    }

}

function user_avatar($size='')
{
    $path=public_path('uploads/');
    $url=asset('uploads/');
    $default=laraconfig('global','avatar');
    $avatar=user_info('avatar');
    $file_path=$path.'/'.$avatar;
    $file_url=$url.'/'.$avatar;
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