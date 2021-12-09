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

use App\Models\User;
use App\Models\UserReview;
use App\Models\UserCard;
use App\Models\UserTransaction;
use App\Models\UserDevice;
use App\Models\UserFavorite;
use App\Models\UserNotification;
use App\Models\ChatThread;
use App\Models\ChatMessage;
use App\Models\ItemBid;
use App\Models\Item;
use App\Models\ItemField;
use App\Models\ItemView;
use App\Models\ItemPhoto;
class UserController extends Controller
{

    /**
     * profile Info
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function profileInfo(Request $request)
    {
        $authenticated_user  = Auth::user();
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try {
                $exist_user = User::with('language')
                                    ->where('id', $request->user_id)
                                    ->where('status', 'active')
                                    ->first();

                if (!is_null($exist_user)) {
                    unset($exist_user->user_otp);
                    unset($exist_user->otp_date_time);
                    unset($exist_user->last_login_ip);
                    unset($exist_user->otp_token);
                    unset($exist_user->password);

                    if($authenticated_user->id!=$request->user_id){
                        unset($exist_user->user_google_key);
                        unset($exist_user->user_facebook_key);
                        unset($exist_user->user_apple_key);
                        $exist_user->user_balance = 0.00;
                    }
                   

                    $responseMessage = Lang::get('api.Records have been found.');
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, $exist_user);


                } else {
                    $responseMessage = Lang::get('api.No record found.');
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                }
            } catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }
    }
     /**
     * add Review
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function addReview(Request $request)
    {
        $authenticated_user = Auth::user();
    
        $rules['user_id'] = ['required','exists:users,id', function ($attribute, $value, $fail) use ($authenticated_user, $request) {
            if ($request->get('user_id')== $authenticated_user->id) {
                return $fail(__(Lang::get('api.You can not review on your own profile.')));
            }
        }];
            
        $rules['rating'] = 'required|numeric|between:0,5';
        $rules['comment'] = 'required|string';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
           
            try{
                $review = UserReview::where([
                        ['to_id' , $request->user_id],
                        ['from_id' , $authenticated_user->id]
                    ])->first();

                if (is_null($review)) {

                    $create_review['to_id'] = $request->user_id;
                    $create_review['from_id'] = $authenticated_user->id;
                    $create_review['rating'] = $request->rating;
                    $create_review['comment'] = $request->comment;
                    UserReview::create($create_review);

                    $exist_user = User::with('language')
                                    ->where('id', $request->user_id)
                                    ->where('status', 'active')
                                    ->first();

                    if(!is_null($exist_user)){
                        unset($exist_user->user_otp);
                        unset($exist_user->otp_date_time);
                        unset($exist_user->last_login_ip);
                        unset($exist_user->otp_token);
                        unset($exist_user->password);
                        unset($exist_user->user_google_key);
                        unset($exist_user->user_facebook_key);
                        unset($exist_user->user_apple_key);
                        $exist_user->user_balance = 0.00;
                    }
                   
                    $responseMessage = Lang::get('api.Review has been submitted.') ;
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, $exist_user);
                }else{
                    $responseMessage = Lang::get('api.You have already submit review.');
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }
        
            }catch(\Exception $e){

                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }
    /**
     * change Password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function changePassword(Request $request)
    {
        $authenticated_user = Auth::user();
        $rules['old_password'] = ['required', function ($attribute, $value, $fail) use ($authenticated_user, $request) {
            if (!(Hash::check($request->get('old_password'), $authenticated_user->password))) {
                return $fail(__(Lang::get('api.Old password does not match with records.')));
            }
        }];
        $rules['new_password'] =  'required|min:8|same:confirm_password';
       
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                $update_user['password'] = Hash::make($request->new_password);
                User::where('id', $authenticated_user->id)->update($update_user);

                $responseMessage = Lang::get('api.Password has been updated successfully.');
                return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
        
            }catch(\Exception $e){

                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }

   /**
     * change Lnaguage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function changeLanguage(Request $request)
    {
        $rules['language'] =  'required|string|max:191|exists:languages,lang_key';
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                $authenticated_user = Auth::user();
                $update_user['lang_key'] = $request->language;
                User::where('id', $authenticated_user->id)->update($update_user);
                $responseMessage = Lang::get('api.Language has been updated successfully.');
                return ApiResponse::successResponse('SUCCESS', $responseMessage,null);
        
            }catch(\Exception $e){

                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }

    /**
     * delete Account
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function deleteAccount(Request $request)
    {
        try{
            $authenticated_user = Auth::user();
            File::delete(public_path('uploads/users/' . @$authenticated_user->user_image));
            File::delete(public_path('uploads/users/thumbs/' .@$authenticated_user->user_image));
            User::where('id', $authenticated_user->id)->delete();
            UserCard::where('user_id', $authenticated_user->id)->delete();
            UserDevice::where('user_id', $authenticated_user->id)->delete();
            UserFavorite::where('user_id', $authenticated_user->id)->delete();
            UserReview::where('from_id', $authenticated_user->id)->orWhere('to_id', $authenticated_user->id)->delete();
            UserTransaction::where('user_id', $authenticated_user->id)->delete();
            UserNotification::where('to_id', $authenticated_user->id)->orwhere('from_id', $authenticated_user->id)->delete();
            ChatThread::where('from_id', $authenticated_user->id)->orWhere('to_id', $authenticated_user->id)->delete();
            ChatMessage::where('from_id', $authenticated_user->id)->orWhere('to_id', $authenticated_user->id)->delete();
            ItemBid::where('user_id', $authenticated_user->id)->delete();
            $items = Item::where('user_id', $authenticated_user->id)->get();
            foreach($items as $row){
                ItemBid::where('item_id', $row->id)->delete();
                ItemField::where('item_id', $row->id)->delete();
                ItemView::where('item_id', $row->id)->delete();
                $photos = ItemPhoto::where('item_id', $row->id)->get();
                foreach($photos as $single_photo){
                    File::delete(public_path('uploads/items/' . $single_photo->image));
                    File::delete(public_path('uploads/items/thumbs/' . $single_photo->image));
                    $single_photo->delete();
                }

                $row->delete();
            }
            $responseMessage = Lang::get('api.Account has been deleted successfully.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
    
        }catch(\Exception $e){

            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }

    /**
     * 
     *  addCard
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addCard(Request $request){
        $authenticated_user  = Auth::user();

        $rules['card_number'] ='required|max:191|unique:user_cards,card_number';
        $rules['expiry_date'] ='required|date_format:m-Y|after:' . date('m-Y');
        $rules['cvv'] ='required|max:3|unique:user_cards,card_cvv';
        $rules['card_holder_name'] ='required';
        $rules['card_type'] ='required|in:master_card,visa,diners,jcb,discover,american';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try{
                $create_card['card_number'] = $request->card_number;
                $create_card['card_expiry'] = $request->expiry_date;
                $create_card['card_cvv'] = $request->cvv;
                $create_card['card_holder_name'] = $request->card_holder_name;
                $create_card['card_type'] = $request->card_type;
                $create_card['user_id'] = $authenticated_user->id;
                
                
                UserCard::create($create_card);
               
                $responseMessage = Lang::get('api.Card has been added successfully.');
                return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                
            }catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }
    }

    /**
     * 
     *  addAmount
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addAmount(Request $request){
        $authenticated_user  = Auth::user();

        $rules['card_id'] ='required|max:191|exists:user_cards,id';
        $rules['amount'] ='required|regex:/^\d+(\.\d{1,2})?$/';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try{
                $data = null;
                
                $balance = (double)$authenticated_user->user_balance+(double)$request->amount;
                User::where('id', $authenticated_user->id)->update(array('user_balance'=>$balance));
                $data['user_balance'] = $balance;

                $create_transaction['item_id'] = 0;
                $create_transaction['user_id'] = $authenticated_user->id;
                $create_transaction['amount'] = $request->amount;
                $create_transaction['transaction_type'] = 'add_balance';
                UserTransaction::create($create_transaction);
               
               
                $responseMessage = Lang::get('api.Amount has been added successfully.');
                return ApiResponse::successResponse('SUCCESS', $responseMessage, null, $data);
                
            }catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }
    }
    /**
     * 
     *  list Card
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cardList(Request $request){
        $authenticated_user  = Auth::user();
        try{
            $user_cards = UserCard::where('user_id', $authenticated_user->id)->orderby('id', 'desc')->get();
        
            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $user_cards);

        }catch(\Exception $e){

            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
       
    }
}
