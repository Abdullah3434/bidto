<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Redirect;
use Session;
use App\Models\UserTransaction;
use Illuminate\Support\Facades\Storage;

class UserBalanceController extends Controller
{
    public function view_transactions($id) 
        {
            $ifexist = UserTransaction::where([
                'user_id' => $id
            ])->where('transaction_type', '!=', "post_item")->get();
        // return $ifexist;
            return view('admin.user_transaction.view_transactions' , compact('ifexist'));

        }    
    public function edit_transaction_view($id,$user_id) 
        {
 
            $ifexist = UserTransaction::where([
                        'id' => $id
                            ])->first();

            $transaction_types = UserTransaction::select('*')
            ->where('transaction_type', '=', $ifexist->transaction_type)
            ->get();
            
                if($transaction_types[0]->transaction_type=='add_balance')
                    {
                        $transaction_type='purchase_promotion';
                    }
                else
                    {
                        $transaction_type='add_balance';
                    }
            
            return view('admin.user_transaction.edit_transaction' , compact('transaction_type','ifexist','user_id'));

        }
    public function edit_transaction(Request $request,$id,$user_id)
        {
 
            $balance = $request->input('balance');
            $transaction_type = $request->input('transaction_type');
    
            UserTransaction::where('id',$id)->update(
                [
                    'amount'=> $balance,
                    'transaction_type'=> $transaction_type,
        
                ]);
           
            Session::flash('success', 'User Transaction Edited!'); 
            return redirect('/admin/user/transactions/'.$user_id);
        }

    public function delete_transaction($id) 
        {
            $ifexist = UserTransaction::where([
            'id' => $id
            ])->delete();
            Session::flash('success', 'User Transaction Deleted!'); 
            return redirect()->back();

        }
}
