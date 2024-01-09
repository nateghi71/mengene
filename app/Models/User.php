<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable , HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'number',
        'city_id',
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

    public function ownedBusiness()
    {
        return $this->hasOne(Business::class);
    }

    public function isFreeUser() :bool
    {
        return $this->ownedBusiness()->first()->premium->level === 'free';
    }
    public function isVipUser():bool
    {
        return $this->ownedBusiness()->first()->premium->level === 'vip';
    }
    public function isMidLevelUser():bool
    {
        return $this->ownedBusiness()->first()->premium->level === 'midLevel';
    }
    public function premiumExpireDate()
    {
        return $this->ownedBusiness()->first()->premium->expire_date;
    }
    public function getPremiumCountSms()
    {
        return $this->ownedBusiness()->first()->premium->counter_sms;
    }
    public function getPremiumCountConsultants()
    {
        return $this->ownedBusiness()->first()->premium->counter_Consultants;
    }
    public function incrementPremiumCountSms()
    {
        return $this->ownedBusiness()->first()->premium()->increment('counter_sms');
    }
    public function incrementPremiumCountConsultants()
    {
        return $this->ownedBusiness()->first()->premium()->increment('counter_Consultants');
    }
    public function decrementPremiumCountConsultants()
    {
        return $this->ownedBusiness()->first()->premium()->decrement('counter_Consultants');
    }

    public function businessUser()
    {
        return $this->hasMany(BusinessUser::class, 'user_id');
    }

    public function joinedBusinesses()
    {
        return $this->belongsToMany(Business::class, 'business_user', 'user_id', 'business_id')->withPivot('is_accepted');
    }

    public function business()
    {
        if($this->ownedBusiness()->exists())
            return $this->ownedBusiness()->select('businesses.id', 'businesses.name', 'businesses.en_name', 'businesses.user_id', 'businesses.image', 'businesses.city_id', 'businesses.area', 'businesses.address', 'businesses.created_at', 'businesses.updated_at')->first();

        elseif ($this->joinedBusinesses()->wherePivot('is_accepted', 1)->exists())
            return $this->joinedBusinesses()->wherePivot('is_accepted', 1)
                ->select('businesses.id', 'businesses.name', 'businesses.en_name', 'businesses.user_id', 'businesses.image', 'businesses.city_id', 'businesses.area', 'businesses.address', 'businesses.created_at', 'businesses.updated_at')->first();

        return null;
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function landowners()
    {
        return $this->hasMany(Landowner::class);
    }

}
