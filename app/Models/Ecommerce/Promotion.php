<?php

namespace App\Models\Ecommerce;

use App\Models\CModel;
use App\Models\Ecommerce\PromotionProduct;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    use SoftDeletes;
    protected $table = 'promotion';
    protected $fillable = [
        'name',
        'pharmacy_group_id',//Optional
        'description',
        'country',
        'price',
        'begin_date',
        'expire_date',
    ];
    protected $casts = [
        'pharmacy_group_id' => 'int',
        'price' => 'float',
        'begin_date' => 'date',
        'expire_date' => 'date',
    ];
    protected $hidden = [
        'deleted_at',
        'laravel_through_key',
    ];

    public function pharmacy_group()
    {
        return $this->hasOne(PharmacyGroup::class, 'id', 'pharmacy_group_id');
    }

    public function products()
    {
        return $this->hasMany(PromotionProduct::class, 'promotion_id', 'id');
    }
}
