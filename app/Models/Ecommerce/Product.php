<?php

namespace App\Models\Ecommerce;

use App\Models\CModel;
use Illuminate\Support\Facades\DB;

class Product extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    protected $table = 'product';
    protected $fillable = [
        'laboratory_id',
        'category_id',
        'sku',
        'national_code',
        'ean',
        'name',
        'description',
        'photo',
        'unit_price',
        'unit_price_wholesaler',
        'minimum_quantity',
        'quantity',
    ];
    protected $hidden = [
        'updated_by_user_id',
        'deleted_at',
    ];
    protected $casts = [
        'laboratory_id' => 'int',
        'category_id' => 'int',
        'unit_price' => 'float',
    ];

    public function laboratory()
    {
        return $this->hasOne(Laboratory::class, 'id', 'laboratory_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function getAll()
    {
        return Product::all();
    }

    public function promotions()
    {
        return $this->hasManyThrough(Promotion::class,PromotionProduct::class, 'product_id', 'id', 'id', 'promotion_id');
    }

    /**
     * Get product list filtered by laboratory and category
     * @param int $laboratory_id
     * @param int|null $category_id
     * @return mixed
     */
    public function getAllByLaboratory(int $laboratory_id, ?int $category_id = null)
    {
        $products = Product::with('promotions')->where('laboratory_id', $laboratory_id);
        if(!empty($category_id))
            $products->where('category_id', $category_id);

        return $products->get();
    }

    /**
     * @param string|null $search
     * @param array|null $filters
     * @return mixed
     */
    public function search(?string $search, ?array $filters = null)
    {
        $products = Product::with('laboratory', 'category', 'promotions',); //, 'promotion_product'
        $products->orderBy('name', 'ASC');

        if(!empty($search))
        {
            $products = $products->where('name', 'LIKE', "%$search%")
                ->orWhere('ean', 'LIKE', "%$search%")
                ->orWhere('sku', 'LIKE', "%$search%")
                ->orWhere('national_code', 'LIKE', "%$search%");
        }

        if(!empty($filters))
        {
            foreach($filters as $key => $filter)
            {
                if(!empty($filter))
                    $products->where($key, $filter);
            }
        }

        return $products->paginate(20);
    }
}
