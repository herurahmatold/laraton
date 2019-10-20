<?php
namespace App\Libraries\Core;

use App\Models\Core\Options;


class Laraton
{
    public function option_get($key)
    {
        $output='';
        $item=Options::where('option_key',$key)->select('option_value')->first();
        if(!empty($item))
        {
            $output=$item->option_value;
        }

        return $output;
    }

    public function version()
    {
        return $this->option_get('app_version');
    }

    public function get_logo($type,$size='')
    {
        $path=laraconfig('global','upload_path');
        $url=laraconfig('global','upload_url');
        $default=laraconfig('global','logo');
        $avatar=option_get($type);
        $file_path=$path.$avatar;
        $file_url=$url.$avatar;
        if(!empty($size))
        {
            $file_path=$path.'/thumbs/'.$size.'/'.$avatar;
            $file_url=$url.'/thumbs/'.$size.'/'.$avatar;
        }
        if(file_exists($file_path) && is_file($file_path))
        {
            $default=$file_url;
        }

        return $default;
    }

    

}