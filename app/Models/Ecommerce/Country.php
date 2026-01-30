<?php

namespace App\Models\Ecommerce;

use App\Models\CModel;

class Country extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    protected $table = 'country';
    protected $fillable = [
        'name',
        'lang',
    ];

    public function getAll()
    {
        return Country::all();
    }
}
