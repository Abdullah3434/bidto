<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Log;
class EmailTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email_name', 'email_subject', 'email_key', 'email_content', 'lang_key'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    /**
     * The attributes that should be appended for serialization.
     *
     * @var array
     */
    protected $appends = ['ios_email_id', 'added_date_format', 'updated_date_format'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosEmailIdAttribute()
    {
        return $this->attributes['id'];
    }
    /**
     * create date format attribute.
     *
     *  var string
     */

    public function getAddedDateFormatAttribute()
    {
        return date('Y-M-d H:i', strtotime($this->attributes['created_at']));
    }
    /**
     * update date format attribute.
     *
     *  var string
     */

    public function getUpdatedDateFormatAttribute()
    {
        return date('Y-M-d H:i', strtotime($this->attributes['updated_at']));
    }

    public function sendEmail($email)
    {
        try {
            $email['email_footer'] = settingValue('email_footer');
            $custom_email['from_email']  = env('MAIL_FROM_ADDRESS')?env('MAIL_FROM_ADDRESS'):'info@bidto.com';
            $custom_email['from_name'] = env('MAIL_FROM_NAME')?env('MAIL_FROM_NAME'):'BidTo';
           // Log::info($email);
            Mail::send('mail.mail_body',$email, function ($message) use ($email, $custom_email) {


                $message->from((isset($email['from_email']) ? $email['from_email'] :  $custom_email['from_email']), $name = (isset($email['from_name']) ? $email['from_name'] :  $custom_email['from_name']));

                $message->to($email['email_to'], $email['email_to'])->subject($email['email_subject']);

                if(isset($email['email_cc'])){
                    $message->cc($email['email_cc']);
                }

            });
        }catch (Exception $e) {
            Log::info($e->getMessage());
            echo $e->getMessage();die();
        }
    }
}
