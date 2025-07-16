<?php

namespace App\Providers;

use App\Events\CheckAllJobsForExpiry;
use App\Events\CheckJobForExpiry;
use App\Events\JobExpiryCheckRequested;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\UpdateAllJobStatusesOnExpiry;
use App\Listeners\UpdateJobStatusOnExpiry;
use App\Models\LoginEvent;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(CheckJobForExpiry::class, [UpdateJobStatusOnExpiry::class, 'handle']);
        Event::listen(CheckAllJobsForExpiry::class, [UpdateAllJobStatusesOnExpiry::class, 'handle']);

        // Define the 'isAdmin' Gate
        Gate::define('isAdmin', function (User $user) {
            // This closure receives the authenticated User model instance.
            // It should return true if the user is an admin, false otherwise.
            return $user->role === 'admin';
        });
    }
}
