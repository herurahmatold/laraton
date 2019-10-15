<?php
use App\Libraries\Core\Laraton;
use App\Models\Core\Options;

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
    $meta_title=env('APP_NAME');
    if(!empty($title))
    {
        $meta_title=$title;
    }
    return view('core.layouts.loader.login',compact('meta_title','data'));
}

function laraview($view='',$meta_config=[],$data=[])
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
    return view('core.layouts.loader.backend',compact('content','data','meta'));
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

function message_header($redirectTo,$type='success',$message)
{
    return redirect()->route($redirectTo)->with([$type=>$message]);
}