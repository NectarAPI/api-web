<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Tokens Service Hosts
    |--------------------------------------------------------------------------
    |
    | This option sets the host endpoint for the tokens services.
    |
    */

    'host' => env('TOKENS_SERVICE_HOST'),

     /*
    |--------------------------------------------------------------------------
    | Tokens Service Basic Authentication Username
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth username for the tokens service.
    |
    */

    'username' => env('TOKENS_SERVICE_BASIC_AUTH_USERNAME'),


     /*
    |--------------------------------------------------------------------------
    | Tokens Service Basic Authentication Password
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth password for the tokens service.
    |
    */

    'password' => env('TOKENS_SERVICE_BASIC_AUTH_PASSWORD'),


];

