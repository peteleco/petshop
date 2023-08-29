<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\JwtToken;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\UnencryptedToken;
use App\Actions\Auth\StoreTokenAction;
use App\Actions\Auth\UpdateLastLoginAction;
use App\Http\Requests\Api\V1\Admin\LoginRequest;
use App\Http\Resources\Api\V1\Auth\LoginResource;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginService
{
    public function __construct(
        public UpdateLastLoginAction $updateLastLoginAction,
        public StoreTokenAction $storeTokenAction
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function login(LoginRequest $data): LoginResource
    {
        $token = DB::transaction(function () use ($data) {
            $this->validate($data);
            $this->validateAdmin($admin = $this->user());
            $this->updateLastLogin($admin);
            $this->storeTokenAction($admin, new JwtToken(), $token = $this->getAuthToken());
            return $token->toString();
        });
        return LoginResource::from(['token' => $token]);
    }

    private function validate(LoginRequest $data): void
    {
        \Auth::validate($data->toArray());
    }

    private function user(): User
    {
        return \Auth::user();
    }

    private function updateLastLogin(\App\Models\User $admin): void
    {
        $this->updateLastLoginAction->execute($admin);
    }

    private function storeTokenAction(User $admin, JwtToken $model, UnencryptedToken $token): void
    {
        $this->storeTokenAction->execute($admin, $model, $token);
    }

    private function getAuthToken(): UnencryptedToken
    {
        return \Auth::getToken();
    }

    /**
     * @throws \Throwable
     */
    private function validateAdmin(User $admin): void
    {
        throw_if(
            ! $admin->isAdmin(),
            UnauthorizedHttpException::class,
            __('Unauthorized. Please provide valid credentials or log in to access this resource.')
        );
    }
}
