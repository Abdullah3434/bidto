<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Session;
use App\Facades\ApiResponse;
use Illuminate\Support\Facades\Lang;
class IsActiveForApi
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
        if (Auth::user()->status!='active') {
            $responseMessage = Lang::get('api.You can not proceed this action.');
            return response()->json(['status'=>false, 'message' => $responseMessage,'data'=>null], 400);
        }else{
            return $next($request);
        }
    }
}
