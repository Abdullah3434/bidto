<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['user_id', 'device_id', 'device_type', 'app_mode', 'device_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The attributes that should be appended with mass assignable array.
     *
     * @var array
     */

    protected $appends = ['ios_user_device_id'];

    /**
     * user device id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosUserDeviceIdAttribute()
    {
        return $this->attributes['id'];
    }

    /**
     * belongs to relation user attributes
     */

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * boot
     */
    protected static function boot()
    {
        parent::boot();
    }

}
