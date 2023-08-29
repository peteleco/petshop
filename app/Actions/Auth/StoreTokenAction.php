<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Models\JwtToken;
use Lcobucci\JWT\UnencryptedToken;

class StoreTokenAction
{
    public function execute(User $user, JwtToken $model, UnencryptedToken $token): void
    {
        $model->setAttribute('token_title', $user->getAttribute('first_name'));
        $model->setAttribute('expires_at', $token->claims()->get('eat'));
        $model->setAttribute('user_id', $user->getKey());
        $model->setAttribute('unique_id', $token->toString());
        $model->save();
    }
}
