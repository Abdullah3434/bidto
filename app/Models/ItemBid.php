<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemBid extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'item_id', 'bid_amount', 'status'
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
    protected $appends = ['ios_bid_id', 'added_date_format', 'updated_date_format'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosBidIdAttribute()
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

    public function user()
     {
         return $this->belongsTo(User::class,'user_id');
     }

     public function item()
     {
         return $this->belongsTo(Item::class,'item_id');
     }
}
