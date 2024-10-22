<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'discount_amount', 'valid_until'];

    public function isValid()
    {
        return $this->valid_until >= now();
    }

    // apply discount on total order
    public function applyDiscount($total)
    {
        return max($total - $this->discount_amount, 0);
    }
}
