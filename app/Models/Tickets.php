<?php

namespace App\Models;

use App\Models\Ecommerce\Pharmacy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tickets extends Model
{
    use HasFactory;

    public $timestamps = false;
    //protected $dateFormat = 'Y-d-m H:i:s.v';
    //protected $dateFormat = 'Y-m-d H:i:s.v';

    public function ticketActions(): HasMany
    {
        return $this->hasMany(TicketActions::class);
    }

    public function ticketCategory(): HasOne
    {
        return $this->hasOne(TicketCategories::class, 'id', 'categories_id');
    }

    public function ticketStatus(): HasOne
    {
        return $this->hasOne(TicketStatus::class, 'id', 'status_id');
    }

    public function ticketLevelA(): HasOne
    {
        return $this->hasOne(tickets_level_a::class, 'id', 'level_a_id');
    }

    public function ticketLevelB(): HasOne
    {
        return $this->hasOne(tickets_level_b::class, 'id', 'level_b_id');
    }

    public function ticketLevelC(): HasOne
    {
        return $this->hasOne(tickets_level_c::class, 'id', 'level_c_id');
    }

    public function ticketLevelD(): HasOne
    {
        return $this->hasOne(tickets_level_d::class, 'id', 'level_d_id');
    }

    public function ticketFiles(): HasMany
    {
        return $this->hasMany(TicketFile::class);
    }

    public function order(){
        return $this->hasOne(Orders::class, 'id', 'orders_id');
    }

    public function pharmacy(){
        return $this->hasOne(Pharmacy::class, 'CIP', 'CIP');
    }
}
