<?php

return [
    /**
     * These values must be defined in the .env file.
     *
     * Note that the user value must be a fully-qualified DN, so we append the base DN for authorized users to it.
     */
    'user' => env('LDAP_USER') ? env('LDAP_USER').',ou=Directory Administrators,o=Cornell University,c=US' : '',
    'pass' => env('LDAP_PASS') ?? '',

    /**
     * These values do not need to be defined in the .env file, but can be overridden there.
     */
    'server' => env('LDAP_SERVER', 'ldaps://query.directory.cornell.edu'),
    'base_dn' => env('LDAP_BASE_DN', 'ou=People,o=Cornell University,c=US'),
    'cache_seconds' => env('LDAP_CACHE_SECONDS', 300),
];
