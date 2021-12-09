<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Log;
class ApiResponse
{

    protected static function getFacadeAccessor()
    {

        return 'apiresponse';
    }

    public static function successResponse($type, $message, $data = null, $extra_param = [])
    {

        $successResponseData = [];

        $successResponseData['status'] = true;
        switch ($type) {

            case 'SUCCESS':

                //$successResponseData['code'] = HttpCode::SUCCESS;
                $successResponseData['message'] = $message;
                if(!empty($extra_param)){
                    foreach($extra_param as $key => $row){
                        $successResponseData[$key] = $row;
                    }
                }

                $successResponseData['data'] = $data;

                break;

            default:
                break;
        }
        return $successResponseData;
    }

    public static function errorResponse($type, $message, $data = null)
    {

        $errorResponseData = [];

        $errorResponseData['status'] = false;
        $errorResponseData['message'] = $message;
        $errorResponseData['data'] = $data;
        return $errorResponseData;
        /*switch ($type) {

            case 'VALIDATION_ERROR':

                $errorResponseData['code'] = HttpCode::VALIDATION_FIALED;
                $errorResponseData['message'] = $message;
                $errorResponseData['data'] = $data;

                break;

            case 'UNAUTHORIZED_ERROR':

                $errorResponseData['code'] = HttpCode::UNAUTHORIZED;
                $errorResponseData['message'] = $message;
                $errorResponseData['data'] = $data;

                break;

            case 'SERVER_ERROR':

                $errorResponseData['code'] = HttpCode::SERVER_ERROR;
                $errorResponseData['message'] = $message;
                $errorResponseData['data'] = $data;

                break;


            case 'BAD_REQUEST':

                $errorResponseData['code'] = HttpCode::BAD_REQUEST;
                $errorResponseData['message'] = $message;
                $errorResponseData['data'] = $data;

                break;

            case 'ATTEMPT_TIMEOUT':

                $errorResponseData['code'] = HttpCode::ATTEMPT_TIMEOUT;
                $errorResponseData['message'] = $message;
                $errorResponseData['data'] = $data;

                break;

            default:
                break;

        }*/

    }
}
