<?php
namespace App\Libraries\Core;


class File
{
    function create_directory($path,$rewrite=TRUE)
	{
		if($rewrite==TRUE){
			return is_dir($path) || mkdir($path,0755);
		}else{
			return is_dir($path) || mkdir($path,0644);
		}
	     
    }
    
    function remove_directory($dir,$subfolder=FALSE)
	{
		if($subfolder==TRUE){
			$this->deleteAll($dir,TRUE);
			return rmdir($dir);
		}else{
			return rmdir($dir);
		}
		
	}

}