<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;

class WeatherApiController extends Controller
{
    protected WeatherService $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getByCity(string $city): JsonResponse
    {
        $result = $this->weatherService->getByCity($city);
        return response()->json($result);
    }
}
