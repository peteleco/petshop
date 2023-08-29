<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use Lcobucci\JWT\UnencryptedToken;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
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

    /**
     * @inheritdoc
     * @return \Illuminate\Contracts\Auth\Authenticatable|void|null
     */
    public function user()
    {
        // Look Token Guard
        if ($this->user !== null) {
            return $this->user;
        }
        /*
        if ($this->jwt->setRequest($this->request)->getToken() &&
            ($payload = $this->jwt->check(true)) &&
            $this->validateSubject()
        ) {
            return $this->user = $this->provider->retrieveById($payload['sub']);
        }
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
     *
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
     */
    public function getToken(): UnencryptedToken
    {
        return $this->token;
    }
}
