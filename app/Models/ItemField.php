<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemField extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'item_id', 'item_type_id', 'item_make_id', 'item_model_id', 'item_year_old', 'item_year_new', 'item_condition_id', 'item_exterior_color_id',
        'item_interior_color_id', 'item_transmission_id', 'item_cylinder_id'
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
    protected $appends = ['ios_item_field_id', 'added_date_format', 'updated_date_format'];

    /**
     * id attribute which is in appended array for ios only.
     *
     *  var string
     */

    public function getIosItemFieldIdAttribute()
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

    public function item()
     {
         return $this->belongsTo(Item::class,'item_id');
     }

     public function type()
     {
         return $this->belongsTo(ItemType::class,'item_type_id');
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
}
