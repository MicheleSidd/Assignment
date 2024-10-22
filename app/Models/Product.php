<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'stock'];

    // if available on stck
    public function isAvailable()
    {
        return $this->stock > 0;
    }

    // decrease stock after purchase
    public function reduceStock($quantity)
    {
        if ($this->isAvailable() && $this->stock >= $quantity) {
            $this->stock -= $quantity;
            $this->save();
        }
    }
}
