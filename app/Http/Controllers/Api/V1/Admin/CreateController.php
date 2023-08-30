<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\User;
use OpenApi\Attributes as OA;
use App\Dtos\Admin\CreateData;
use Illuminate\Http\JsonResponse;
use App\Actions\Admin\CreateAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\SuccessResource;
use App\Http\Requests\Api\V1\Admin\CreateRequest;
use App\Http\Resources\Api\V1\Admin\CreateResource;

#[OA\Post(
    path: '/api/v1/admin/create',
    summary: 'Create an Admin account',
    requestBody: new OA\RequestBody(ref: "#/components/requestBodies/".CreateRequest::class),
    tags: ['Admin']
)]
#[OA\Response(response: 200, description: 'OK.')]
#[OA\Response(response: 422, description: 'Unprocessable Entity')]
#[OA\Response(response: 500, description: 'Internal server error')]
class CreateController extends Controller
{
    public function __invoke(CreateRequest $requestData, CreateAction $action): JsonResponse
    {
        $action->execute($admin = new User(), CreateData::from($requestData, ['password' => $requestData->password]));

        return SuccessResource::created(data: CreateResource::from($admin));
    }
}
