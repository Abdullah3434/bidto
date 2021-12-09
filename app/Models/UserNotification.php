<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class UserNotification extends Model
{
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['subject', 'message', 'is_send', 'is_read', 'from_id' , 'to_id', 'item_id', 'bid_id', 'type'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The attributes that should be appended with mass assignable array.
     *
     * @var array
     */

    protected $appends = ['ios_user_notification_id', 'added_date_format', 'updated_date_format'];

    /**
     *  id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosUserNotificationIdAttribute()
    {
        return $this->attributes['id'];
    }

    public function getAddedDateFormatAttribute(){
        return date('d F Y', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedDateFormatAttribute(){
        return date('d F Y', strtotime($this->attributes['updated_at']));
    }

    public function item()
    {
        return $this->belongsTo(Item::class,'item_id');
    }

    public function from_user()
    {
        return $this->belongsTo(User::class,'from_id');
    }

    public function to_user()
    {
        return $this->belongsTo(User::class,'to_id');
    }
}
