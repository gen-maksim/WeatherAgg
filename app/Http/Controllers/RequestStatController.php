<?php

namespace App\Http\Controllers;

use App\Http\Requests\PopularEndpointRequest;
use App\Http\Resources\EndpointStatResource;
use App\Services\RequestStatService;
use Illuminate\Http\JsonResponse;

class RequestStatController extends Controller
{
    public function __construct(protected RequestStatService $statService) {}

    public function getPopularEndpoint(PopularEndpointRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        $popular = $this->statService->getPopular($attributes['mode'] ?? 'day', $attributes['limit'] ?? 10);

        return response()->json(EndpointStatResource::collection($popular));
    }
}
