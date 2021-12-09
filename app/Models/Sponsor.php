<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'sponsor_name', 'sponsor_image', 'sponsor_url', 'status'
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
    protected $appends = ['ios_sponsor_id', 'added_date_format', 'updated_date_format', 'full_image', 'thumb_image'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosSponsorIdAttribute()
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
         if ($this->attributes['sponsor_image']) {
             $image_name = $this->attributes['sponsor_image'];
         }
         return checkImage('sponsors/' . $image_name);
     }

     public function getThumbImageAttribute()
     {
         $image_name = 'no_user_image.png';
         if ($this->attributes['sponsor_image']) {
             $image_name = $this->attributes['sponsor_image'];
         }
         return checkImage('sponsors/thumbs/' . $image_name);
     }
}
