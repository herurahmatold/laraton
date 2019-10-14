<?php

if ( ! function_exists('string_array_multi_sort_by_column')) 
{	
    /**
     * SORT ARRAY
     *
     * @param   [array]  &$arr  Array data
     * @param   [column]  $col   Colum Specified
     * @param   [SORT]  $dir   [SORT_ASC or SORT_DESC]
     *
     * @return  [array]        array(array('A'=>50),array('B'=>100)) to array(array('B'=>100),array('A'=>50))
     */
	function string_array_multi_sort_by_column(&$arr, $col, $dir = SORT_ASC)
	{
		if (empty($col) || ! is_array($arr)) {
			return false;
		}
		$sortCol = array();
		foreach ($arr as $key => $row) {
			$sortCol[$key] = $row[$col];
		}
		array_multisort($sortCol, $dir, $arr);
	}
}

if(!function_exists('string_create_random'))
{
    /**
     * Create Random Text
     *
     * @param   [integer]  $length  Length of string
     * @param   [boolean]  $huruf   [Alphabet include]
     *
     * @return  [Random String]
     */
	function string_create_random($length=20,$huruf=FALSE)
	{
		$idformat='';
		if(empty($huruf) || $huruf==FALSE)
		{
			$idformat= substr(str_shuffle("0123456789"), 0, $length);
		}else{
			$idformat= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		}

		return $idformat;
	}
}

if ( ! function_exists('string_implode_array'))
{
    /**
     * Implode String
     *
     * @param   [array]  $attributes  Array Data
     *
     * @return  [string] array('data-id'=>'abc') to data-id="abc"
     */
	function string_implode_array($attributes)
	{
		if (empty($attributes))
		{
			return '';
		}

		if (is_object($attributes))
		{
			$attributes = (array) $attributes;
		}

		if (is_array($attributes))
		{
			$atts = '';

			foreach ($attributes as $key => $val)
			{
				$atts .= ' '.$key.'="'.$val.'"';
			}

			return $atts;
		}

		if (is_string($attributes))
		{
			return ' '.$attributes;
		}

		return FALSE;
	}
}

if(!function_exists('string_create_slug'))
{
    /**
     * Create Slug
     *
     * @param   [string]  $text  String Value
     *
     * @return  [string]         Aku Cinta Indonesia to aku-cinta-indonesia
     */
	function string_create_slug($text)
	{	  
	  if (empty($text))
	  {
		return '';
	  }else{
	  	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	  	$text = trim($text, '-');
	  	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	  	$text = strtolower($text);
	  	$text = preg_replace('~[^-\w]+~', '', $text);
	  	return $text;
	  }
	  
	}
}