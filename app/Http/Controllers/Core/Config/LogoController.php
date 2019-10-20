<?php

namespace App\Http\Controllers\Core\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Core\Laraton;

class LogoController extends Controller
{
    function index()
    {
        return laraview('core.config.logo',['title'=>'Logo & Favicon']);
    }

    function update(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required',
        ]);
        $type=$request->input('type');
        if($validatedData)
        {
            if ($request->hasFile($type)) 
            {
                $image=$request->file($type);
                if ($image->isValid()) 
                {
                    $laraton=new Laraton();
                    $action=$laraton->app_change_logo($type);
                    if($action)
                    {
                        return message_header('core.config.logo','success','Success Update '.$type);
                    }else{
                        return message_header('core.config.logo','error','System Error');
                    }
                }else{
                    return message_header('core.config.logo','error','Invalid Image');
                }
            }else{
                return message_header('core.config.logo','error','File not upload');
            }
        }else{
            return message_header('core.config.logo','error','Error Type Logo');
        }
	}
}
