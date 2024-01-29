<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipFilePrice extends Model
{
    use HasFactory;
    protected $fillable = ['landowner_id' , 'price'];

    public function landowner()
    {
        return $this->belongsTo(Landowner::class , 'landowner_id');
    }
}
