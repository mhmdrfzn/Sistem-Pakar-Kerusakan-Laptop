<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Credentials
    |--------------------------------------------------------------------------
    | Kredensial login admin diambil dari .env file.
    | Ubah nilai di .env: ADMIN_USERNAME, ADMIN_PASSWORD, ADMIN_NAME
    */

    'username' => env('ADMIN_USERNAME', 'admin'),
    'password' => env('ADMIN_PASSWORD', 'admin123'),
    'name'     => env('ADMIN_NAME', 'Administrator'),

];
