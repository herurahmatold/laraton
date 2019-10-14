<?php
$navFile=include(base_path('app/Config/Navigation/'.user_group_name().'.php'));
function template_menu($menu)
{
    $output='';

    foreach($menu as $k=>$v)
	{
		$parentClass="treeview";
		$parentSubClass="treeview-menu";
		
		$Slug_1=isset($v['s1'])?$v['s1']:"";
		$Slug_2=isset($v['s2'])?$v['s2']:"";
		$Slug_3=isset($v['s3'])?$v['s3']:"";
		$route=isset($v['route'])?$v['route']:"";
		$params=isset($v['params'])?$v['params']:"";
		$target=isset($v['target'])?$v['target']:"";
		$icon=isset($v['icon'])?$v['icon']:"fa fa-circle-o";
		$aktif='';
        $route_generate='';
        if(!empty($route))
        {
            if(!empty($params))
            {
                $route_generate=route($route,$params);
            }else{
                $route_generate=route($route);
            }
        }
		if(isset($v['child']))
		{
			if(lara_menu_active($Slug_1,$Slug_2,$Slug_3)==TRUE)
			{
				$aktif="active";
			}
			$output.='
			<li class="'.$parentClass.' '.$aktif.'">
				<a href="javascript:;">
					<i class="'.$icon.'"></i> <span>'.$k.'</span>
					<span class="pull-right-container">
		              <i class="fa fa-angle-left pull-right"></i>
		            </span>
				</a>
			';
			$output.='<ul class="'.$parentSubClass.'">';
			$output.=template_menu($v['child']);
			$output.='</ul>';
			$output.='</li>';
		}else{
			if(lara_menu_active($Slug_1,$Slug_2,$Slug_3)==TRUE)
			{
				$aktif="active";
			}
			$output.='
			<li>
				<a href="'.$route_generate.'" 
					target="'.$target.'">
					<i 
					class="'.$icon.'"></i> 
					'.$k.'
				</a>
			</li>
			';
		}
	}
	return $output;
}

echo template_menu($navFile);