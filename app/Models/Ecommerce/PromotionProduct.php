<?php

namespace App\Models\Ecommerce;

use App\Models\CModel;
use App\Models\Ecommerce\Promotion;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionProduct extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    const DISCOUNT_FIXED_PRICE = 'fixed';
    const DISCOUNT_PERCENTAGE = 'percentage';
    const DISCOUNT_CUSTOM_RULE = 'rule';

    use SoftDeletes;
    protected $table = 'promotion_product';
    protected $fillable = [
        'promotion_id',
        'product_id',
        'unit_price',
        'quantity',
        'quantity_max',
        'discount_type', // fixed / percent
        'discount',
    ];

    public static function getDiscountTypes() :array
    {
        return [
            self::DISCOUNT_FIXED_PRICE,
            self::DISCOUNT_PERCENTAGE,
            self::DISCOUNT_CUSTOM_RULE,
        ];
    }

    public function promotion()
    {
        return $this->hasOne(Promotion::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
