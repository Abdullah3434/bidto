<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'admin_name', 'admin_email', 'password', 'admin_image', 'status', 'admin_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be appended for serialization.
     *
     * @var array
     */
    protected $appends = ['admin_id', 'added_date_format', 'updated_date_format', 'full_image', 'thumb_image'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getAdminIdAttribute()
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
     * full image path attribute which is in appended array.
     *
     *  var string
     */
    public function getFullImageAttribute()
     {
         $image_name = 'no_user_image.png';
         if ($this->attributes['admin_image']) {
             $image_name = $this->attributes['admin_image'];
         }
         return checkImage('admins/' . $image_name);
     }
    /**
     * thumb image path attribute which is in appended array.
     *
     *  var string
     */
     public function getThumbImageAttribute()
     {
         $image_name = 'no_user_image.png';
         if ($this->attributes['admin_image']) {
             $image_name = $this->attributes['admin_image'];
         }
         return checkImage('admins/thumbs/' . $image_name);
     }
}
