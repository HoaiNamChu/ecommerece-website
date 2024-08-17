<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_sku',
        'product_slug',
        'product_price',
        'product_price_sale',
        'product_image',
        'product_short_description',
        'product_description',
        'is_featured',
        'is_new',
        'is_active',
        'is_on_sale',
        'is_home',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_active' => 'boolean',
        'is_on_sale' => 'boolean',
        'is_home' => 'boolean',
    ];

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function productGalleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id');
    }
}
