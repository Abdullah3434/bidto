<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTempFile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'file', 'item_id', 'user_id','item_file_id', 'type'
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
    protected $appends = ['ios_temp_file_id', 'added_date_format', 'updated_date_format', 'full_image', 'thumb_image'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosTempFileIdAttribute()
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
        if ($this->attributes['file']) {
            $image_name = $this->attributes['file'];
        }
        return checkImage('temporary_files/' . $image_name);
    }

    public function getThumbImageAttribute()
    {
        $image_name = 'no_user_image.png';
        if ($this->attributes['file']) {
            $image_name = $this->attributes['file'];
        }
        return checkImage('temporary_files/thumbs/' . $image_name);
    }
}
