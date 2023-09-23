<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status', 'business_en_name', 'number', 'city', 'address', 'size', 'rooms', 'type', 'price', 'rent', 'is_star', 'expiry_date',
    ];
}
