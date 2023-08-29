<?php

namespace App\Services\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Lcobucci\JWT\UnencryptedToken;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class JWTGuard implements Guard
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
    }

    public function user()
    {
        // Look Token Guard
        if ($this->user !== null) {
            return $this->user;
        }
        /*

         */
    }

    /**
     * @throws \Throwable
     */
    public function validate(array $credentials = []): bool
    {
        $user = $this->provider->retrieveByCredentials($credentials);
        throw_if(
            ! $user,
            UnprocessableEntityHttpException::class,
            __('Failed to authenticate user.')
        );
        $this->setLastAttempted($user);
        throw_if(
            ! $this->hasValidCredentials($user, $credentials),
            UnprocessableEntityHttpException::class,
            __('Failed to authenticate user.')
        );

        $token = $this->jwt->issueToken($user->getAuthIdentifier());

        $this->setToken($token)
            ->setUser($user);
        return true;
    }

    protected function hasValidCredentials(Authenticatable $user, array $credentials): bool
    {
        return $this->provider->validateCredentials($user, $credentials);
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $lastAttempted
     *
     * @return JWTGuard
     */
    public function setLastAttempted(Authenticatable $lastAttempted): JWTGuard
    {
        $this->lastAttempted = $lastAttempted;

        return $this;
    }

    public function setToken(UnencryptedToken $token): static
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return \Lcobucci\JWT\UnencryptedToken
     */
    public function getToken(): UnencryptedToken
    {
        return $this->token;
    }
}
