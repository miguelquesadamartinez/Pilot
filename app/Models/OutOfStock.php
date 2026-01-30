<?php

namespace App\Models;

use App\Models\Ecommerce\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OutOfStock extends Model
{
    protected $connection = 'sqlsrv_ecommerce';
    protected $table = 'ART_rupture';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'peremption_date',
    ];

    use HasFactory;

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
