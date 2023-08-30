<?php

namespace App\Http\Controllers\Api\V1\Admin;

use OpenApi\Attributes as OA;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Admin\CreateService;
use App\Http\Resources\Api\V1\SuccessResource;
use App\Http\Requests\Api\V1\Admin\CreateRequest;

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
    /**
     * @throws \Throwable
     */
    public function __invoke(CreateRequest $requestData, CreateService $service): JsonResponse
    {
        return SuccessResource::created(data: $service->create($requestData));
    }
}
