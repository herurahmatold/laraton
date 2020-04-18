<?php

namespace App\Http\Controllers\Core\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Core\Users;
use App\Libraries\Core\UserLib;

class UserController extends Controller
{
    private $status=[0=>'Non Active',1=>'Active'];
    public function index()
    {
        return laraview('core.users.user.index',['title'=>'User Manager'],['status'=>$this->status]);
    }

    public function get_data(DataTables $dt,Request $request)
    {
        $user_table='laraton_users';
        $group_table = 'laraton_user_groups';
        $query=Users::select($user_table.'.id as id', $user_table.'.name as nama', $group_table.'.group_value as group', $user_table.'.email as email', $user_table.'.status as status')
    		->leftJoin($group_table.'', $user_table.'.user_group_id','=', $group_table.'.id')
            ->where($user_table.'.isDeleted','=',0)
            ->where($user_table.'.user_group_id','!=',1);
		if($request->input('status') !='')
		{
			$query->where($user_table.'.status',$request->input('status'));
        }
        if(!empty($request->input('group')))
		{
			$query->where($user_table.'.user_group_id',$request->input('group'));
		}
		return $dt->eloquent($query)
				->addColumn('action', function($u){
                    return '<a href="'.route('core.users.user.detail',array('id'=>$u->id)).'" class="btn btn-info btn-xs"><i class="fa fa-book"></i></a> 
                    <a onclick="return confirm(\'Are you sure delete user '.$u->nama.'?\');" href="'.route('core.users.user.delete',array('id'=>$u->id)).'" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a> 
                    ';
				})
				->editColumn('status', function($u){
					return strtr($u->status,$this->status);
				})
                ->toJson();
    }

    public function add()
    {
        return laraview('core.users.user.add',['title'=>'Add User'],['status'=>$this->status]);
    }

    public function store(Request $request)
    {
        if($request->ajax())
        {
            $validatedData = $request->validate([
                'group' => 'required',
                'full_name' => 'required',
                'username' => 'required',
                'email' => 'required',
                'p1' => 'required',
                'p2' => 'required',
                'status' => 'required',
            ]);
            if($validatedData)
            {
                $group=$request->input('group');
                $full_name=$request->input('full_name');
                $username=$request->input('username');
                $email=$request->input('email');
                $p1=$request->input('p1');
                $p2=$request->input('p2');
                $status=$request->input('status');
                $reload=$request->input('reload')?0:1;

                if($p1 == $p2)
                {
                     $userlib= new UserLib();
                
                    $action=$userlib->user_add($group,$full_name,$username,$p1,$email,'',$status);
                    if($action['status']==true)
                    {
                        return response()->json([
                            'status'=>true,
                            'message'=>$action['message'],
                            'reload'=>$reload
                        ]);
                    }else{
                        return response()->json([
                            'status'=>false,
                            'message'=>$action['message']
                        ]);
                    }
                }else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'Invalid Confirmation Password'
                    ]);    
                }
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Validation Error'
                ]);
            }
        }else{
            die('Not Ajax Request');
        }
    }

    public function delete($id)
    {
        $userlib=new UserLib();
        if($userlib->user_delete($id,false)==true)
        {
            return message_header('core.users.user','success','User move trash');
        }else{
            return message_header('core.users.user','error','Failed move to trash');
        }
    }

    public function detail($id)
    {
        $data=Users::where('id',$id)->first();
        if(empty($data))
        {
            return message_header('core.users.user','error','User not found');
        }
        $status=$this->status;
        return laraview('core.users.user.detail',['title'=>'User Detail'],compact('data','status'));
    }

    public function avatar_update($id,Request $request)
    {

        if ($request->hasFile('file')) 
        {
            $image=$request->file('file');
            if ($image->isValid()) 
            {
                $UserLib=new UserLib();
                $action=$UserLib->user_change_avatar($id);
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

    public function user_update (Request $request)
    {
        $validatedData = $request->validate([
            'userid' => 'required',
            'name' => 'required',
            'email' => 'required',
            'group' => 'required',
            'status' => 'required',
        ]);
        if($validatedData)
        {
            $UserLib=new UserLib();
            $userid=$request->input('userid');
            $name=$request->input('name');
            $email=$request->input('email');
            $group=$request->input('group');
            $status=$request->input('status');
            $password_new=$request->input('p2');
            $password_confirm=$request->input('p3');
            $action=$UserLib->user_edit($userid,$name,$email,'',$password_new,$password_confirm,$group,$status);
            if($action['status']==TRUE)
            {
                return message_header('core.users.user.detail',$action['type'],$action['message'],['id'=>$userid]);
            }else{
                return message_header('core.users.user.detail',$action['type'],$action['message'],['id'=>$userid]);
            }
        }else{
            return message_header('core.users.user.detail','error','Validate Error',['id'=>$userid]);
        }
    }
}
