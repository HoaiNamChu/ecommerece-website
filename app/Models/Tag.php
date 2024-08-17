<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_name',
        'tag_slug',
        'tag_description',
    ];


    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
