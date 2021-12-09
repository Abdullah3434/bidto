<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'card_number', 'card_expiry', 'card_cvv', 'card_holder_name', 'status', 'card_type'
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
    protected $appends = ['ios_card_id', 'added_date_format', 'updated_date_format', 'card_image'];

    /**
     * user id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosCardIdAttribute()
    {
        return $this->attributes['id'];
    }
    /**
     * user registered or create date format attribute.
     *
     *  var string
     */

    public function getAddedDateFormatAttribute()
    {
        return date('Y-M-d H:i', strtotime($this->attributes['created_at']));
    }
    /**
     * user update date format attribute.
     *
     *  var string
     */

    public function getUpdatedDateFormatAttribute()
    {
        return date('Y-M-d H:i', strtotime($this->attributes['updated_at']));
    }

    /**
     * full image path attribute which is in appended array.
     *
     *  var string
     */
    public function getCardImageAttribute()
     {
         $image_name = 'no_ad_image.png';
         if ($this->attributes['card_type']) {
             $image_name = $this->attributes['card_type'].'.png';
         }
         return checkImage('cards/' . $image_name);
     }
    
    public function user()
     {
         return $this->belongsTo(User::class,'user_id');
     }
}
