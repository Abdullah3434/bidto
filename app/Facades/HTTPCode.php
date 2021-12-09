<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class HttpCode
{

    /*
  * HTTP Status Codes
  *
  */

    protected static function getFacadeAccessor()
    {
        return 'httpcode';
    }

    const PAG_NOT_FOUND = 404;
    const UNAUTHORIZED = 401;
    const BAD_REQUEST = 400;
    const VALIDATION_FIALED  = 422;
    const SERVER_ERROR = 500;
    const SUCCESS = 200;
    const TOO_MANY_REQUESTS = 429;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const GATEWAY_TIMEOUT = 504;
    const ATTEMPT_TIMEOUT = 235;
}
