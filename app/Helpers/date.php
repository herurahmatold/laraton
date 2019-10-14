<?php

if(!function_exists('date_now'))
{
	/**
	 * Get Date current Format Y-m-d or Y-m-d H:i:s
	 *
	 * @param   [Boolean]  $time  [$time With Time]
	 *
	 * @return  [String]         [Y-m-d or Y-m-d H:i:s]
	 * 
	 * Author Heru Rahmat Akhnuari
	 * 12 Okt 2019
	 */
	function date_now($time=FALSE)
	{
		date_default_timezone_set('Asia/Jakarta');
		$str_format='';
		if($time==FALSE)
		{
			$str_format= date("Y-m-d");
		}else{
			$str_format= date("Y-m-d H:i:s");
		}
		return $str_format;
	}
}

if(!function_exists('time_now'))
{
	/**
	 * Get Time current Format H:i:s
	 *
	 * @return  [String]         [H:i:s]
	 * 
	 * Author Heru Rahmat Akhnuari
	 * 12 Okt 2019
	 */
	function time_now()
	{
		date_default_timezone_set('Asia/Jakarta');
		$dd=date("H:i:s");
		return $dd;
	}
}

if(!function_exists('date_add_day'))
{
	/**
	 * Add Date
	 *
	 * @param   [Date Time]  $tgl  [Set Date]
	 *
	 * @param  [Integer]         [Set how many day to add]
	 * 
	 * @return [String] 2019-10-12 Add 1 Day 2019-10-13
	 * Author Heru Rahmat Akhnuari
	 * 12 Okt 2019
	 */
	function date_add_day($tgl,$days)
	{
		$date = new DateTime($tgl);
		$date->add(new DateInterval('P'.$days.'D'));
		$Date2 = $date->format('Y-m-d');
		return $Date2;
	}
}

if(!function_exists('date_prev_day'))
{
	/**
	 * Prev Date
	 *
	 * @param   [Date Time]  $tgl  [Set Date]
	 *
	 * @param  [Integer]         [Set how many day]
	 * 
	 * @return [String] 2019-10-12 Prev 1 Day 2019-10-11
	 * Author Heru Rahmat Akhnuari
	 * 12 Okt 2019
	 */
	function date_prev_day($tgl,$days)
	{
		$date = new DateTime($tgl);
		$date->add(new DateInterval('P -'.$days.'D'));
		$Date2 = $date->format('Y-m-d');
		return $Date2;
	}
}

if(!function_exists('date_add_minute'))
{
	function date_add_minute($tgltime,$minute,$style="next")
	{
		$date = date_create($tgltime);
		if($style=="prev")
		{
			date_modify($date, '-'.$minute.' minute');
		}elseif($style=="next"){
			date_modify($date, '+'.$minute.' minute');
		}
		return date_format($date, 'Y-m-d H:i:s');
	}
}

if(!function_exists('date_indo'))
{
	/**
	 * Date Indo (Data Indonesia)
	 *
	 * @param   [Date Time]  $tgl  [Set Date]
	 *
	 * @param  [Boolean]         [With Time]
	 * 
	 * @return [String] 2019-10-12 -> 12 Oktober 2019
	 * Author Heru Rahmat Akhnuari
	 * 12 Okt 2019
	 */
	function date_indo($tanggal,$time=FALSE)
	{
		$def=$tanggal;
		$format = array(
		'Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 'Apr' => 'April', 'May' => 'Mei', 'Jun' => 'Juni', 'Jul' => 'Juli', 'Aug' => 'Agustus', 'Sep' => 'September', 'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember'
		);				
		if(!empty($tanggal))
		{
			$tanggal = date('d M Y', strtotime($tanggal));
			$ft= strtr($tanggal, $format);
		
			if($time==TRUE)
			{
				$xdef=explode(" ",$def);
				if(count($xdef) > 0)
				{
					return $ft." ".$xdef[1];
				}else{
					return $ft;
				}
			}else{
				return $ft;
			}
		}else{
			return "-";
		}	
	}
}

if(!function_exists('date_days_month'))
{
	/**
	 * Get Count days of month
	 *
	 * @param   [Integer]  $bulan  [Month Integer]
	 * @param   [Integer]  $tahun  [Year Integer]
	 *
	 * @return  [Integer]          [return Januari is 31]
	 */
	function date_days_month($bulan,$tahun) 
	{	    
	    $numDays = cal_days_in_month (CAL_GREGORIAN,$bulan,$tahun);
	    return $numDays;
	}
}