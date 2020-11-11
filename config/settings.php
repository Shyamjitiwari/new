<?php

return [

    'magic_bricks' => [
        'url' => env('MAGIC_BRICKS_URL', 'http://rating.magicbricks.com/mbRating/download.xml'),
        'key' => env('MAGIC_BRICKS_KEY', 'dDR4TLpzO2Ig5K70nqFAUw~~~~~~3D~~~~~~3D'),
    ],

    'housing' => [
        'housing_url' => env('HOUSING_URL', 'https://leads.housing.com/api/v0/get-builder-leads'),
        'housing_id1' => env('HOUSING_ID1', 4214638),
        'housing_key1' => env('HOUSING_KEY1', 'ed90e66807f9eb0fd6d68a7f2132837e'),
    ],

    'acres' => [
        'user_name' => env('ACRES_USERNAME', 'nageena.bano89@gmail.com'),
        'password' => env('ACRES_PASSWORD', 'ownitneha'),
        'request_url' => env('ACRES_URL', 'http://www.99acres.com/99api/v1/getmy99Response/OeAuXClO43hwseaXEQ/uid/')
    ],

    'roof-floor' => [
        'key' => env('ROOF_FLOOR_KEY', '_01Roof&Floor@'),
    ],

    'passport' => [
        'grant_type' => env('GRANT_TYPE', 'password'),
        'client_id' => env('CLIENT_ID', 2),
        'client_secret' => env('CLIENT_SECRET', 'htdKi9TaB3DwRQr4qJQoiu47exxvWSbYYaJbweKt'),
        'scope' => env('SCOPE', '*'),
    ],

    'pagination' => 10,

    'system' => [
        'auto_logout' => env('AUTO_LOGOUT', 15),
    ],
    'leads' => [
        'default_lead_source' => env('DEFAULT_LEAD_SOURCE', 1),
        'default_lead_status' => env('DEFAULT_LEAD_STATUS', 1),
    ]

];
