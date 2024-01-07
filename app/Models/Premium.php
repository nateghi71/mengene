<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premium extends Model
{
    use HasFactory;

    public $table = "premium";

    protected $fillable = [
        'business_id',
        'level',
        'expire_date',
        'counter_sms',
        'counter_Consultants',
    ];
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

}


