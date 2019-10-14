<?php

namespace App\Http\Controllers\Core\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Core\AuthLoader;

class LoginController extends Controller
{
    public function index()
    {
        $AuthLoader=new AuthLoader();
        if($AuthLoader->has_login())
        {
            return redirect()->route('dashboard');
        }
        return laralogin();
    }

    public function check_login(Request $request)
    {
        $validation = [
            'username' => 'required',
            'password' => 'required'
        ];

        $message    = [
            'required' => ':attribute should not be empty',
        ];

        $names      = [
            'username' => 'Username',
            'password' => 'Password'
        ];

        $this->validate($request, $validation, $message, $names);

        $AuthLoader=new AuthLoader();
        $action=$AuthLoader->login($request->username,$request->password);
        if($action['status']==TRUE)
        {
            return redirect()->route('dashboard');
        }else{
            return back()->withInput($request->flashExcept('login_error'))->with('error', $action['message']);
        }
    }
}
