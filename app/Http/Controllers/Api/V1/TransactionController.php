<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Validator;
use Illuminate\Support\Carbon;
use Hash;
use Auth;
use File;

use App\Models\UserTransaction;
use App\Models\User;
class TransactionController extends Controller
{

    /**
     * transaction listing
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getMyTransaction(Request $request)
    {
        $authenticated_user  = Auth::user();
        try {

            $transactions = UserTransaction::with('user', 'user.language', 'item', 'item.user', 'item.photos', 'item.category')
                                            ->where('user_id', $authenticated_user->id);

            $page  = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : 10;
           
            $transactions = $transactions->orderby('id', 'desc')
                                        ->limit($limit)
                                        ->offset(($page - 1) * $limit)
                                        ->paginate($limit);

            $data['user_balance'] = 0.00;
            $exist_user = User::where('id', $authenticated_user->id)->first();
            if($exist_user){
                $data['user_balance'] = $exist_user->user_balance;
            }
                                    
            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $transactions, $data);

        } catch (\Exception $e) {
            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
        }
    }

}
