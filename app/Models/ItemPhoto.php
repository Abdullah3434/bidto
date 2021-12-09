<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPhoto extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'item_id', 'image', 'is_default'
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
    protected $appends = ['ios_photo_id', 'added_date_format', 'updated_date_format', 'full_image', 'thumb_image'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosPhotoIdAttribute()
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

    public function getFullImageAttribute()
     {
         $image_name = 'no_user_image.png';
         if ($this->attributes['image']) {
             $image_name = $this->attributes['image'];
         }
         return checkImage('items/' . $image_name);
     }

     public function getThumbImageAttribute()
     {
         $image_name = 'no_user_image.png';
         if ($this->attributes['image']) {
             $image_name = $this->attributes['image'];
         }
         return checkImage('items/thumbs/' . $image_name);
     }

     public function item()
     {
         return $this->belongsTo(Item::class,'item_id');
     }
}
