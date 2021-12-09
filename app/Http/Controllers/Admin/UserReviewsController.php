<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Redirect;
use Session;
use App\Models\UserReview;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserReviewsController extends Controller
{
    public function view_reviews($id) 
        {
            $ifexist = UserReview::where([
                'to_id' => $id
            ])->orderby('id','desc')->get();
            // return $ifexist;
            return view('admin.user_reviews.view_reviews' , compact('ifexist'));

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

            $update= UserReview::where('id', $id)->update(['status' => $status]);
            Session::flash('success', 'Status '.$message); 
            return Redirect::back();
      
        }
    public function edit_reviews_view($id,$to_id) 
        {
     
            $ifexist = UserReview::where([
                        'id' => $id
                        ])->first();
            
            return view('admin.user_reviews.edit_reviews' , compact('ifexist','to_id'));

        }
    public function edit_reviews(Request $request,$id,$to_id)
        {
     
            $comment = $request->input('comment');
            $rating = $request->input('rating');

            UserReview::where('id',$id)->update(
                [
                    'comment'=> $comment,
                    'rating'=> $rating,
        
                ]);
               
            Session::flash('success', 'Review Edited!'); 
            return redirect('/admin/user/reviews/'.$to_id);
        }
    public function delete_reviews($id) 
        {
            $ifexist = UserReview::where([
                        'id' => $id
                        ])->delete();
            Session::flash('success', 'Review Deleted!'); 
            return redirect()->back();

        }

}
