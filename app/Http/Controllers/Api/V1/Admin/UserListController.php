<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\User;
use OpenApi\Attributes as OA;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\V1\PaginateRequest;
use App\Http\Resources\Api\V1\SuccessResource;
use App\Http\Requests\Api\V1\Admin\UserListRequest;
use App\Http\Resources\Api\V1\Admin\UserListResource;

class UserListController
{
    #[OA\Get(
        path: '/api/v1/admin/user-listing',
        summary: 'List non admin users',
        security: ["bearerAuth"],
        tags: ['Admin'],
        parameters: [
            new OA\Parameter(
                name: 'page',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'limit',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'sortBy',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'desc',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', enum: ['0', '1'])
            ),
            new OA\Parameter(
                name: 'first_name',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'email',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'phone',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'address',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'created_at',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'marketing',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', enum: ['0', '1'])
            ),
        ]
    )]
    #[OA\Response(response: 200, description: 'OK.')]
    #[OA\Response(response: 401, description: 'Unauthorized')]
    #[OA\Response(response: 403, description: 'Forbidden')]
    #[OA\Response(response: 422, description: 'Unprocessable entity.')]
    #[OA\Response(response: 500, description: 'Internal server error')]
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
