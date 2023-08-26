<?php

use function Pest\Laravel\{getJson};

it('request api/v1/info', function () {
    $response = getJson(route('api.info'));
    $response->assertStatus(200);
    $response->assertJsonFragment(\App\Http\Resources\Api\V1\ApiInfoResource::from([
        'api_env' => 'testing',
        'api_version' => 'v1',
        'app_name' => 'PetShop API'
    ])->toArray());
});
