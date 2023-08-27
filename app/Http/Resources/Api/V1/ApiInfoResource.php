<?php

namespace App\Http\Resources\Api\V1;

use Spatie\LaravelData\Data;

class ApiInfoResource extends Data
{
    public function __construct(
        public readonly string $app_name,
        public readonly string $api_version,
        public readonly string $api_env,
    )
    {
    }
}
