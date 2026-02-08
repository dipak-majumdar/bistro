<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'includes', 'description', 'category_id', 'mrp', 'discount', 'gst', 'price', 'is_available', 'image',
    ];

    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'item_id');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'item_id')->where('is_primary', true);
    }

    public function variations()
    {
        return $this->hasMany(ItemVariation::class, 'menu_item_id');
    }

    public function minprice()
    {
        return $this->hasOne(ItemVariation::class, 'menu_item_id')
            ->orderBy('price', 'asc');
    }
}
