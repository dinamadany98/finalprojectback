<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable=
    [
      'name'
     ,'slug'
     ,'small_description'
     ,'description'
     ,'original_price'
     ,'selling_price'
     ,'image'
     ,'quantity'
     ,'category_id',
     'trending'
     ];


     public function category()
     {
         return $this->belongsTo(Category::class);
     }


     public function users()
     {
         return $this->belongsToMany(User::class);
     }


}
