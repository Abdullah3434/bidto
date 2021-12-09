<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'lang_name', 'lang_flag', 'lang_key', 'currency_name', 'currency_symbol', 'currency_code', 'currency_value', 'is_default', 'status',
        'language_key'
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
    protected $appends = ['ios_language_id', 'added_date_format', 'updated_date_format', 'full_image', 'thumb_image'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosLanguageIdAttribute()
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
     * full image path attribute which is in appended array.
     *
     *  var string
     */
    public function getFullImageAttribute()
     {
         $image_name = 'no_ad_image.png';
         if ($this->attributes['lang_flag']) {
             $image_name = $this->attributes['lang_flag'];
         }
         return checkImage('flags/' . $image_name);
     }
     /**
     * thumb image path attribute which is in appended array.
     *
     *  var string
     */
     public function getThumbImageAttribute()
     {
         $image_name = 'no_ad_image.png';
         if ($this->attributes['lang_flag']) {
             $image_name = $this->attributes['lang_flag'];
         }
         return checkImage('flags/thumbs/' . $image_name);
     }

}
