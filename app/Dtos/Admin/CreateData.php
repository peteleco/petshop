<?php

namespace App\Dtos\Admin;

use Spatie\LaravelData\Data;
use App\Casts\HashPasswordCast;
use Spatie\LaravelData\Attributes\Hidden;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\MapInputName;

class CreateData extends Data
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        #[Hidden]
        #[WithCast(HashPasswordCast::class)]
        public readonly string $password,
        public readonly string $address,
        public readonly string $phone_number,
        #[MapInputName('marketing')]
        public readonly bool $is_marketing = false,
        public readonly bool $is_admin = true
    ) {
    }
}
