<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Credentials Service Hosts
    |--------------------------------------------------------------------------
    |
    | This option sets the host endpoint for the config services.
    |
    */

    'credentials-host' => env('CREDENTIALS_CONFIG_SERVICE_HOST'),
    'permissions-host' => env('USER_SERVICE_PERMISSIONS_SERVICE_HOST'),

     /*
    |--------------------------------------------------------------------------
    | Credentials Service Basic Authentication Username
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth username for the user service.
    |
    */

    'username' => env('CREDENTIALS_SERVICE_BASIC_AUTH_USERNAME'),


     /*
    |--------------------------------------------------------------------------
    | Credentials Service Basic Authentication Password
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth password for the user service.
    |
    */

    'password' => env('CREDENTIALS_SERVICE_BASIC_AUTH_PASSWORD'),

];

