<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

use Auth;
class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'category_key', 'item_name', 'item_sef',  'item_description', 'item_type', 'is_promotion', 'item_promotion_days','promotion_end_date',
        'item_promotion_price', 'item_from_price', 'item_to_price', 'item_location', 'item_latitude', 'item_longitude', 'item_total_views',
         'item_type_key', 'item_make_id', 'item_model_id', 'item_year', 'item_condition_id', 
        'item_exterior_color_id','item_interior_color_id', 'item_transmission_id', 'item_cylinder_id', 'status', 'is_promoted'
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
    protected $appends = ['ios_item_id', 'added_date_format', 'updated_date_format', 'promotion_end_date_format', 'views_format', 'bid_count'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosItemIdAttribute()
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
     * create date format attribute.
     *
     *  var string
     */

    public function getPromotionEndDateFormatAttribute()
    {
        $current_date = Carbon::now();
        $future_date = Carbon::createFromTimeStamp(strtotime($this->attributes['promotion_end_date']));
        $difference = $current_date->diff($future_date);
        //$diffInSeconds = $difference->s; //45
        $diffInMinutes = $difference->i; //23
        $diffInHours   = $difference->h; //8
        $diffInDays    = $difference->d; //21
        //$diffInMonths  = $difference->m; //4
        //$diffInYears   = $difference->y; //1

        return $diffInDays.'d : '.$diffInHours.'h : '.$diffInMinutes.'m';
        //return Carbon::createFromTimeStamp(strtotime($this->attributes['promotion_end_date']))->diffForHumans();
      
    }

    public function getViewsFormatAttribute()
    {
        $n = $this->attributes['item_total_views'];
        $precision=1;
        if ($n <= 999) {
            // 0 - 900
            $n_format = $n;
            $suffix = '';
        } else if ($n <= 999999) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n <= 999999999) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n <= 999999999999) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        return $n_format.''.$suffix;
    }

     public function getBidCountAttribute()
     {
         return $this->hasMany(ItemBid::class,'item_id')->count();
     }

     
    public function user()
     {
         return $this->belongsTo(User::class,'user_id');
     }

     public function photos()
     {
         return $this->hasMany(ItemPhoto::class,'item_id');
     }

     public function category()
     {
        $lang_key = 'en';
        if(@Auth::user()){
            $lang_key = @Auth::user()->lang_key;
        }
         return $this->belongsTo(Category::class,'category_key', 'cat_key')->where('lang_key', $lang_key);
     }
     public function type()
     {
         $lang_key = 'en';
         if(@Auth::user()){
             $lang_key = @Auth::user()->lang_key;
         }
         return $this->belongsTo(ItemType::class,'item_type_key', 'type_key')->where('lang_key', $lang_key);
     }

     public function make()
     {
         return $this->belongsTo(ItemMake::class,'item_make_id');
     }

     public function model()
     {
         return $this->belongsTo(ItemModel::class,'item_model_id');
     }

     public function condition()
     {
         return $this->belongsTo(ItemCondition::class,'item_condition_id');
     }

     public function exterior_color()
     {
         return $this->belongsTo(ItemColor::class,'item_exterior_color_id');
     }
     
     public function interior_color()
     {
         return $this->belongsTo(ItemColor::class,'item_interior_color_id');
     }

     public function transmission()
     {
         return $this->belongsTo(ItemTransmission::class,'item_transmission_id');
     }

     public function cylinder()
     {
         return $this->belongsTo(ItemCylinder::class,'item_cylinder_id');
     }

     public function bids()
     {
         return $this->hasMany(ItemBid::class,'item_id');
     }


     public function max_bid()
     {
         return $this->hasOne(ItemBid::class,'item_id')->orderBy('bid_amount', 'desc');
     }


}
