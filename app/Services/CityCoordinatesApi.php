<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class CityCoordinatesApi
{
    /**
     * @throws RequestException
     */
    public function getCoordinates(string $city): array
    {
        $url = config('services.misc.coordinates_api.base_url')
            . config('services.misc.coordinates_api.city_coords');

        $response = Http::get($url, [
            'access_key' => config('services.misc.coordinates_api.key'),
            'query' => $city
        ])->throw()->json('data.0');

        return [
            'lat' => $response['latitude'],
            'lon' => $response['longitude'],
        ];
    }
}