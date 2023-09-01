<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\V1\PaginateRequest;
use App\Http\Resources\Api\V1\SuccessResource;
use App\Http\Requests\Api\V1\Admin\UserListRequest;
use App\Http\Resources\Api\V1\Admin\UserListResource;

class UserListController
{
    public function __invoke(UserListRequest $filters, PaginateRequest $paginate): JsonResponse
    {
        return SuccessResource::ok(
            UserListResource::collection(
                User::query()
                    ->filterByNotAdmin()
                    ->filterBy($filters)
                    ->paginate($paginate->limit)
                    ->withQueryString()
            )
        );
    }
}
