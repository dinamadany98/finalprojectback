<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable =['user_id','fname','lname','email','phone','address1','address2','city',
              'state','country','pincode','message','tracking_no','total_price'];

     //order belong to one user
    public function user(){
        return $this->belongsTo(User::class);
        }
     //order  hasmeny to one  OrderItem
    function OrderItem(){
        return $this->hasMany(OrderItem::class);
    }
    public function productss(){
        return $this->belongsToMany(Product::class,'order_items');
    }


    

}
