<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCreditItem extends Model
{
    use HasFactory;
    protected $table = 'order_credit_item' ;
    protected $fillable = ['credit_amount' , 'order_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
