<?php

namespace App\Providers;

use App\Models\Business;
use App\Models\Landowner;
use App\Policies\BusinessPolicy;
use App\Policies\LandownerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\CustomerPolicy;
use App\Models\Customer;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Customer::class => CustomerPolicy::class,
        Landowner::class => LandownerPolicy::class,
        Business::class => BusinessPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access-business', function ($user) {
            return $user && $user->isBusinessOwner();
        });

        Gate::define('have-business', function ($user) {
            return $user && $user->business && $user->business->user_id == auth()->id();
        });

        //
    }
}
