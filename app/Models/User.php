<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\OauthAccessToken;
use App\Models\Business;
use App\Models\Customer;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'number',
        'city',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function businessCustomer()
    {
        return $this->hasManyThrough(
            Customer::class,
            Business::class,
//            'user_id',
//            'business_id',
//            'id',
//            'id',
        );
    }

    public function businessLandowner()
    {
        return $this->hasManyThrough(
            Customer::class,
            Business::class,
        );
    }

    public function ownedBusiness()
    {
        return $this->hasOne(Business::class);
    }

    public function businessUser()
    {
        return $this->hasMany(BusinessUser::class, 'user_id');
    }

    public function joinedBusinesses()
    {
        return $this->belongsToMany(Business::class, 'business_user', 'user_id', 'business_id');
    }

    // Check if the user is the owner of any business
    public function isBusinessOwner()
    {
        return $this->ownedBusiness()->exists();
    }

    // Check if the user has joined any businesses as a member
    public function isBusinessMember()
    {
        return $this->joinedBusinesses()->wherePivot('is_accepted', 1)->exists();
    }

    // Check if the user is already associated with any business (as owner or member)
    public function isAssociatedWithBusiness()
    {
        return $this->isBusinessOwner() || $this->isBusinessMember();
    }

//        return $this->hasMany(Business::class);
}
//projects
//    id - integer
//    name - string
//
//environments
//    id - integer
//    project_id - integer
//    name - string
//
//deployments
//    id - integer
//    environment_id - integer
//    commit_hash - string
