<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessUser extends Model
{
    use HasFactory;

    public $table = "business_user";

    protected $fillable = [
        'is_accepted', 'joined_date'
    ];
}
