<?php

namespace App\Models;

use App\Models\Ecommerce\Pharmacy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Score extends Model
{
    protected $connection = 'sqlsrv';

    use HasFactory;

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id'); 
    }
}
