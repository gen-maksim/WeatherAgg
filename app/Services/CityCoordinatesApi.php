<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CityCoordinatesApi
{
    public function getCoordinates(string $city): array
    {
        $response = Http::get('http://api.positionstack.com/v1/forward', [
            'access_key' => config('services.misc.city'),
            'query' => $city
        ])->json('data.0');

        return [
            'lat' => $response['latitude'],
            'lon' => $response['longitude'],
        ];
    }
}