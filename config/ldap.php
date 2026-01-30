<?php

$domain='dc='.str_replace('.', ',dc=', env('LDAP_BASE_DN'));

return [
    'logging' => env('LDAP_LOGGING', false),
    'connections' => [
        'default' => [
            'connection' => Adldap\Connections\Ldap::class,
            'settings' => [
                'schema' => Adldap\Schemas\ActiveDirectory::class,
                'account_prefix' => env('LDAP_ACCOUNT_PREFIX', ''),
                'account_suffix' => env('LDAP_ACCOUNT_SUFFIX', ''),
                'hosts' => explode(' ', env('LDAP_HOSTS')),
                'port' => env('LDAP_PORT'),
                'timeout' => env('LDAP_TIMEOUT', 5),
                'base_dn' => $domain,
                'username' => env('LDAP_USERNAME')."@".env('LDAP_BASE_DN'),
                'password' => env('LDAP_PASSWORD'),
                'follow_referrals' => false,
                'use_ssl' => env('LDAP_USE_SSL', false),
                'use_tls' => env('LDAP_USE_TLS', false),
            ],
        ],
    ],
];