<?php

namespace App\Models\Ecommerce;

use App\Models\CModel;
use App\Models\ScoreLaboratory;

class Laboratory extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    protected $table = 'laboratory';
    protected $fillable = [
        'name',
        'country',
        'minimum_sale',
    ];

    public function enabled()
    {
        return $this->hasOne(ScoreLaboratory::class, 'id', 'laboratory_id');
    }

    public function categories()
    {
        return \App\Models\Ecommerce\Category::where('laboratory_id', $this->id)->get(); //$this->hasMany(\App\Models\Ecommerce\Category::class, 'id', 'category_id');
    }

    public function getAll(?string $country = null)
    {
        return (empty($country)) ? Laboratory::all() : Laboratory::where('country', $country)->get();
    }
}
