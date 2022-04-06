<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


<<<<<<< HEAD

//product belonts to many orderitem
    public function OrderItems(){
        return $this->belongsToMany(OrderItem::class,'order_item_products');
    }    
=======
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
     ,'cat_id',
     'trending'
     ];


     public function category()
     {
         return $this->belongsTo(Category::class);
     }



>>>>>>> master
}
