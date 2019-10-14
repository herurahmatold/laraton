<?php

if(!function_exists('backend_theme'))
{
	function backend_theme()
	{
		$default='adminlte2';
		$get_option=option_get('backend_theme');
		if(!empty($get_option))
		{
			$default=$get_option;
		}

		return $default;
	}
}

if(!function_exists('add_js'))
{
	function add_js($linkJS,$paramArray=array())
	{
		$param=string_implode_array($paramArray);
		return '<script src="'.$linkJS.'" '.$param.'></script>';
	}
}

if(!function_exists('add_css'))
{
	function add_css($linkCSS,$paramArray=array())
	{
		$param=string_implode_array($paramArray);
		return '<link rel="stylesheet" href="'.$linkCSS.'" '.$param.'/>';
	}
}

if(!function_exists('lara_aset_url'))
{
	function lara_aset_url()
	{
		$o=asset('/').'/assets/';
		return $o;
	}
}

if(!function_exists('lara_vendor_url'))
{
	function lara_vendor_url()
	{
		return lara_aset_url().'vendors/';
	}
}

if(!function_exists('lara_theme_dashboard_url'))
{
	function lara_theme_dashboard_url()
	{
		$o=asset('/').'themes/dashboard/';
		return $o;
	}
}

if(!function_exists('lara_theme_frontend_url'))
{
	function lara_theme_frontend_url()
	{
		$o=asset('/').'themes/frontend/';
		return $o;
	}
}

function lara_menu_active($slugOne,$slugTwo="",$slugThree="")
{
	$s1=Request::segment(1);
	$s2=Request::segment(2);
	$s3=Request::segment(3);
	
	if(!empty($slugOne) && empty($slugTwo) && empty($slugThree))
	{
		if($slugOne==$s1)
		{
			//echo 'S1 OK';
			return true;
		}
	}elseif(!empty($slugOne) && !empty($slugTwo) && empty($slugThree))
	{
		if($slugOne==$s1 && $slugTwo==$s2)
		{
			//echo 'S1 OK S2 OK';
			return true;
		}else{
			return false;
		}
	}elseif(!empty($slugOne) && !empty($slugTwo) && !empty($slugThree))
	{
		if($slugOne==$s1 && $slugTwo==$s2 && $slugThree==$s3)
		{
			//echo 'S1 OK S2 OK S3 OK';
			return true;
		}else{
			return false;
		}
	}
	
}