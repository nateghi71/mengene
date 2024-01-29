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
        'package_id',
        'expire_date',
        'counter_sms',
        'counter_Consultants',
    ];
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class , 'package_id');
    }

}


