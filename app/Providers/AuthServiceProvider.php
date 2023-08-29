<?php

namespace App\Providers;

use App\Services\Auth\JWT;
use Illuminate\Support\Facades\Auth;
use App\Services\Auth\JWTGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::extend('jwt', function ($app, $name, array $config) {
            return new JWTGuard(
                Auth::createUserProvider($config['provider']),
                $app->make('request'),
                new JWT(
                    config('jwt.private'),
                    config('jwt.public'),
                    config('jwt.passphrase'),
                )
            );
        });
    }
}
