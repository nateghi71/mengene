<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Landowner extends Model
{
    use HasFactory , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','number','city','status','type_sale','type_work','type_build','scale','number_of_rooms',
        'description','rahn_amount','rent_amount','selling_price','elevator','parking','store','floor',
        'floor_number','business_id','user_id','is_star','expire_date'];

    public function suggestedCustomer()
    {
        return $this->belongsToMany(Customer::class, 'suggestions', 'landowner_id', 'customer_id');
    }

    public function notSuggestedCustomer()
    {
        return !$this->suggestedCustomer()->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function links()
    {
        return $this->morphMany(RandomLink::class , 'linkable');
    }

}
