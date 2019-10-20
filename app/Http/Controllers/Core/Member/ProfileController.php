<?php

namespace App\Http\Controllers\Core\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Core\UserLib;

class ProfileController extends Controller
{
    
    public function index()
    {
        return laraview('core.member.profile',['title'=>'User Profile']);
    }

    public function profile_update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        if($validatedData)
        {
            $userid=user_info('id');
            $UserLib=new UserLib();
            $name=$request->input('name');
            $email=$request->input('email');
            $password_old=$request->input('p1');
            $password_new=$request->input('p2');
            $password_confirm=$request->input('p3');
            $action=$UserLib->user_edit($userid,$name,$email,$password_old,$password_new,$password_confirm);
            if($action['status']==TRUE)
            {
                return message_header('user.profile',$action['type'],$action['message']);
            }else{
                return message_header('user.profile',$action['type'],$action['message']);    
            }
        }else{
            return message_header('user.profile','error','Validate Error');
        }
    }

    public function avatar_update(Request $request)
    {
        $userid=user_info('id');

        if ($request->hasFile('file')) 
        {
            $image=$request->file('file');
            if ($image->isValid()) 
            {
                $UserLib=new UserLib();
                $action=$UserLib->user_change_avatar($userid);
                if($action)
                {
                    
                    return response()->json(['status'=>true,'message'=>'Success Upload','img'=>$action['img']]);
                }else{
                    return response()->json(['status'=>false,'message'=>'System Error']);
                }
            }else{
                return response()->json(['status'=>false,'message'=>'Invalid Image']);
            }
        }else{
            return response()->json(['status'=>false,'message'=>'File not upload']);
        }
    }
}
