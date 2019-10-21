<?php

if(!function_exists('com_password'))
{
	function com_password($Name,$Placeholder="",$isRequired=FALSE,$CustomClass="",$CustomID="")
	{
		$Required='required=""';
		if($isRequired==FALSE)
		{
			$Required='';
		}
		if(empty($Placeholder))
		{
			$Placeholder="Entri ".$Name;
		}
		
		if(empty($CustomID))
		{
			$CustomID=$Name;
		}
		
		$o='
		<div class="input-group">
		  <input type="password" name="'.$Name.'" id="'.$CustomID.'" class="form-control '.$CustomClass.'" placeholder="'.$Placeholder.'" '.$Required.' value="'.old($Name).'">
		  <span class="input-group-btn">
		    <button class="btn btn-default" tabindex="-1" type="button" password-trigger="'.$CustomID.'" password-stat=0>
		    	<i class="fa fa-eye"></i>
		    </button>
		  </span>
		</div>
		';
		return $o;
	}
}

if(!function_exists('com_datepicker'))
{
	function com_datepicker($Name='tanggal',$Placeholder="",$isRequired=FALSE,$DefaultValue="",$CustomClass="",$CustomID="")
	{
		$Required='required=""';
		if($isRequired==FALSE)
		{
			$Required='';
		}
		if(empty($Placeholder))
		{
			$Placeholder="Tanggal";
		}
		
		if(empty($DefaultValue))
		{
			$DefaultValue=date_now(FALSE);
		}
		
		if(empty($CustomClass))
		{
			$CustomClass='tanggal';
		}
		
		if(empty($CustomID))
		{
			$CustomID=$Name;
		}
		
		$o='
		<div class="input-group">
		  <input type="text" name="'.$Name.'" id="'.$CustomID.'" class="form-control '.$CustomClass.'" '.$Required.' placeholder="'.$Placeholder.'" value="'.$DefaultValue.'">
		  <span class="input-group-btn">
		    <button class="btn btn-default" tabindex="-1" type="button" date-trigger="'.$CustomID.'">
		    	<i class="fa fa-calendar"></i>
		    </button>
		  </span>
		</div>
		';
		return $o;
	}
}