<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'weather' => [
        'accu_weather' => [
            'key' => env('ACCW_KEY'),
            'base_url' => 'http://dataservice.accuweather.com/',
            'forecast_url' => 'forecasts/v1/daily/5day/',
            'city_search' => 'locations/v1/cities/search',
        ],
        'open_meteo' => [
            'base_url' => 'https://api.open-meteo.com/v1/',
            'forecast_url' => 'forecast'
        ],
        'weather_api' =>[
            'key' => env('WEATHERAPI_KEY'),
            'base_url' => 'http://api.weatherapi.com/v1/',
            'forecast_url' => 'forecast.json',
        ],
    ],

    'misc' => [
        'coordinates_api' => [
            'key' => env('CITY_KEY'),
            'base_url' => 'http://api.positionstack.com/v1/',
            'city_coords' => 'forward',
        ],
    ],
];
