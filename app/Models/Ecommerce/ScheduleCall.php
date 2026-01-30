<?php

namespace App\Models\Ecommerce;

use App\Models\CModel;

class ScheduleCall extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    protected $table = 'schedule_call';
    protected $fillable = [
        'tele_operator_id', //Required
        'pharmacy_id', //Required
        'schedule_call_date', //Required
        'schedule_call_time', //Optional
    ];

    protected $casts = [
        'tele_operator_id' => 'int',
        'pharmacy_id' => 'int',
        'schedule_call_date' => 'date',
    ];
}
