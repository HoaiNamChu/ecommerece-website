<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'parent_id',
        'category_name',
        'category_slug',
        'category_description',
        'category_image',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(){
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }
}
