<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class Localization
{
    public function handle($request, Closure $next)
    {

        $default_lang = Config::get('app.fallback_locale');

        $value = session()->get('lang_key');

        if($value!=''){
            App::setLocale($value);
            return $next($request);
        }
        else if($request->hasHeader('language')){

            App::setLocale($request->header('language'));
            return $next($request);

        }
        else{
            App::setLocale($default_lang);
            return $next($request);
        }

    }
}

