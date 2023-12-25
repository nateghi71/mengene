<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory , SoftDeletes;

//    protected $primaryKey = 'en_name';
//    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'name', 'en_name', 'user_id', 'image', 'city', 'area', 'address',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'business_id', 'id');
    }

    public function landowners()
    {
        return $this->hasMany(Landowner::class, 'business_id', 'id');
    }

//    public function users()
//    {
//        return $this->belongsToMany(User::class)->withPivot('is_accepted');
//    }
    // Define the relationship with the members
    public function members()
    {
        return $this->belongsToMany(User::class, 'business_user', 'business_id', 'user_id')->withPivot('is_accepted');
    }

    // Define the relationship with the owner
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function premiumLevel()
    {
        return $this->hasOne(Premium::class, 'business_id');
    }
}

