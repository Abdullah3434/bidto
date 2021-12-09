<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Session;
use App\Facades\ApiResponse;

class IsWebSiteAvailable
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
        if(settingValue('site_is_down')==1){
            return redirect('/under-development');
        }else{
            return $next($request);
        }
    }
}
