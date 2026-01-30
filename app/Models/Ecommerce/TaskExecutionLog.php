<?php

namespace App\Models\Ecommerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CModel;

class TaskExecutionLog extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    use HasFactory;
    protected $table = 'task_execution_log';
    protected $fillable = [
        'task_id',
        'status',
        'record_count',
        'logs',
        'started_at',
        'ended_at',
        'created_at',
        'updated_at',
    ];
}
