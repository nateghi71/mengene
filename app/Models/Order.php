<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id' , 'coupon_id' , 'business_id' , 'amount' , 'tax_amount'
        , 'coupon_amount' , 'paying_amount' , 'payment_type' , 'order_type', 'payment_status'
        , 'ref_id' , 'token' , 'gateway_name' , 'use_wallet', 'description'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }


}
