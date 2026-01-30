<?php

namespace App\Models;

use App\Models\Ecommerce\Pharmacy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recovery extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv_ecommerce';
    public $timestamps = false;
    protected $table = 'recovery';
    protected $fillable = [
        'pharmacy_id',
        'date_operation',
        'facture',
        'libelle_rejet',
        'montant',
        'count_litige',
    ];
    public function pharmacy()
    {
        return $this->hasOne(Pharmacy::class, 'id', 'pharmacy_id');
    }
}
