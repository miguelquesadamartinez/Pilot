<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketStatus extends Model
{
    use HasFactory;
 
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(TicketCategories::class, 'id', 'categories_id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(TicketCategories::class, 'id', 'category_id');
    }
}
