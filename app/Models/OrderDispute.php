<?php

namespace App\Models;

use App\Models\Ecommerce\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDispute extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'orderItemProductId');
    }
}
