<?php

if(!function_exists('cdn_dashboard'))
{
    function cdn_dashboard()
    {
        $public_url=asset('/');
        $o=add_css($public_url.'assets/css/dashboard.css');
        $o.=add_js($public_url.'assets/js/dashboard.js');
        return $o;
    }
}

if(!function_exists('cdn_select2'))
{
	function cdn_select2()
	{
		$url=url('/').'/assets/vendors/';
		$a='';
		$a.=add_css($url.'select2/css/select2.min.css');
		$a.=add_css($url.'select2/css/select2.reset.css');
		$a.=add_js($url.'select2/js/select2.full.min.js');
		$a.=add_js($url.'select2/js/i18n/id.js');
		
		return $a;
	}
}

if(!function_exists('cdn_fontawesome'))
{
	function cdn_fontawesome()
	{
		$url=url('/').'/assets/vendors/';
		$a=add_css($url.'fontawesome/css/font-awesome.min.css');
		
		return $a;
	}
}

if(!function_exists('cdn_ionicons'))
{
	function cdn_ionicons()
	{
		$url=url('/').'/assets/vendors/';
		$a=add_css($url.'Ionicons/css/ionicons.min.css');
		
		return $a;
	}
}

if(!function_exists('cdn_bootstrap_css'))
{
	function cdn_bootstrap_css($version='v3')
	{
		$url=url('/').'/assets/vendors/';
		return add_css($url.'bootstrap/'.$version.'/css/bootstrap.min.css');	
	}
}

if(!function_exists('cdn_bootstrap_js'))
{
	function cdn_bootstrap_js($version='v3')
	{
		$url=url('/').'/assets/vendors/';
		
		return add_js($url.'bootstrap/'.$version.'/js/bootstrap.min.js');	
	}
}

if(!function_exists('cdn_jquery'))
{
	function cdn_jquery()
	{
		$url=url('/').'/assets/vendors/';
		$a='';
		$a.=add_js($url.'jquery/jquery.min.js');
		return $a;
	}
}

if(!function_exists('cdn_jqueryui'))
{
	function cdn_jqueryui($theme="smoothness")
	{
		$url=url('/').'/assets/vendors/';
		$a='';
		$a.=add_css($url.'jqueryui/jquery-ui.min.css');
		$a.=add_css($url.'jqueryui/themes/'.$theme.'/jquery-ui.min.css');
		$a.=add_js($url.'jqueryui/jquery-ui.min.js');
		return $a;
	}
}

if(!function_exists('cdn_datatables'))
{
	function cdn_datatables($withButton=FALSE)
	{	
		$url=url('/').'/assets/vendors/';
		$a='';
		$a.=add_css($url.'datatables/css/dataTables.bootstrap.min.css');
		$a.=add_css($url.'datatables/Responsive/css/responsive.bootstrap.min.css');
		if($withButton==TRUE)
		{
		$a.=add_css($url.'datatables/Buttons/css/buttons.dataTables.min.css');	
		}
		$a.=add_js($url.'datatables/js/jquery.dataTables.min.js');
		$a.=add_js($url.'datatables/Responsive/js/dataTables.responsive.min.js');
		$a.=add_js($url.'datatables/js/dataTables.bootstrap.min.js');
		$a.=add_js($url.'datatables/Responsive/js/responsive.bootstrap.min.js');
		
		
		if($withButton==TRUE)
		{
		$a.=add_js($url.'datatables/JSZip/jszip.min.js');
		$a.=add_js($url.'datatables/pdfmake/build/pdfmake.min.js');
		$a.=add_js($url.'datatables/pdfmake/build/vfs_fonts.js');
		$a.=add_js($url.'datatables/Buttons/js/dataTables.buttons.min.js');
		$a.=add_js($url.'datatables/Buttons/js/buttons.flash.min.js');
		$a.=add_js($url.'datatables/Buttons/js/buttons.html5.min.js');
		$a.=add_js($url.'datatables/Buttons/js/buttons.print.min.js');
		}
		$a.=add_js($url.'datatables/paging.listjump.js');
		
		return $a;
	}
}

if(!function_exists('cdn_highchart'))
{
	function cdn_highchart($theme='')
	{
		$url=url('/').'/assets/vendors/';
		
		$a='';
		$a.=add_js($url.'highcharts/js/highcharts.js');
		if(!empty($theme))
		{
			$a.=add_js($url.'highcharts/js/themes/'.$theme.'.js');
		}
		
		return $a;
	}
}