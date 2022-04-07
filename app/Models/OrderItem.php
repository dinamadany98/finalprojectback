<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable =['order_id','product_id','quantity','price','status','total_price'];



    //OrderItem belong to one Order
    public function Order(){
        return $this->belongsTo(Order::class);

    }




//orderitem belonts to many product
public function Products(){
    return $this->belongsToMany(Product::class,'order_item_products');
}
}
