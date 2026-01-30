<?php

namespace App\Models\Ecommerce;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $connection = 'sqlsrv_ecommerce';

    protected $table = 'rule';

}
