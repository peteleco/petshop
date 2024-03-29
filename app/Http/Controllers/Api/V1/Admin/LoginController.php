<?php

namespace App\Http\Controllers\Api\V1\Admin;

use OpenApi\Attributes as OA;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Admin\LoginService;
use App\Http\Resources\Api\V1\SuccessResource;
use App\Http\Requests\Api\V1\Admin\LoginRequest;

class LoginController extends Controller
{
    /**
     * @throws \Throwable
     */
    #[OA\Post(
        path: '/api/v1/admin/login',
        summary: 'Login an Admin account',
        requestBody: new OA\RequestBody(ref: "#/components/requestBodies/".LoginRequest::class),
        tags: ['Admin']
    )]
    #[OA\Response(response: 200, description: 'OK.')]
    #[OA\Response(response: 401, description: 'Unauthorized')]
    #[OA\Response(response: 422, description: 'Unauthorized')]
    #[OA\Response(response: 500, description: 'Internal server error')]
    public function __invoke(LoginRequest $requestData, LoginService $service): JsonResponse
    {
        return SuccessResource::ok(
            $service->login($requestData)
        );
    }
}
