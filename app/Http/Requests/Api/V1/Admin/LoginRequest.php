<?php

namespace App\Http\Requests\Api\V1\Admin;

use OpenApi\Attributes as OA;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;

#[OA\RequestBody(
    request: LoginRequest::class,
    content: [
        new OA\MediaType(
            mediaType: 'application/x-www-form-urlencoded',
            schema: new OA\Schema(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', title: 'Email', description: 'User email', type: 'string', default: 'admin@buckhill.co.uk'),
                    new OA\Property(property: 'password', title: 'Password', description: 'User password', type: 'string', default: 'admin'),
                ]
            )
        )
    ]
)]
class LoginRequest extends Data
{
    public function __construct(
        #[Required,
            Email]
        public readonly string $email,
        #[Required]
        public readonly string $password,
    ) {
    }
}
