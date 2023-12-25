<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    use HasFactory;

    public $table = "user_codes";

    protected $fillable = [
        'random_string','number_verified','user_number','code'
    ];
}
