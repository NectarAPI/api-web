<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Service Hosts
    |--------------------------------------------------------------------------
    |
    | This option sets the host endpoint for the config services.
    |
    */

    'public-key-host' => env('CONFIG_PUBLIC_KEY_SERVICE_HOST'),
    'config-host' => env('CONFIG_CONFIG_SERVICE_HOST'),

     /*
    |--------------------------------------------------------------------------
    | User Service Basic Authentication Username
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth username for the user service.
    |
    */

    'username' => env('CONFIG_SERVICE_BASIC_AUTH_USERNAME'),


     /*
    |--------------------------------------------------------------------------
    | User Service Basic Authentication Password
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth password for the user service.
    |
    */

    'password' => env('CONFIG_SERVICE_BASIC_AUTH_PASSWORD'),

     /*
    |--------------------------------------------------------------------------
    | Nectar Public Key
    |--------------------------------------------------------------------------
    |
    | This option sets the Nectar Public Key.
    |
    */

    'nectar_public_key' => env('NECTAR_PUBLIC_KEY'),  

];

