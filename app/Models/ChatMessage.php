<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class ChatMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'thread_id', 'item_id', 'from_id', 'to_id', 'message', 'is_read'
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
    protected $appends = ['ios_message_id', 'added_date_format', 'updated_date_format', 'readable_date_time'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosMessageIdAttribute()
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

    /**
     * create date format attribute.
     *
     *  var string
     */

    public function getReadableDateTimeAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    public function thread()
     {
         return $this->belongsTo(ChatThread::class,'thread_id');
     }

     public function item()
     {
         return $this->belongsTo(Item::class,'item_id');
     }

     public function sender()
     {
         return $this->belongsTo(User::class,'from_id');
     }

     public function receiver()
     {
         return $this->belongsTo(User::class,'to_id');
     }
}
