<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\Assert as PHPUnitAssert;
use Spatie\LaravelData\Contracts\DataObject;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    #[NoReturn]
    public function assertInvokedControllerUsesDataObjectOnRequest(string $controller, string $form_request): void
    {
        // All controllers must be invoked
        $method = '__invoke';

        PHPUnitAssert::assertTrue(is_subclass_of($form_request, DataObject::class), $form_request . ' is not a type of Request Data Object');

        try {
            $reflector = new \ReflectionClass($controller);
            $action = $reflector->getMethod($method);
        } catch (\ReflectionException $exception) {
            PHPUnitAssert::fail('Controller action could not be found: ' . $controller . '@' . $method);
        }

        PHPUnitAssert::assertTrue($action->isPublic(), 'Action "' . $method . '" is not public, controller actions must be public.');

        $actual = collect($action->getParameters())->contains(function ($parameter) use ($form_request) {
            return $parameter->getType() instanceof \ReflectionNamedType && $parameter->getType()->getName() === $form_request;
        });

        PHPUnitAssert::assertTrue($actual, 'Action "' . $method . '" does not have validation using the "' . $form_request . '" Request Data Object.');
    }
}
