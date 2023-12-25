<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PictureLandowner extends Model
{
    use HasFactory , SoftDeletes;

    public $table = "pictures_landowner";

    protected $fillable = [
        'landowner_id',
        'image',
    ];
}
