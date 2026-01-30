<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CModel extends Model
{

    protected $connection = 'sqlsrv_ecommerce';

    public function getStructure() : array
    {
        $sql ="select *
        from INFORMATION_SCHEMA.COLUMNS
        where TABLE_NAME='$this->table'";

        return DB::select($sql);
    }

}
