<?php
use App\Libraries\Core\Laraton;
use App\Libraries\Core\AuthLoader;
use App\Libraries\Core\UserLib;

function user_info($output='id')
{
    $auth=new AuthLoader();
    $session_name=$auth->session_name;
    if(Session::get($session_name)['id'])
    {
        $userid=Session::get($session_name)['id'];
        $UserLib=new UserLib();
        return $UserLib->get_user_info($userid,$output);
    }
}

function user_info_custom($userid,$output='id')
{
   $UserLib=new UserLib();
    return $UserLib->get_user_info($userid,$output);
}

function user_group_name()
{
    $user_group_id=user_info('user_group_id');
    if(!empty($user_group_id))
    {
        $UserLib=new UserLib();
        $group_name=$UserLib->get_group_info($user_group_id,'group_name');
        return $group_name;
    }else{
        return redirect()->route('front');
    }
}

function user_group_name_custom($userid)
{
    $user_group_id=user_info_custom($userid,'user_group_id');
    if(!empty($user_group_id))
    {
        $UserLib=new UserLib();
        $group_name=$UserLib->get_group_info($user_group_id,'group_name');
        return $group_name;
    }
}

function user_group_value()
{
    $user_group_id=user_info('user_group_id');
    if(!empty($user_group_id))
    {
        $UserLib=new UserLib();
        $group_value=$UserLib->get_group_info($user_group_id,'group_value');
        return $group_value;
    }
}

function user_group_value_custom($userid)
{
    $user_group_id=user_info_custom($userid,'user_group_id');
    if(!empty($user_group_id))
    {
        $UserLib=new UserLib();
        $group_value=$UserLib->get_group_info($user_group_id,'group_value');
        return $group_value;
    }
}

function user_avatar($size='')
{
    $userid=user_info('id');
    $UserLib=new UserLib();
    $avatar=$UserLib->get_user_avatar($userid,$size);
    return $avatar;
}

function user_avatar_custom($userid,$size='')
{
    $UserLib=new UserLib();
    $avatar=$UserLib->get_user_avatar($userid,$size);
    return $avatar;
}

function access_page($access)
{
    $auth=new AuthLoader();
    return $auth->check_access_page($access);
}

function add_role($access)
{
    $auth = new AuthLoader();
    return $auth->check_access_page($access);
}