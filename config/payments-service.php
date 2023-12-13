<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Payments Service Hosts
    |--------------------------------------------------------------------------
    |
    | This option sets the host endpoint for the payments services.
    |
    */

    'credits-host' => env('CREDITS_SERVICE_HOST'),
    'payments-host' => env('PAYMENTS_SERVICE_HOST'),

     /*
    |--------------------------------------------------------------------------
    | Payments Service Basic Authentication Username
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth username for the payments service.
    |
    */

    'username' => env('PAYMENTS_SERVICE_BASIC_AUTH_USERNAME'),


     /*
    |--------------------------------------------------------------------------
    | Payments Service Basic Authentication Password
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth password for the payments service.
    |
    */

    'password' => env('PAYMENTS_SERVICE_BASIC_AUTH_PASSWORD'),

];

