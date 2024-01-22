<?php

namespace App\Models;

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Landowner extends Model
{
    use HasFactory , SoftDeletes;

    public bool $ignoreMutator = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','number','area','city_id','status','type_sale','type_work','type_build','scale','number_of_rooms',
        'description','rahn_amount','access_level','rent_amount','selling_price','elevator','parking','store','floor',
        'floor_number','business_id','user_id','is_star','expire_date'];

    public function scopeFilter(Builder $query)
    {
        if (request()->has('type_sale'))
        {
            $query->where('type_sale' , request()->type_sale);
        }

        if (request()->has('access_level'))
        {
            $query->where('access_level' , request()->access_level);
        }

        if (request()->has('type_work'))
        {
            $query->where('type_work' , request()->type_work);
        }

        if (request()->has('type_build'))
        {
            $query->where('type_build' , request()->type_build);
        }

        if (request()->has('status'))
        {
            $query->where('status' , request()->status);
        }
        else
        {
            $query->whereNot('status' , 'deActive');
        }

        $query->orderByDesc('is_star')->orderBy('status');

        if(request()->has('sortBy'))
        {
            $sortBy = request()->sortBy;

            switch ($sortBy) {
                case 'max_days':
                    $query->orderByDesc('expire_date');
                    break;
                case 'min_days':
                    $query->orderBy('expire_date');
                    break;
                case 'max_price':
                    $query->orderByDesc('selling_price' )->orderByDesc('rahn_amount' );
                    break;
                case 'min_price':
                    $query->orderBy('selling_price')->orderBy('rahn_amount');
                    break;
                case 'max_scale':
                    $query->orderByDesc('scale');
                    break;
                case 'min_scale':
                    $query->orderBy('scale');
                    break;
                case 'max_rooms':
                    $query->orderByDesc('number_of_rooms');
                    break;
                case 'min_rooms':
                    $query->orderBy('number_of_rooms');
                    break;
                default:
                    $query;
                    break;
            }
        }
        else
        {
            $query->orderByDesc('expire_date');
        }

        return $query;
    }
    public function scopeSearch($query)
    {
        if(request()->has('search'))
        {
            $keyword = trim(request()->search);
            if ($keyword != '') {
                $query->where('name', 'LIKE', '%'. $keyword .'%');
            }
        }

        return $query;
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
    protected function accessLevel():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'public':
                        return 'عمومی';
                    case 'private':
                        return 'خصوصی';
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


    public function dontSuggestionForCustomer()
    {
        return $this->belongsToMany(Customer::class, 'dont_suggestions', 'landowner_id', 'customer_id');
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
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

}
