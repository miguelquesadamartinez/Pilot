<?php

namespace App\Models;

use App\Models\Ecommerce\Laboratory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScoreLaboratory extends Model
{
    use HasFactory;

    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id', 'id'); 
    }

    public function active()
    {
        return ScoreLaboratory::where('enabled', '=', true)->get();
    }
}
