<?php

namespace App\Models;

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory , SoftDeletes ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','number','city','status','type_sale','type_work','type_build','scale','number_of_rooms',
        'description','rahn_amount','rent_amount','selling_price','elevator','parking','store','floor',
        'floor_number','business_id','user_id','is_star','expire_date'
    ];

    public function scopeCustomerType(Builder $query)
    {
        if(request()->has('type'))
        {
            switch (request()->type)
            {
                case 'buy':
                    $query->where('type_sale' , 'buy')->whereNot('status' , 'deActive');
                    break;
                case 'rahn':
                    $query->where('type_sale' , 'rahn')->whereNot('status' , 'deActive');
                    break;
                case 'deActive':
                    $query->where('status' , 'deActive');
                    break;
            }
            return $query;
        }

        return $query->whereNot('status' , 'deActive');
    }

    protected function expireDate():Attribute
    {
        return Attribute::make(
            get : fn ($value) => verta($value)->format('Y-m-d'),
            set : fn ($value) => Verta::parse($value)->datetime()->format('Y-m-d'),
        );
    }
    protected function scale():Attribute
    {
        return Attribute::make(
            get : fn ($value) => number_format($value , 0 , '/' , ','),
            set : fn ($value) => str_replace( ',', '', $value),
        );
    }
    protected function rahnAmount():Attribute
    {
        return Attribute::make(
            get : function ($value){
                if($value < 1000)
                {
                    return number_format($value , 0 , '/' , ',') . ' میلیون';
                }
                else
                {
                    $tempValue = $value/1000;
                    return number_format($tempValue , 3 , '/' , ',') . ' میلیارد';
                }}  ,
            set : fn ($value) => str_replace( ',', '', $value),
        );
    }
    protected function rentAmount():Attribute
    {
        return Attribute::make(
            get : function ($value){
                if($value < 1000)
                {
                    return number_format($value , 0 , '/' , ',') . ' میلیون';
                }
                else
                {
                    $tempValue = $value/1000;
                    return number_format($tempValue , 3 , '/' , ',') . ' میلیارد';
                }}  ,
            set : fn ($value) => str_replace( ',', '', $value),
        );
    }
    protected function sellingPrice():Attribute
    {
        return Attribute::make(
            get : function ($value){
                if($value < 1000)
                {
                    return number_format($value , 0 , '/' , ',') . ' میلیون';
                }
                else
                {
                    $tempValue = $value/1000;
                    return number_format($tempValue , 3 , '/' , ',') . ' میلیارد';
                }}  ,
            set : fn ($value) => str_replace( ',', '', $value),
        );
    }
    protected function elevator():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'دارد' : 'ندارد',
        );
    }
    protected function parking():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'دارد' : 'ندارد',
        );
    }
    protected function store():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'دارد' : 'ندارد',
        );
    }
    protected function isStar():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'دارد' : 'ندارد',
        );
    }
    protected function status():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'active':
                        return 'فعال';
                    case 'unknown':
                        return 'نامعلوم';
                    case 'deActive':
                        return 'غیرفعال';
                }
            },
        );
    }
    protected function typeSale():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'buy':
                        return 'خرید';
                    case 'rahn':
                        return 'رهن و اجاره';
                }
            },
        );
    }
    protected function typeWork():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'home':
                        return 'خانه';
                    case 'office':
                        return 'دفتر';
                }
            },
        );
    }
    protected function typeBuild():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'house':
                        return 'ویلایی';
                    case 'apartment':
                        return 'ساختمان';
                }
            },
        );
    }

    public function suggestedLandowner()
    {
        return $this->belongsToMany(Landowner::class, 'suggestions', 'customer_id', 'landowner_id');
    }

    public function notSuggestedLandowner()
    {
        return !$this->suggestedLandowner()->exists();
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
