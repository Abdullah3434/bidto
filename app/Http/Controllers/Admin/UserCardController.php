<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Redirect;
use Session;
use App\Models\UserCard;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class UserCardController extends Controller
{
    public function view_cards($id) 
        {
            $ifexist = UserCard::where([
                'user_id' => $id
            ])->orderby('id', 'desc')->get();
          
            return view('admin.user_card.view_cards' , compact('ifexist'));

        }   

    public function status($status,$id)
        {
   
            if($status=='active')
                {
                    $status='in_active';
                }
            elseif($status=='in_active')
                {
                    $status='active';
                }
                if($status=='in_active')
                {
                    $message='In Active';
                }
                elseif($status=='active')
                {
                    $message='Active';
                }

            $update= UserCard::where('id', $id)->update(['status' => $status]);
            Session::flash('success', 'Status '.$message); 
            return Redirect::back();
  
        }

    public function edit_card_view($id,$user_id) 
        {
     
            $ifexist = UserCard::where([
                        'id' => $id
                        ])->first();
            $originalDate = "01-".$ifexist->card_expiry;

            $ifexist->card_expiry =  date("Y-m", strtotime($originalDate));
            
            return view('admin.user_card.edit_card' , compact('ifexist','user_id'));

        }

    public function edit_card(Request $request,$id,$user_id)
        {
            $rules = [
                        
                'name' => 'required',
                'card_number' => 'required|unique:user_cards',
                'card_cvv' => 'required|unique:user_cards',
                'card_expiry' => 'required',
            ];
            $this->validate($request, $rules);

            $name = $request->input('name');
            $card_number=$request->input('card_number');
            $card_cvv = $request->input('card_cvv');
            $expiry = $request->input('card_expiry');
            $card_expiry= date("m-Y", strtotime($expiry));
           
            // return $card_number; 
         
            $cvv=   UserCard::where('id',$id)->first();
            $cvv2=  $cvv->card_cvv;

            $card_cvv2=$request->input('card_cvv2');
            $card_cvv3= substr($card_cvv2,-1);
            $card_cvv4= "*****$card_cvv3";

                if ($cvv2==$card_cvv2)
                {
                    UserCard::where('id',$id)->update(
                        [
                            
                            'card_holder_name'=> $name,
                           
                            'card_expiry'=> $card_expiry,
                
                        ]);
                }else{
                    UserCard::where('id',$id)->update(
                        [
                            'card_holder_name'=> $name,
                            'card_cvv'=> $card_cvv,
                            
                            'card_expiry'=> $card_expiry,
                
                        ]);
                }

             $nomber=   UserCard::where('id',$id)->first();
            $number1=  $nomber->card_number;
        //    return $number1;
            $card_number2=$request->input('card_number2');
            // return $card_number2;
            $card_number3= substr($card_number2,-4);
            $card_number4= "*****$card_number3";

                if ($number1=$card_number2)
                {
                    UserCard::where('id',$id)->update(
                        [
                            'card_holder_name'=> $name,
                           
                            'card_expiry'=> $card_expiry,
                
                        ]);
                }else{
                    UserCard::where('id',$id)->update(
                        [
                            'card_holder_name'=> $name,
                            'card_number'=> $card_number,
                            
                            'card_expiry'=> $card_expiry,
                
                        ]);
                }


          
               
            Session::flash('success', 'User Card Edited!'); 
            return redirect('/admin/user/cards/'.$user_id);
        }

    public function delete_card($id) 
        {
            $ifexist = UserCard::where([
            'id' => $id
            ])->delete();
            Session::flash('success', 'User Card Deleted!'); 
            return redirect()->back();

        }
}
