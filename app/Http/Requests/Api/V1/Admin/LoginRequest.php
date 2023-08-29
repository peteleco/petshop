<?php

namespace App\Http\Requests\Api\V1\Admin;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

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
