<?php

namespace App\Http\Controllers\Core\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Options;

class GeneralController extends Controller
{
    private $prefix_label=['app'=>'Application','company'=>'Company'];
    
    function index($prefix)
    {
        access_page(array('superadmin'));        
        $get_prefix=$prefix?$prefix:'app';
        $len=strlen($get_prefix);
        $data=Options::whereRaw('LEFT(option_key,'.$len.') = ?',$get_prefix)->get();        
        $count_data=count($data);
        if($count_data < 1)
        {
            return message_header('dashboard','error','Configuration Not Found');
        }
        return laraview('core.config.general',['title'=>strtr($get_prefix,$this->prefix_label).' Configuration'],compact('data','get_prefix'));
    }

    function update(Request $request)
    {
        access_page(array('superadmin'));
        $prefix=$request->input('prefix');
        $item=$request->input('item');
        foreach($item as $k=>$v)
        {
            Options::where('option_key',$k)->update(['option_value'=>$v]);
        }
         return message_header('core.config.general','success','Configuration Update',$prefix);
    }

}
