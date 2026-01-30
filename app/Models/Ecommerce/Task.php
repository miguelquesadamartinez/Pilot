<?php

namespace App\Models\Ecommerce;

use App\Models\CModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    use SoftDeletes;
    protected $table = 'task';
    protected $fillable = [
        'name',
        'command',
        'planed_execution_time',
        'enabled',
    ];
    protected $hidden = [
        'deleted_at',
    ];
}
