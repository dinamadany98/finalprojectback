<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemProduct extends Model
{
    use HasFactory;
    protected $fillable =['order_item_id','product_id'];
    protected $table ="order_item_products";
}
