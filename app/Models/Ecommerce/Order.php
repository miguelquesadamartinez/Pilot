<?php

namespace App\Models\Ecommerce;

use App\Models\CModel;
use App\Models\Ecommerce\Pharmacy;
use Illuminate\Support\Facades\DB;
use App\Models\Ecommerce\OrderDetail;
use App\Models\Ecommerce\TeleOperator;
use App\Models\Ecommerce\Country;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';

    const DRAFT = 'draft';
    const CONFIRMED = 'confirmed';
    const CANCELED = 'canceled';
    const DELETED = 'deleted';

    use SoftDeletes;
    protected $table = 'order';
    protected $fillable = [
        'tele_operator_id',
        'pharmacy_id',
        'amount',
        'desired_delivery_date',
        'comments',
        'status',
    ];
    protected $hidden = [
        'deleted_at'
    ];

    public function pharmacy()
    {
        return $this->hasOne(Pharmacy::class, 'id', 'pharmacy_id');
    }

    public function tele_operator()
    {
        return $this->hasOne(TeleOperator::class, 'id', 'tele_operator_id');
    }


    public function items()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    /**
     * @param string|null $search
     * @param int $limit
     * @return mixed
     */
    public function getLastest(?string $search = null, int $limit = 10)
    {
        $orders = Order::orderBy('created_at', 'DESC');
        if(!empty($search))
        {
            $orders->where('id','LIKE', "%$search%");
        }
        return $orders->with('pharmacy', 'tele_operator')->paginate($limit);
    }

    public function selectTodayOrders($id){

        $date = date('Y-m-d', strtotime('-1 day'));
        return DB::table('order_detail')
            ->leftjoin('order', 'order.id', '=', 'order_detail.order_id')
            ->leftjoin('pharmacy', 'order.pharmacy_id', '=', 'pharmacy.id')
            ->leftjoin('product', 'product.id', '=', 'order_detail.product_id')
            ->leftjoin('tele_operator', 'tele_operator.id', '=', 'order.tele_operator_id')
            ->where([
                    ['order_detail.updated_at', '>=', $date],
                    ['product.laboratory_id', '=', $id]
                ])->get();

    }

    public function getTotal() : float
    {
        $total = 0.0;
        foreach($this->items as $item){
            $total = $total + (($item->price - $item->discount) * $item->quantity);
        }
        return $total;
    }

    public function getTotalWithDiscount() : float
    {
        $total = 0.0;
        foreach($this->items as $item){
            $total = $total + ( ( ( $item->price - ( $item->price * $item->discount / 100 ) ) ) * $item->quantity );
        }
        return $total;
    }

}
