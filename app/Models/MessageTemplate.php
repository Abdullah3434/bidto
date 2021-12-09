<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'key', 'name', 'message_template'
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
    protected $appends = ['ios_message_template_id', 'added_date_format', 'updated_date_format'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosMessageTemplateIdAttribute()
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

}
