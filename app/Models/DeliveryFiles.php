<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryFiles extends Model
{
    use HasFactory;

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }
}
