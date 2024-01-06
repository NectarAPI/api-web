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

    'subscribers-host' => env('SUBSCRIBERS_SERVICE_HOST'),

     /*
    |--------------------------------------------------------------------------
    | Payments Service Basic Authentication Username
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth username for the payments service.
    |
    */

    'username' => env('SUBSCRIBERS_SERVICE_BASIC_AUTH_USERNAME'),


     /*
    |--------------------------------------------------------------------------
    | Payments Service Basic Authentication Password
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth password for the payments service.
    |
    */

    'password' => env('SUBSCRIBERS_SERVICE_BASIC_AUTH_PASSWORD'),

];

