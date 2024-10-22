<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Cart extends Model
{
    use HasFactory;

    // Mass assignment protection
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // product many to one
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_product')->withPivot('quantity')->withTimestamps(); 
    }

    public function totalPrice()
    {
        return $this->product->price * $this->quantity;
    }
    //sun all items in the cart
    public static function getTotalPriceForUser($userId)
    {
        $cartItems = Cart::where('user_id', $userId)->get();
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->totalPrice();
        }
        return $total;
    }

}
