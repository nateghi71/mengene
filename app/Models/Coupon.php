<?php

namespace App\Models;

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['name' , 'code' , 'percentage' , 'expire_date' , 'description'];

    public bool $ignoreMutator = false;

    protected function expireDate():Attribute
    {
        return Attribute::make(
            get : fn ($value) => verta($value)->format('Y-m-d'),
            set : function ($value){
                if($this->ignoreMutator){
                    return $value;
                }
                else
                {
                    return Verta::parse($value)->datetime()->format('Y-m-d');
                }
            }
        );
    }

}
