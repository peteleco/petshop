<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Contracts\DataObject;
use Symfony\Component\HttpFoundation\Response;

class SuccessResource extends Data
{
    public function __construct(
        public readonly DataObject $data,
        public readonly int $success = 1,
        public readonly string $error = '',
        public readonly array $errors = [],
        public readonly array $trace = [],
    ) {
    }

    public static function ok(DataObject $data, Request $request): \Illuminate\Http\JsonResponse|Response
    {
        return static::from([
            'data' => $data,
        ])->toResponse($request)->setStatusCode(Response::HTTP_OK);
    }
}
