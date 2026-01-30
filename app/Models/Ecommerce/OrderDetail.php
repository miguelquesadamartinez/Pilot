<?php

namespace App\Models\Ecommerce;

use App\Models\Ecommerce\Order;
use App\Models\CModel;

class OrderDetail extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    protected $table = 'order_detail';
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'discount',
        'desired_delivery_date',
    ];
    protected $casts = [
        'desired_delivery_date' => 'date',
    ];

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
