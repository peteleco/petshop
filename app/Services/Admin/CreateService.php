<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Dtos\Admin\CreateData;
use App\Actions\Admin\CreateAction;
use App\Http\Requests\Api\V1\Admin\LoginRequest;
use App\Http\Requests\Api\V1\Admin\CreateRequest;
use App\Http\Resources\Api\V1\Auth\LoginResource;
use App\Http\Resources\Api\V1\Admin\CreateResource;

class CreateService
{
    public function __construct(
        protected readonly CreateAction $createAction,
        protected readonly LoginService $loginService,
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function create(CreateRequest $requestData): CreateResource
    {
        $this->createAction($admin = new User(), CreateData::from($requestData, ['password' => $requestData->password]));
        $loginResource = $this->login(LoginRequest::from(['email' => $requestData->email, 'password' => $requestData->password]));

        return CreateResource::from($admin)->additional(['token' => $loginResource->token]);
    }

    public function createAction(User $admin, CreateData $data): void
    {
        $this->createAction->execute($admin, $data);
    }

    /**
     * @throws \Throwable
     */
    public function login(LoginRequest $data): LoginResource
    {
        return $this->loginService->login($data);
    }
}
