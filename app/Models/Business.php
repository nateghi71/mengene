<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

//    protected $primaryKey = 'en_name';
//    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'en_name', 'user_id', 'image', 'city', 'area', 'address',
    ];


    public function customers()
    {
        return $this->hasMany(Customer::class, 'business_en_name', 'en_name');
    }

    public function landowners()
    {
        return $this->hasMany(Landowner::class, 'business_en_name', 'en_name');
    }

//    public function users()
//    {
//        return $this->belongsToMany(User::class)->withPivot('is_accepted');
//    }
    // Define the relationship with the members
    public function members()
    {
        return $this->belongsToMany(User::class, 'business_user', 'business_id', 'user_id');
    }

    // Define the relationship with the owner
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
