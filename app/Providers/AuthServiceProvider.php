<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Business;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Landowner;
use App\Models\Role;
use App\Models\User;
use App\Policies\BusinessAdminPolicy;
use App\Policies\BusinessPolicy;
use App\Policies\CouponPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\LandownerAdminPolicy;
use App\Policies\LandownerPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserManagementPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Customer::class => CustomerPolicy::class,
        Landowner::class => LandownerPolicy::class,
        Business::class => BusinessPolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserManagementPolicy::class,
        Coupon::class => CouponPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

//        Gate::define('access-business', function ($user) {
//            return $user && $user->isBusinessOwner();
//        });
//
//        Gate::define('have-business', function ($user) {
//            return $user && $user->isBusinessMemberDeactive() && $user->isAssociatedWithBusiness() && $user->business->user_id == auth()->id();
//        });

    }
}
