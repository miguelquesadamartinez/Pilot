<?php

namespace App\Models\Ecommerce;

use Illuminate\Support\Facades\Cache;
use App\Models\CModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeleOperator extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    use SoftDeletes;
    protected $table = 'tele_operator';
    protected $fillable = [
        'operator_id', //Hermes Operator id TA Code
        'country',
        'first_name',
        'last_name',
        'locale',
        'email',
        'mobile',
        'supervisor',
    ];
    protected $hidden = [
        'deleted_at',
    ];

    public function getFullName() : string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getOperatorId()
    {
        return $this->operator_id;
    }

    public static function getAll() : array
    {
        $operators = null;

        if (Cache::has('operators')) {
            $operators = Cache::get('operators');
        } else {
            $personnels = TeleOperator::all();
            foreach($personnels as $operator)
            {
                if($operator->operator_id)
                $operators[$operator->operator_id] = $operator;
            }
            Cache::put('operators', $operators, now()->addMinutes(30)); // 30 Minutes
        }
        return $operators;
    }

    /**
     * Get operator name by TA
     * @param ?int $ta_code
     * @return mixed
     */
    public static function operator(?int $ta_code)
    {
        $operators = self::getAll();
        return (isset($operators[$ta_code])) ? $operators[$ta_code] : $ta_code;
    }
}
