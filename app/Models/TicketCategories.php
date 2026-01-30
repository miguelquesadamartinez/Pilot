<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketCategories extends Model
{
    use HasFactory;

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Tickets::class, 'categories_id', 'id');
    }

    public function categoryStatuses(): HasMany
    {
        return $this->hasMany(TicketStatus::class, 'category_id', 'id');
    }
}
