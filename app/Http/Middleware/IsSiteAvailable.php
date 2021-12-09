<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Session;
use App\Facades\ApiResponse;

class IsSiteAvailable
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
            $responseMessage = settingValue('site_down_message');
            return response()->json(['status'=>false, 'message' => $responseMessage,'data'=>null], 503);
        }else{
            return $next($request);
        }
    }
}
