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
        'is_star' ,'type_sale','access_level','status','name','number','scale','city_id',
        'area','expire_date','rahn_amount','rent_amount','selling_price','type_work','type_build',
        'document' ,'discharge','exist_owner','address','year_of_construction','year_of_reconstruction',
        'number_of_rooms','elevator','parking','store','floor','floor_number','floor_covering' ,'cooling' ,
        'heating' ,'cabinets' ,'view','type_file','description','business_id','user_id'
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

        if (request()->has('type_file'))
        {
            $query->where('type_file' , request()->type_file);
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

        $query->orderByDesc('is_star')->orderBy('type_file')->orderBy('status');

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
                        return 'فروش';
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
                        return 'خانه';
                    case 'office':
                        return 'دفتر';
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
                        return 'چوبی';
                    case 'memberan':
                        return 'ممبران';
                    case 'metal':
                        return 'فلزی';
                    case 'melamine':
                        return 'ملامینه';
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

    public function dontSuggestedCustomer()
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

    public function images()
    {
        return $this->hasMany(PictureLandowner::class , 'landowner_id');
    }
    public function filePrice()
    {
        return $this->hasOne(VipFilePrice::class , 'landowner_id');
    }
}
