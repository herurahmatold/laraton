<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\Libraries\Core\AuthLoader;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth=new AuthLoader();
        if ($auth->has_login()) {
            $session_name=laraconfig('global','session_name');
            $group_name=session($session_name)['group_name'];
            if($group_name=='superadmin')
            {
                return $next($request);
            }else{
                return redirect()->route('dashboard')->with('error', 'Not Authentication');
            }
        }else{
            return redirect()->route('login')->with('error', 'You must login first!');
        }
        
    }
}
