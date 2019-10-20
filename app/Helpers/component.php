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