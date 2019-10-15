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

}