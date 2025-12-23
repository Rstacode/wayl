<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Wayl API Authentication Key
    |--------------------------------------------------------------------------
    |
    | Your Wayl API authentication key. You can find this in your
    | Wayl dashboard at https://wayl.io
    |
    */

    'api_key' => env('WAYL_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Wayl API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the Wayl API. You should not need to change this
    | unless you are using a custom or sandbox environment.
    |
    */

    'base_url' => env('WAYL_BASE_URL', 'https://api.thewayl.com/api/v1'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout in seconds for HTTP requests to the Wayl API.
    |
    */

    'timeout' => env('WAYL_TIMEOUT', 30),

];
