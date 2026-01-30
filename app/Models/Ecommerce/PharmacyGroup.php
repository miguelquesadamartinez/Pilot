<?php

namespace App\Models\Ecommerce;

use App\Models\CModel;

class PharmacyGroup extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    protected $table = 'pharmacy_group';
    protected $fillable = [
        'name'
    ];
}
