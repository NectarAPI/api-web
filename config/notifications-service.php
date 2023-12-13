<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Notifications Service Hosts
    |--------------------------------------------------------------------------
    |
    | This option sets the host endpoint for the notifications service.
    |
    */

    'host' => env('NOTIFICATIONS_SERVICE_PERMISSIONS_SERVICE_HOST'),

     /*
    |--------------------------------------------------------------------------
    | Credentials Service Basic Authentication Username
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth username for the user service.
    |
    */

    'username' => env('NOTIFICATIONS_SERVICE_BASIC_AUTH_USERNAME'),


     /*
    |--------------------------------------------------------------------------
    | Credentials Service Basic Authentication Password
    |--------------------------------------------------------------------------
    |
    | This option sets the basic auth password for the user service.
    |
    */

    'password' => env('NOTIFICATIONS_SERVICE_BASIC_AUTH_PASSWORD'),

];

