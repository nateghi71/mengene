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

    public bool $ignoreMutator = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_star' ,'type_sale','access_level','status','name','number','scale','city_id',
        'area','expire_date','rahn_amount','rent_amount','selling_price','type_work','type_build',
        'document' ,'address','year_of_construction','year_of_reconstruction',
        'number_of_rooms','floor','floor_number','floor_covering' ,'cooling' ,
        'heating' ,'cabinets' ,'view','type_file','description','business_id','user_id',
        'number_of_unit_in_floor', 'number_unit', 'postal_code', 'plaque', 'state_of_electricity',
        'state_of_water', 'state_of_gas', 'state_of_phone', 'Direction_of_building', 'water_heater',
        'discharge', 'elevator', 'parking', 'store', 'is_star', 'exist_owner', 'terrace', 'air_conditioning_system',
        'yard', 'pool', 'sauna', 'Jacuzzi', 'video_iphone', 'Underground', 'Wall_closet',
    ];

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

    protected function scale():Attribute
    {
        return Attribute::make(
            get : fn ($value) => number_format($value , 0 , '/' , ',') . ' متر',
            set : fn ($value) => str_replace( ',', '', $value),
        );
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
    protected function rahnAmount():Attribute
    {
        return Attribute::make(
            get : fn ($value) => number_format($value , 0 , '/' , ',') . ' تومان',
            set : fn ($value) => str_replace( ',', '', $value),
        );
    }
    protected function rentAmount():Attribute
    {
        return Attribute::make(
            get : fn ($value) => number_format($value , 0 , '/' , ',') . ' تومان',
            set : fn ($value) => str_replace( ',', '', $value),
        );
    }
    protected function sellingPrice():Attribute
    {
        return Attribute::make(
            get : fn ($value) => number_format($value , 0 , '/' , ',') . ' تومان',
            set : fn ($value) => str_replace( ',', '', $value),
        );
    }

    protected function typeWork():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'home':
                        return 'مسکونی';
                    case 'office':
                        return 'اداری';
                    case 'commercial':
                        return 'تجاری';
                    case 'training':
                        return 'اموزشی';
                    case 'industrial':
                        return 'صنعتی';
                    case 'other':
                        return 'سایر';
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
                    case 'shop':
                        return 'مغازه';
                    case 'land':
                        return 'زمین';
                    case 'workshop':
                        return 'کارگاه';
                    case 'parking':
                        return 'پارکینگ';
                    case 'store':
                        return 'انباری';
                    case 'hall':
                        return 'سالن';
                }
            },
        );
    }
    protected function document():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'all':
                        return 'همه';
                    case 'six_dongs':
                        return 'شش دانگ';
                    case 'mangolehdar':
                        return 'منقوله دار';
                    case 'tak_bargeh':
                        return 'تک برگه';
                    case 'varasehee':
                        return 'ورثه ای';
                    case 'almosana':
                        return 'المثنی';
                    case 'vekalati':
                        return 'وکالتی';
                    case 'benchag':
                        return 'بنچاق';
                    case 'sanad_rahni':
                        return 'سند رهنی';
                    case 'gholnameh':
                        return 'قولنامه';
                }
            },
        );
    }
    protected function stateOfElectricity():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'nothing':
                        return 'ندارد';
                    case 'shared':
                        return 'اشتراکی';
                    case 'exclusive':
                        return 'اختصاصی';
                }
            },
        );
    }
    protected function stateOfWater():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'nothing':
                        return 'ندارد';
                    case 'shared':
                        return 'اشتراکی';
                    case 'exclusive':
                        return 'اختصاصی';
                }
            },
        );
    }
    protected function stateOfGas():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'nothing':
                        return 'ندارد';
                    case 'shared':
                        return 'اشتراکی';
                    case 'exclusive':
                        return 'اختصاصی';
                }
            },
        );
    }
    protected function stateOfPhone():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'nothing':
                        return 'ندارد';
                    case 'working':
                        return 'فعال است';
                    case 'not_working':
                        return 'فعال نیست';
                }
            },
        );
    }
    protected function DirectionOfBuilding():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'north':
                        return 'شمال';
                    case 'south':
                        return 'جنوب';
                    case 'east':
                        return 'شرق';
                    case 'west':
                        return 'غرب';
                }
            },
        );
    }
    protected function waterHeater():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'water_heater':
                        return 'ابگرمکن';
                    case 'powerhouse':
                        return 'موتورخانه';
                    case 'package':
                        return 'پکیج';
                }
            },
        );
    }

    protected function discharge():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'شده' : 'نشده',
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
    protected function existOwner():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'هست' : 'نیست',
        );
    }
    protected function terrace():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'دارد' : 'ندارد',
        );
    }
    protected function airConditioningSystem():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'دارد' : 'ندارد',
        );
    }
    protected function yard():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'دارد' : 'ندارد',
        );
    }
    protected function pool():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'دارد' : 'ندارد',
        );
    }
    protected function sauna():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'دارد' : 'ندارد',
        );
    }
    protected function Jacuzzi():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'دارد' : 'ندارد',
        );
    }
    protected function videoIphone():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'دارد' : 'ندارد',
        );
    }
    protected function Underground():Attribute
    {
        return Attribute::make(
            get : fn ($value) => $value ? 'دارد' : 'ندارد',
        );
    }
    protected function WallCloset():Attribute
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

    protected function floorCovering():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'ceramic':
                        return 'سرامیک';
                    case 'mosaic':
                        return 'موزاییک';
                    case 'wooden':
                        return 'منقوله دارچوب';
                    case 'pvc':
                        return 'پی وی سی';
                    case 'others':
                        return 'سایر';
                }
            },
        );
    }
    protected function cooling():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'water_cooler':
                        return 'کولر ابی';
                    case 'air_cooler':
                        return 'کولر گازی';
                    case 'nothing':
                        return 'ندارد';
                }
            },
        );
    }
    protected function heating():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'heater':
                        return 'بخاری';
                    case 'fire_place':
                        return 'شومینه';
                    case 'underfloor_heating':
                        return 'گرمایش از کف';
                    case 'split':
                        return 'اسپلیت';
                    case 'nothing':
                        return 'ندارد';
                }
            },
        );
    }
    protected function cabinets():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'wooden':
                        return 'بخاری';
                    case 'memberan':
                        return 'شومینه';
                    case 'metal':
                        return 'گرمایش از کف';
                    case 'melamine':
                        return 'اسپلیت';
                    case 'mdf':
                        return 'ام دی اف';
                    case 'mdf_and_metal':
                        return 'بدنه فلزی و در ام دی اف';
                    case 'high_glass':
                        return 'های گلس';
                    case 'nothing':
                        return 'ندارد';
                }
            },
        );
    }
    protected function view():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'brick':
                        return 'اجری';
                    case 'rock':
                        return 'سنگی';
                    case 'Cement':
                        return 'سیمانی';
                    case 'composite':
                        return 'کامپوزیت';
                    case 'Glass':
                        return 'شیشه ای';
                    case 'ceramic':
                        return 'سرامیک';
                    case 'hybrid':
                        return 'ترکیبی';
                    case 'others':
                        return 'سایر';
                }
            },
        );
    }
    protected function type_file():Attribute
    {
        return Attribute::make(
            get : function ($value){
                switch ($value)
                {
                    case 'business':
                        return 'املاک';
                    case 'buy':
                        return 'فروشی';
                    case 'subscription':
                        return 'اشتراکی';
                    case 'people':
                        return 'مردم';
                }
            },
        );
    }


    public function dontSuggestedLandowner()
    {
        return $this->belongsToMany(Landowner::class, 'dont_suggestions', 'customer_id', 'landowner_id');
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
