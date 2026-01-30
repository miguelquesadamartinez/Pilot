<?php

namespace App\Models;

use App\Mail\InfoMail;
use App\Models\Ecommerce\Category;
use Illuminate\Support\Facades\Mail;
use App\Models\Ecommerce\TeleOperator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItems::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }

    public function deliveryFile(): HasOne
    {
        return $this->hasOne(DeliveryFiles::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Tickets::class);
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }

    public function operator(): HasOne
    {
        return $this->hasOne(TeleOperator::class, 'id', 'agent_id'); // Foreign - Local
    }

    public function recordings(): HasMany
    {
        return $this->hasMany(Recordings::class);
    }

    public function laboratoryName(int $id){
        $items = OrderItems::where('orders_id', '=', $id)->get();
        
        if(!isset($items[0])) return 'No laboratory';

        if (trim($items[0]->product_laboratory) == 'ALFASIGMA1'){
            return 'ALFASIGMA' ;
        } else if (trim($items[0]->product_laboratory) == 'LIFESTYLES'){
            return 'LIFESTYLES' ;
        } else if (trim($items[0]->product_laboratory) == 'AGINAX'){
            return 'AGINAX' ;
        } else if (trim($items[0]->product_laboratory) == 'NEOPULSE'){
            return 'NEOPULSE' ;
        } else if (trim($items[0]->product_laboratory) == 'THERAMEX1' || trim($items[0]->product_laboratory) == 'THERAMEX'){
        //} else if (trim($items[0]->product_laboratory) == 'THERAMEX1'){
            return 'THERAMEX' ;
        } else if (trim($items[0]->product_laboratory) == 'BNSANTE_GC'){
            return 'BNSANTE_GC' ;
        } else if (trim($items[0]->product_laboratory) == 'BIOGYNE'){
            return 'BIOGYNE' ;
        } else if (trim($items[0]->product_laboratory) == 'Biogyne'){
            return 'BIOGYNE' ;
        } else if (trim($items[0]->product_laboratory) == 'Biogyne ES'){
            return 'Biogyne ES' ;
        } else if (trim($items[0]->product_laboratory) == 'HAVEA_FR'){
            return 'HAVEA_FR' ;
        } else if (trim($items[0]->product_laboratory) == 'ADARE'){
            return 'ADARE' ;
        } else if (trim($items[0]->product_laboratory) == 'DSM'){
            return 'DSM' ;
        } else {
            Mail::to(env('EMAIL_FOR_APP_ERROR'))->send(new InfoMail('OrderNum: ' . Orders::find($id)->OrderNum . ' - Missing laboratory: ' . trim($items[0]->product_laboratory)));
            return OrderItems::where('orders_id', '=', $id)->get()[0]->product_laboratory;
        }
    }
}
