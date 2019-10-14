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
            return $next($request);
        }else{
            return redirect()->route('login')->with('error', 'You must login first!');
        }
        
    }
}
