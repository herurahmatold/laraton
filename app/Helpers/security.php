<?php
use App\Libraries\Core\Security;

function xss_clean($string, $is_image = FALSE)
{
    $security=new Security();
    return $security->xss_clean($string,$is_image);
}