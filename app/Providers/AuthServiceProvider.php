<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Auth\BearerGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

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
        // ガードの追加
        Auth::extend('bearer', static function ($app, $name, $config) {
            $userProvider = $app['auth']->createUserProvider($config['provider'] ?? null);
            $request = $app->make('request');

            return new BearerGuard($userProvider, $request);
        });
    }
}
