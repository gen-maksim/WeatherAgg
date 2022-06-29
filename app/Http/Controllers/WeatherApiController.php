<?php

namespace App\Http\Controllers;

use App\Services\RequestStatService;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class WeatherApiController extends Controller
{
    public function __construct(
        protected WeatherService $weatherService,
        protected RequestStatService $statService,
    ) {}

    public function getByCity(Request $request, string $city): JsonResponse
    {
        $result = $this->weatherService->getByCity($city);
        $this->statService->recordEndpoint($request->path());

        return response()->json($result);
    }
}
