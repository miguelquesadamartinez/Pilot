<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordingSearch extends Model
{
    use HasFactory;

    public $timestamps = false;

    
    public function teleoperator(): HasOne
    {
        return $this->hasOne(TeleOperator::class, 'operator_id', 'operator');
    }
}
