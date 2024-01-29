<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'role_id',
        'status',
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
    public function businessUser()
    {
        return $this->hasMany(BusinessUser::class, 'user_id');
    }

    public function joinedBusinesses()
    {
        return $this->belongsToMany(Business::class, 'business_user', 'user_id', 'business_id')->withPivot('is_accepted');
    }

    public function isBanned() :bool
    {
        return $this->status === 'deActive';
    }
    public function isFreeUser() :bool
    {
        return $this->business()->premium->package->name === 'free';
    }
    public function isBronzeUser():bool
    {
        return $this->business()->premium->package->name;
    }
    public function isSilverUser():bool
    {
        return $this->business()->premium->package->name === 'silver';
    }
    public function isGoldenUser():bool
    {
        return $this->business()->premium->package->name === 'golden';
    }
    public function incrementPremiumCountSms()
    {
        $this->business()->wallet -= 200;
        $this->business()->save();
        $this->business()->premium()->increment('counter_sms');
    }

    public function getPremiumCountConsultants()
    {
        return $this->business()->premium->counter_Consultants;
    }
    public function incrementPremiumCountConsultants()
    {
        return $this->business()->premium()->increment('counter_Consultant');
    }
    public function decrementPremiumCountConsultants()
    {
        return $this->business()->premium()->decrement('counter_Consultant');
    }
    public function business()
    {
        if($this->ownedBusiness()->exists())
            return $this->ownedBusiness()->first();
        elseif ($this->joinedBusinesses()->wherePivot('is_accepted', 1)->exists())
            return $this->joinedBusinesses()->wherePivot('is_accepted', 1)->first();

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
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

}
