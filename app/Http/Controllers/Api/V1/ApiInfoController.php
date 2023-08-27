<?php

namespace App\Http\Controllers\Api\V1;

use OpenApi\Attributes as OA;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ApiInfoResource;
use Illuminate\Http\JsonResponse;

#[OA\Info(version: 'v1', title: 'Pet Shop API - Swagger Documentation')]
#[OA\Server(url: 'https://petshop.test/')]
#[OA\Contact(name: 'Leonardo Carmo', email: 'ldiascarmo@gmail.com')]
class ApiInfoController extends Controller
{
    #[OA\Get(path: '/api/v1/info')]
    #[OA\Response(response: 200, description: 'Return the basic info of the api.')]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(ApiInfoResource::from([
            'app_name' => config('app.name'),
            'api_version' => config('app.api_latest'),
            'api_env' => config('app.env'),
        ]));
    }
}
