<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\DiscountCode;

class Order extends Model
{
    use HasFactory;

    
    protected $fillable = ['user_id', 'total', 'discount_code_id'];

    // product many to many
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    // discount code many to one
    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class);
    }

    public function applyDiscount()
    {
        if ($this->discountCode && $this->discountCode->isValid()) {
            $this->total = $this->discountCode->applyDiscount($this->total);
        }
    }

    //order total amount
    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->price * $product->pivot->quantity;
        }
        $this->total = $total;
        return $total;
    }
}
