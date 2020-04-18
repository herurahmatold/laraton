<?php
use App\Libraries\Recaptcha;

if(!function_exists('com_recaptcha'))
{
    function com_recaptcha()
    {
        $recaptcha=new Recaptcha();
        return $recaptcha->generate();
    }
}

if(!function_exists('com_month_select'))
{
	function com_month_select($name,$firstvalue='',$att=array())
	{
		$arr=array(
		'1'=>'Januari',
		'2'=>'Februari',
		'3'=>'Maret',
		'4'=>'April',
		'5'=>'Mei',
		'6'=>'Juni',
		'7'=>'Juli',
		'8'=>'Agustus',
		'9'=>'September',
		'10'=>'Oktober',
		'11'=>'November',
		'12'=>'Desember',
		);
		$o='';
		$attribute="";
		if(!empty($att))
		{
			$attribute=string_implode_array($att);
		}
		$o.='<select name="'.$name.'" '.$attribute.'>';
		foreach($arr as $k=>$v)
		{
			$js='';
			if($firstvalue==$k)
			{
				$js=' selected="selected"';
			}
			$o.='<option value="'.$k.'"'.$js.'>'.$v.'</option>';
		}
		$o.='</select>';
		return $o;
	}
}

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
		  <input type="password" name="'.$Name.'" id="'.$CustomID.'" minlength="6" class="form-control '.$CustomClass.'" placeholder="'.$Placeholder.'" '.$Required.' value="'.old($Name).'">
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