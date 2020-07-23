<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application
    |--------------------------------------------------------------------------
    |
    | The facebook ID and secret from the developer's page
    |
    */

    'app' => [
        'id' => env('FACEBOOK_APP_ID'),
        'secret' => env('FACEBOOK_APP_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Registration Fields
    |--------------------------------------------------------------------------
    |
    | The name of the fields on the user model that need to be updated,
    | if null, they shall not be updated. (valid for name, first_name, last_name)
    |
    */

    'registration' => [
        'facebook_id' => env('FACEBOOK_ID_COLUMN', 'facebook_id'),
        'name'        => env('NAME_COLUMN', 'name'),
    ],
];
