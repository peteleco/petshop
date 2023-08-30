<?php

namespace App\Http\Requests\Api\V1\Admin;

use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\Hidden;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Same;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\BooleanType;

#[OA\RequestBody(
    request: CreateRequest::class,
    content: [
        new OA\MediaType(
            mediaType: 'application/x-www-form-urlencoded',
            schema: new OA\Schema(
                required: [
                    'first_name',
                    'last_name',
                    'email',
                    'password',
                    'password_confirmation',
                    'address',
                    'phone_number',
                    'marketing',
                ],
                properties: [
                    new OA\Property(
                        property: 'first_name',
                        description: 'First name',
                        type: 'string',
                        default: 'Say my name'
                    ),
                    new OA\Property(
                        property: 'last_name',
                        title: 'Last name',
                        description: 'Last name',
                        type: 'string',
                        default: 'My last name'
                    ),
                    new OA\Property(
                        property: 'email',
                        description: 'Email',
                        type: 'string',
                        default: 'hi@buckhill.co.uk'
                    ),
                    new OA\Property(
                        property: 'password',
                        description: 'Password',
                        type: 'password',
                        default: 'admin admin'
                    ),
                    new OA\Property(
                        property: 'password_confirmation',
                        description: 'Confirm your password',
                        type: 'password',
                        default: 'admin admin'
                    ),
                    new OA\Property(
                        property: 'address',
                        description: 'Address',
                        type: 'string',
                        default: 'My address'
                    ),
                    new OA\Property(
                        property: 'phone_number',
                        description: 'Phone number',
                        type: 'string',
                        default: '+55 21 9999-92899'
                    ),
                    new OA\Property(
                        property: 'marketing',
                        description: 'Sign newsletter',
                        type: '0|1',
                        default: '1',
                        nullable: true
                    ),
                ]
            )
        ),
    ]
)]
class CreateRequest extends Data
{
    public function __construct(
        #[Min(3)]
        #[Max(255)]
        public readonly string $first_name,
        #[Min(3)]
        #[Max(255)]
        public readonly string $last_name,
        #[Max(255)]
        #[Email()]
        #[Unique(table: 'users', column: 'email')]
        public readonly string $email,
        #[Password(min: 8)]
        #[Max(255)]
        #[Hidden]
        public readonly string $password,
        #[Same('password')]
        #[Hidden]
        public readonly string $password_confirmation,
        #[Max(255)]
        public readonly string $address,
        #[Max(255)]
        public readonly string $phone_number,
        #[BooleanType]
        #[Nullable]
        public readonly bool $marketing = false,
    ) {
    }
}
