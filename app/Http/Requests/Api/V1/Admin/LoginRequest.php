<?php

namespace App\Http\Requests\Api\V1\Admin;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;

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
