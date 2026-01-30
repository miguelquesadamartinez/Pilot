<?php

namespace App\Models\Ecommerce;

use App\Models\CModel;

class PharmacyHistory extends CModel
{
    protected $connection = 'sqlsrv_ecommerce';
    
    protected $table = 'pharmacy_history';
    protected $fillable = [
        'pharmacy_id',
        'pharmacy_group_id',
        'name',
        'business_name',
        'cip',
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
}
