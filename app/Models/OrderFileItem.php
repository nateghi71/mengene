<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFileItem extends Model
{
    use HasFactory;
    protected $table = 'order_file_item' ;
    protected $fillable = ['price' , 'order_id' , 'landowner_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function landowner()
    {
        return $this->belongsTo(Landowner::class);
    }

}
