<?php

namespace App\Http\Controllers\Core\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AccessController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            if(user_group_name()=='superadmin')
            {
                $name = $request->input('name');
                $title = $request->input('title');
                $query=DB::table('page_access')->where('route_name',$name);
                
                if($query->count() < 1)
                {
                    DB::table('page_access')->insert([
                        'title_page'=>$title,
                        'route_name'=>$name
                    ]);
                }
                $data = $query->first();
                $group_access=[];
                $group=DB::table('user_groups')->whereNotIn('id',[1])->get();
                if(!empty($group))
                {
                    foreach($group as $g)
                    {
                        $group_access[]=[
                            'group_id'=>$g->id,
                            'group_name' => $g->group_name,
                            'group_value'=>$g->group_value,
                            'access'=>$this->check_access($g->id,$data->id)
                        ];
                    }
                }
                
                $view = view('core.access.index', compact('name', 'title','data', 'group_access'));
                echo $view->render();
            }
        }
    }

    public function update(Request $request)
    {
        if($request->ajax())
        {
            $name = $request->input('name');
            $title = $request->input('title');
            $group = $request->input('user_group');
            $query = DB::table('page_access')->where('route_name', $name);

            if ($query->count() < 1) {
                DB::table('page_access')->insert([
                    'title_page' => $title,
                    'route_name' => $name
                ]);
            }
            $data = $query->first();
            DB::table('page_access_detail')->where('page_access_id', $data->id)->delete();
            if(!empty($group))
            {
                
                
                foreach($group as $r)
                {
                    DB::table('page_access_detail')->insert([
                        'page_access_id'=>$data->id,
                        'user_group_id'=>$r
                    ]);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Success'
                ]);
            }else{
                
                return response()->json([
                    'status'=>true,
                    'message'=>'No Access for user group, except Super Administrator'
                ]);
            }
        }else{
            die('Not Ajax Request');
        }
    }

    private function check_access($groupID,$accessID)
    {
        $check=DB::table('page_access_detail')->where('page_access_id',$accessID)->where('user_group_id',$groupID)->count();
        if($check)
        {
            return true;
        }else{
            return false;
        }
    }
}
