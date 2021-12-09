<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
//use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_name', 'user_email', 'user_phone', 'password', 'user_image', 'lang_key', 'user_balance', 'user_otp', 'user_google_key',
        'user_facebook_key', 'user_apple_key', 'status', 'is_verified', 'is_online', 'last_login_ip', 'otp_date_time', 'otp_token', 'promotion_ads', 
        'promotion_days'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'email_verified_at',
        'remember_token',
    ];
 /**
     * The attributes that should be appended for serialization.
     *
     * @var array
     */
    protected $appends = ['ios_user_id', 'added_date_format', 'updated_date_format', 'user_balance_format', 'full_image', 'thumb_image', 'avg_rating'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosUserIdAttribute()
    {
        return $this->attributes['id'];
    }
    /**
     * registered or create date format attribute.
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
    /**
     * user balance formatted attribute.
     *
     *  var string
     */
    public function getUserBalanceFormatAttribute()
    {
        //if ($this->attributes['user_balance']) {
            return number_format($this->attributes['user_balance'], 2);
       // }else{
            return 0.00;
      //  }
    }
     /**
     * full image path attribute which is in appended array.
     *
     *  var string
     */
    public function getFullImageAttribute()
     {
         $image_name = 'no_user_image.png';
         if ($this->attributes['user_image']) {
             $image_name = $this->attributes['user_image'];
         }
         return checkImage('users/' . $image_name);
     }
     /**
     * thumb image path attribute which is in appended array.
     *
     *  var string
     */
     public function getThumbImageAttribute()
     {
         $image_name = 'no_user_image.png';
         if ($this->attributes['user_image']) {
             $image_name = $this->attributes['user_image'];
         }
         return checkImage('users/thumbs/' . $image_name);
     }

     public function getAvgRatingAttribute(){

        $rating =  $this->hasMany(UserReview::class, 'to_id')->avg('rating');
        return number_format((float)($rating), 2, '.', '');
    }

     public function logs()
     {
         return $this->hasMany(LoginLog::class,'user_id');
     }

     public function devices()
     {
         return $this->hasOne(UserDevice::class,'user_id');
     }

     public function language()
     {
         return $this->belongsTo(Language::class,'lang_key', 'lang_key');
     }

     public function reviews(){
        return $this->hasMany(Review::class,'user_id');
     }

     public function cards(){
        return $this->hasMany(UserCard::class,'user_id');
     }

     public function favorites(){
        return $this->hasMany(UserFavorite::class,'user_id');
     }
 
     public function transactions(){
        return $this->hasMany(UserTransaction::class,'user_id');
     }
}
