<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PopularEndpointRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mode' => ['sometimes', 'string', 'in:month,week,day,all'],
            'limit' => ['sometimes', 'integer'],
        ];
    }
}
