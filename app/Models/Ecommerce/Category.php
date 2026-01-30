<?php

namespace App\Models\Ecommerce;

use App\Models\CModel;

class Category extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    protected $table = 'category';
    protected $fillable = [
        'laboratory_id',
        'name',
    ];
    protected $hidden = [
        'deleted_at',
    ];

    public function laboratory()
    {
        return $this->belongsTo(\App\Models\Ecommerce\Laboratory::class, 'id', 'laboratory_id');
    }

    public function getAllByLaboratory(?int $laboratory_id = null)
    {
        return (empty($country)) ? Category::all() : Category::where('laboratory_id', $laboratory_id)->get();
    }
}
