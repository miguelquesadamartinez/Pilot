<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketActions extends Model
{
    use HasFactory;

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Tickets::class);
    }
}
