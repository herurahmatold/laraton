<?php

namespace App\Http\Controllers\Core\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Core\AuthLoader;

class LogoutController extends Controller
{
    public function index()
    {
        $AuthLoader=new AuthLoader();
        $AuthLoader->logout();
        return laralogin();
    }

}
