<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\Libraries\Core\AuthLoader;

class CheckAuthentication
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
            $route_name=$request->route()->getName();
            $no_access=laraconfig('global', 'route_no_access');
            if(!in_array($route_name,$no_access))
            {
                $check_access = $auth->check_access_route($route_name);
                if ($check_access == true) {
                    return $next($request);
                } else {
                    return redirect()->route('dashboard')->with('error', 'Not Authentication');
                }
            }else{
                return $next($request);
            }
        }else{
            return redirect()->route('login')->with('error', 'You must login first!');
        }
        
    }
}
