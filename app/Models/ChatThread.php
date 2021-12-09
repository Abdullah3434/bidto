<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatThread extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'item_id', 'from_id', 'to_id'
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
    protected $appends = ['ios_thread_id', 'added_date_format', 'updated_date_format'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosThreadIdAttribute()
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

     public function messages()
     {
         return $this->HasMany(ChatMessage::class,'thread_id');
     }
     /**
     * has One relation last Message  attributes
     */
    public function last_message()
    {
        return $this->hasOne(ChatMessage::class,'thread_id', 'id')->orderBy('id','desc');
    }
}
