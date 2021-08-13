<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // SFORTIFY: Increase throttle in debug mode
        if (env('APP_DEBUG')) {
            RateLimiter::for('login', function() {
                Limit::perMinute(10);
            });
        }

        // SFORTIFY: Create password reset route
        ResetPassword::createUrlUsing(function($user, string $token) {
            return env('SPA_URL') . '/reset-password?email=' . $user->email . '&token=' . $token;
        });
    }
}
