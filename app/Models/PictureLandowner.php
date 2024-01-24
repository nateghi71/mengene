<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PictureLandowner extends Model
{
    use HasFactory;

    public $table = "pictures_landowner";

    protected $fillable = [
        'landowner_id',
        'image',
    ];

    public function landowner()
    {
        return $this->belongsTo(Landowner::class , 'landowner_id');
    }

}
