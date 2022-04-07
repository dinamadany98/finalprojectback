<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;



//product belonts to many orderitem

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
         return $this->belongsTo(Category::class,'category_id');
     }


     public function users()
     {
         return $this->belongsToMany(User::class,'carts');
     }

     public function OrderItems(){
        return $this->belongsToMany(OrderItem::class,'order_item_products');
    }
    public function usercarts(){
        return $this->belongsToManyResource(User::class,'wishlists');
    }

}
