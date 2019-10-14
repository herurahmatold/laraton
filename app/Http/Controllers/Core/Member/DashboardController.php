<?php

namespace App\Http\Controllers\Core\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return laraview('core.layouts.dashboard',array('title'=>'Dashboard'));
    }

    function index_tes()
    {
        return message_header('dashboard','success','Halooo');
    }
}
