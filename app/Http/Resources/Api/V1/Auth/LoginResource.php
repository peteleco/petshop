<?php

namespace App\Http\Resources\Api\V1\Auth;

use Spatie\LaravelData\Data;

class LoginResource extends Data
{
    public function __construct(public readonly string $token)
    {
    }
}
