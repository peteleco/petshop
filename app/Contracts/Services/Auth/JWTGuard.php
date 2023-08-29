<?php

namespace App\Contracts\Services\Auth;

use Lcobucci\JWT\UnencryptedToken;
use Illuminate\Contracts\Auth\Authenticatable;

interface JWTGuard
{
    public function lastAttempted(): Authenticatable;

    public function token(): UnencryptedToken;
}
