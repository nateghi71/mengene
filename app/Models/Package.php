<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = ['name' , 'price' , 'time'];

    public function premiums()
    {
        return $this->hasMany(Premium::class , 'package_id');
    }
}
