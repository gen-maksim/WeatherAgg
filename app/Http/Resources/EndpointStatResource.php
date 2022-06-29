<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EndpointStatResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'endpoint' => $this['_id'],
            'call_count' => $this['count'],
        ];
    }
}
