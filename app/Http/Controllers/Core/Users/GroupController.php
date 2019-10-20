<?php

namespace App\Http\Controllers\Core\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\UserGroup;
use App\Libraries\Core\UserLib;
use App\Libraries\Core\AuthLoader;

class GroupController extends Controller
{
    public function index()
    {
        access_page(array('superadmin'));

        $data=UserGroup::where('id','!=',1)
            ->orderBy('id','desc')
            ->get();
        return laraview('core.users.group.index',array('title'=>'User Groups'),compact('data'));
    }

    public function get_user_group(Request $request)
    {
        if($request->ajax())
        {
            $keyword=$request->input('q');
            $data=UserGroup::select('id','group_value as value')->where('id','!=',1);
            if(!empty($keyword))
            {
                $data->where('group_value','like','%'.$keyword.'%');
            }
            $final_data=$data->get();
            return response()->json($final_data);
        }else{
            exit('Not Ajax Request');
        }
    }
    
    public function store(Request $request)
    {
        access_page(array('superadmin'));
        $validatedData = $request->validate([
            'name' => 'required',
            'value' => 'required',
        ]);
        if($validatedData)
        {
            $name=$request->input('name');
            $value=$request->input('value');
            $userLib=new UserLib();
            $action=$userLib->user_group_add($name,$value);
            if($action['status']==true)
            {
                    return message_header('core.users.group','success',$action['message']);
            }else{
                    return message_header('core.users.group','error',$action['message']);
            }
        }else {
            return message_header('core.users.group','error','Validation Error');
        }
    }

    public function edit($id)
    {
        access_page(array('superadmin'));
        $data=UserGroup::where('id',$id)->where('id','!=',1)->first(['id','group_name','group_value']);
        if(!$data)
        {
            return message_header('core.users.group','error','User Group Not Exists');
        }

        return laraview('core.users.group.edit',array('title'=>'Edit User Groups'),compact('data'));
    }

    public function update(Request $request)
    {
        access_page(array('superadmin'));
        $validatedData = $request->validate([
           'name' => 'required',
           'value' => 'required',
           'id'=>'required'
       ]);
       if($validatedData)
       {
           $id=$request->input('id');
           $name=$request->input('name');
           $value=$request->input('value');
           $userLib=new UserLib();
           $action=$userLib->user_group_edit($id,$name,$value);
           if($action['status']==true)
           {
                return message_header('core.users.group','success',$action['message']);
           }else{
                return message_header('core.users.group.edit','error',$action['message'],array('id'=>$id));
           }
       }else {
           return message_header('core.users.group','error','Validation Error');
       }
    }

    public function delete($id)
    {
        access_page(array('superadmin'));
        $userLib=new UserLib();
        $action=$userLib->user_group_delete($id);
        if($action['status']==true)
        {
            return message_header('core.users.group','success',$action['message']);
        }else{
            return message_header('core.users.group.edit','error',$action['message'],array('id'=>$id));
        }
    }

}
