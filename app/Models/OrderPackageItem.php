<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPackageItem extends Model
{
    use HasFactory;
    protected $table = 'order_package_item' ;
    protected $fillable = ['price' , 'order_id' , 'package_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

}
