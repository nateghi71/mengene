<?php

namespace App\Models;

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialFile extends Model
{
    use HasFactory;

    public bool $ignoreMutator = false;

    protected $fillable = [
        'name','number','city_id','status','type_sale','type_work','type_build','scale','number_of_rooms',
        'description','rahn_amount','type_file','rent_amount','selling_price','elevator','parking','store','floor',
        'floor_number','user_id','is_star','expire_date'];

    public function scopeFilterByType(Builder $query)
    {
        if(request()->has('type'))
        {
            switch (request()->type)
            {
                case 'buy':
                    $query->where('type_sale' , 'buy')->where('status' , 'active');
                    break;
                case 'rahn':
                    $query->where('type_sale' , 'rahn')->where('status' , 'active');
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
    protected function scale():Attribute
    {
        return Attribute::make(
            get : fn ($value) => number_format($value , 0 , '/' , ',') . ' متر',
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
    protected function typeFile():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'public':
                        return 'عمومی';
                    case 'buy':
                        return 'فایل پولی';
                    case 'subscription':
                        return 'اشتراک ویژه';
                }
            },
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
                        return 'فروش';
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

}
