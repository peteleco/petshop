<?php

namespace App\Services\Auth;

use App\Models\User;
use Lcobucci\JWT\Token;
use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use Lcobucci\JWT\UnencryptedToken;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class JWTGuard implements Guard, \App\Contracts\Services\Auth\JWTGuard
{
    use GuardHelpers;

    protected Authenticatable $lastAttempted;

    protected JWT $jwt;

    protected Request $request;

    protected UnencryptedToken $token;

    public function __construct(UserProvider $provider, Request $request, JWT $jwt)
    {
        $this->provider = $provider;
        $this->user = null;
        $this->jwt = $jwt;
        $this->request = $request;
    }

    /**
     * @inheritdoc
     * @return \Illuminate\Contracts\Auth\Authenticatable|void|null
     * @throws \Throwable
     */
    public function user()
    {
        // Look Token Guard
        if ($this->user !== null) {
            return $this->user;
        }

        $token = $this->jwt->getToken();
        if (! $token) {
            return $this->user = null;
        }

        $uuid = $this->uuid($token, $this->jwt->getAuthIdentifierName());
        $user = $this->provider->retrieveById($uuid);
        if ($user instanceof User === false) {
            return $this->user = null;
        }
        // Move to builder tokenExists
        if (! $user->jwtTokens()->where('unique_id', $token->toString())->exists()) {
            return $this->user = null;
        }

        return $this->user = $user;
    }

    /**
     * @throws \Throwable
     */
    public function uuid(Token $token, string $authIdentifierName): string
    {
        if (strlen($authIdentifierName) === 0) {
            $authIdentifierName = 'uuid';
        }
        throw_if(
            $token instanceof \Lcobucci\JWT\Token\Plain === false,
            UnauthorizedHttpException::class,
            __('Invalid token. #02')
        );

        return $token->claims()->get($authIdentifierName);
    }

    /**
     * @param array{"email":string, "password":string} $credentials
     *
     * @inheritdoc
     * @throws \Throwable
     */
    public function validate(array $credentials = ['email' => '', 'password' => '']): bool
    {
        $user = $this->provider->retrieveByCredentials($credentials);
        throw_if(
            ! $user,
            UnprocessableEntityHttpException::class,
            __('Failed to authenticate user.')
        );
        $this->lastAttempted = $user;
        throw_if(
            ! $this->hasValidCredentials($user, $credentials),
            UnprocessableEntityHttpException::class,
            __('Failed to authenticate user.')
        );
        $this->setUser($user);
        $this->token = $this->jwt->issueToken($user->getAuthIdentifier());

        return true;
    }

    /**
     * @param array{"email":string, "password":string} $credentials
     */
    protected function hasValidCredentials(
        Authenticatable $user,
        array $credentials = ['email' => '', 'password' => '']
    ): bool {
        return $this->provider->validateCredentials($user, $credentials);
    }

    public function lastAttempted(): Authenticatable
    {
        return $this->lastAttempted;
    }

    public function token(): UnencryptedToken
    {
        return $this->token;
    }
}
