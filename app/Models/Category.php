<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='categories';
    protected $fillable= [
        'name',
        'slug',
        'description',
        'image',
    ];

    function product(){
        return $this->hasMany(Product::class,'cat_id');
    }

}
