<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    public $table = "suggestions";

    protected $fillable = [
        'business_id',
        'suggest_business',
        'suggest_all',
    ];
}
