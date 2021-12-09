<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'cat_name', 'cat_image', 'cat_key', 'lang_key', 'status'
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
    protected $appends = ['ios_category_id', 'added_date_format', 'updated_date_format', 'full_image', 'thumb_image', 'item_count'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosCategoryIdAttribute()
    {
        return $this->attributes['id'];
    }

    /**
     * update date format attribute.
     *
     *  var string
     */

    public function getItemCountAttribute()
    {
        return $this->hasMany(Item::class, 'category_key', 'cat_key')->where('status', 'active')->count();
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
     * full image path attribute which is in appended array.
     *
     *  var string
     */
    public function getFullImageAttribute()
     {
         $image_name = 'no_ad_image.png';
         if ($this->attributes['cat_image']) {
             $image_name = $this->attributes['cat_image'];
         }
         return checkImage('categories/' . $image_name);
     }
    /**
     * thumb image path attribute which is in appended array.
     *
     *  var string
     */
     public function getThumbImageAttribute()
     {
         $image_name = 'no_ad_image.png';
         if ($this->attributes['cat_image']) {
             $image_name = $this->attributes['cat_image'];
         }
         return checkImage('categories/thumbs/' . $image_name);
     }
}
