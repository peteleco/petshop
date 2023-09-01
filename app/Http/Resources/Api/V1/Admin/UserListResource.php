<?php

namespace App\Http\Resources\Api\V1\Admin;

use DateTimeInterface;
use Spatie\LaravelData\Data;

class UserListResource extends Data
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly ?DateTimeInterface $email_verified_at,
        public readonly ?string $avatar,
        public readonly string $address,
        public readonly string $phone_number,
        public readonly bool $is_marketing,
        public readonly DateTimeInterface $created_at,
        public readonly DateTimeInterface $updated_at,
        public readonly ?DateTimeInterface $last_login_at,
    ) {
    }
}
