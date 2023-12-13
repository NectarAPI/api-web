<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Service Host
    |--------------------------------------------------------------------------
    |
    | This option sets the host endpoint for the user service.
    |
    */

    'host' => env('USER_SERVICE_HOST'),
    'credentials-host' => env('CREDENTIALS_SERVICE_HOST'),
    

     /*
    |--------------------------------------------------------------------------
    | User Service Basic Authentication Username
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth username for the user service.
    |
    */

    'username' => env('USER_SERVICE_BASIC_AUTH_USERNAME'),


     /*
    |--------------------------------------------------------------------------
    | User Service Basic Authentication Password
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth password for the user service.
    |
    */

    'password' => env('USER_SERVICE_BASIC_AUTH_PASSWORD')

];

