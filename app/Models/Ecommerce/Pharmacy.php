<?php

namespace App\Models\Ecommerce;


use App\Models\CModel;
use App\Models\Score;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pharmacy extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    use SoftDeletes;

    protected $table = 'pharmacy';
    protected $primaryKey = 'id';
    protected $dateFormat = 'Y-m-d H:i:s.v';
    protected $fillable = [
        'pharmacy_group_id',
        'name',
        'business_name',
        'cip',
        'depo_id',
        'phone',
        'phone2',
        'email',
        'website',
        'msisdn',
        'fax',
        'country',
        'bank_name',
        'iban',
        'bic',
        'guichet_code',
        'rib',
        'sepa_signed',
        'sepa_expiration',
        'sepa_file',
        'delivery_address_street',
        'delivery_address_province',
        'delivery_address_town',
        'delivery_address_zipcode',
        'delivery_address_comment',
        'delivery_address_latitude',
        'delivery_address_longitude',
        'billing_address_street',
        'billing_address_province',
        'billing_address_town',
        'billing_address_zipcode',
        'billing_address_comment',
        'billing_address_latitude',
        'billing_address_longitude',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $casts = [
        'sepa_expiration' => 'date',
    ];

    // Added By Miguel
    public function scoreObj(): HasOne
    {
        return $this->hasOne(Score::class, 'pharmacy_id', 'id'); // Foreign - Local
    }
    
    public function group()
    {
        return $this->hasOne(PharmacyGroup::class, 'id', 'pharmacy_group_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'pharmacy_id', 'id')->orderBy('created_at', 'DESC');
    }

    /**
     * @param string|null $country
     * @return mixed
     */
    public static function getCount(?string $country)
    {
        return ($country) ? Pharmacy::where('country', $country)->count() : Pharmacy::count();
    }

    public function getAll()
    {
        if (Cache::has('pharmacies')) {
            $pharmacies = Cache::get('pharmacies');
        } else {
            $pharmacies = Pharmacy::select('id', 'name', 'phone', 'cip')->orderBy('name', 'ASC')->with('pharmacy_group')->get();
            Cache::put('pharmacies', $pharmacies, now()->addMinutes(30)); // 30 Minutes
        }
        return $pharmacies;
    }

    /**
     * @param string|null $search
     * @return mixed
     */
    public function search(?string $search, array $filters = [])
    {
        $pharmacies = Pharmacy::orderBy('name', 'ASC');
        if(!empty($search))
        {
            $pharmacies->where('cip', 'LIKE', "%$search%")
                        ->orWhere('name', 'LIKE', "%$search%")
                        ->orWhere('phone', 'LIKE', "%$search%")
                        ->orWhere('business_name', 'LIKE', "%$search%");
        }

        if(!empty($filters))
        {
            foreach ($filters as $filter => $value)
            {
                $pharmacies->where($filter, $value);
            }
        }
        return $pharmacies->with('group')->paginate(20);
    }

    public function newPharmacies()
    {

        $date = date('Y-m-d', strtotime('-1 day'));
        return DB::table('pharmacy')
                ->leftjoin('pharmacy_group', 'pharmacy_group.id', '=', 'pharmacy.pharmacy_group_id')
                ->select('pharmacy.*', 'pharmacy_group.name AS group_name')
                ->where('pharmacy.updated_at', '>=', $date)
                ->orWhere('pharmacy.created_at', '>=', $date)
                ->get();

/*
        return Pharmacy::
        leftjoin('pharmacy_group', 'pharmacy_group.id', '=', 'pharmacy.pharmacy_group_id')
                ->where('updated_at', '>=', $date)
                ->orWhere('created_at', '>=', $date)
                ->get();
*/

    }

}
