<?php

namespace App\Models;

use App\Models\Ecommerce\Laboratory;
use App\Models\Ecommerce\Pharmacy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PharmacyLaboratoryRestricted extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv_ecommerce';
    public $timestamps = false;
    protected $table = 'pharmacy_laboratory_restricteds';
    protected $fillable = [
        'cip',
        'laboratory_id',
    ];
    public function laboratory()
    {
        return $this->hasOne(Laboratory::class, 'id', 'laboratory_id');
    }
    public function pharmacy()
    {
        return $this->hasOne(Pharmacy::class, 'cip', 'cip');
    }
}
