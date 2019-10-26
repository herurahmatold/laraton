<?php
use App\Libraries\Core\Laraton;
use App\Models\Core\Options;
use DB;

if(!function_exists('db_count'))
{
	function db_count($table,$where=[],$whereRaw='')
	{
        $count=DB::table($table);
        if(!empty($where))
        {
            $count->where($where);
        }
        if(!empty($whereRaw))
        {
            $count->whereRaw($whereRaw);
        }
        $total=$count->count();
        return $total;
	}
}

if(!function_exists('option_get'))
{
	function option_get($key)
	{
        $laraton=new Laraton();
        return $laraton->option_get($key);
	}
}

function laralogin($title='',$data=[])
{
    $meta_title=option_get('company_name');
    if(!empty($title))
    {
        $meta_title=$title;
    }
    return view('core.layouts.loader.login',compact('meta_title','data'));
}

function laraview($view='',$meta_config=[],$data=[],$merge_data=[])
{   
    $meta=array('title'=>option_get('app_name'));
    if(!empty($meta_config))
    {
        $meta=$meta_config;
    }
    $content='core.layouts.nocontent';
    if(!empty($view))
    {
        $content=$view;
    }
    $merge_core=array_merge(['content'=>$content],$data,['meta'=>$meta]);
    return view('core.layouts.loader.backend',$merge_core,$merge_data);
}

function laraconfig($file,$key)
{
    $path=base_path('app/Config/'.$file.'.php');
    if(file_exists($path) && is_file($path))
    {
        include($path);
        return $config[$key];
    }else{
        return "";
    }
}

function message_header($redirectTo,$type='success',$message,$route_parameter=[])
{
    return redirect()->route($redirectTo,$route_parameter)->with([$type=>$message]);
}

function app_logo($size='')
{
    $laraton=new Laraton();
    return $laraton->get_logo('logo',$size);
}

function app_favicon($size='')
{
    $laraton=new Laraton();
    return $laraton->get_logo('favicon',$size);
}