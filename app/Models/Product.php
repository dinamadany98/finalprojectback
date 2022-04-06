<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;



//product belonts to many orderitem
    public function OrderItems(){
        return $this->belongsToMany(OrderItem::class,'order_item_products');
    }    
}
