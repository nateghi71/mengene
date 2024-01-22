<?php

namespace App\Http\Controllers\web;

use App\HelperClasses\LinkGenerator;
use App\HelperClasses\SmsAPI;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Landowner;
use App\Models\SpecialFile;
use App\Notifications\ReminderForSpecialFileNotification;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecialFileController extends Controller
{

    public function indexBuy()
    {
        $this->authorize('viewIndexBuy' , SpecialFile::class);
        $user = auth()->user();
        $city_id = $user->business()->city_id;
        $area = $user->business()->area;
        $files = SpecialFile::where('type_file' , 'buy')->where('expire_date' , '>' , Carbon::now())->filter()->paginate(10)->withQueryString();

        foreach ($files as $file) {
            if ($file->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($file->getRawOriginal('expire_date')) + 1;
                $file->daysLeft = $daysLeft;
            }
        }

        return view('special_file.indexBuy', compact('files'));
    }

    public function indexSubscription()
    {
        $this->authorize('viewIndexSub' , SpecialFile::class);
        $user = auth()->user();
        $city_id = $user->business()->city_id;
        $area = $user->business()->area;
        $files = SpecialFile::where('type_file' , 'subscription')->where('expire_date' , '>' , Carbon::now())
            ->filter()->paginate(10)->withQueryString();

        foreach ($files as $file) {
            if ($file->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($file->getRawOriginal('expire_date')) + 1;
                $file->daysLeft = $daysLeft;
            }
        }

        return view('special_file.indexSubscription', compact('files'));
    }

    public function show(SpecialFile $specialFile)
    {
        $this->authorize('viewShowSub' , SpecialFile::class);
        return view('special_file.show', compact('specialFile'));
    }

    public function buyFile(SpecialFile $specialFile)
    {
        $this->authorize('buyFile' , SpecialFile::class);

        try{
            DB::beginTransaction();
            $user = auth()->user();
            $landowner = Landowner::create([
                'name' => $specialFile->name,
                'number' => $specialFile->number,
                'area' => $specialFile->area,
                'city_id' => $specialFile->city_id,
                'type_sale' => $specialFile->getRawOriginal('type_sale'),
                'type_work' => $specialFile->getRawOriginal('type_work'),
                'type_build' => $specialFile->getRawOriginal('type_build'),
                'scale' => $specialFile->getRawOriginal('scale'),
                'number_of_rooms' => $specialFile->number_of_rooms,
                'description' => $specialFile->description,
                'access_level' => 'private',
                'rahn_amount' => $specialFile->getRawOriginal('rahn_amount'),
                'rent_amount' => $specialFile->getRawOriginal('rent_amount'),
                'selling_price' => $specialFile->getRawOriginal('selling_price'),
                'elevator' => $specialFile->getRawOriginal('elevator'),
                'parking' => $specialFile->getRawOriginal('parking'),
                'store' => $specialFile->getRawOriginal('store'),
                'floor' => $specialFile->floor,
                'floor_number' => $specialFile->floor_number,
                'business_id' => $user->business()->id,
                'user_id' => $user->id,
                'is_star' => $specialFile->getRawOriginal('is_star') ,
                'expire_date' => $specialFile->expire_date
            ]);

            $specialFile->delete();
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            dd($e->getMessage());
            return back()->with('message' , 'عملیات ناموفق بود.');
        }
        return back()->with('message' , 'فایل موردنظر با موفقیت خریداری شد و به جدول مالکان اضافه شد');
    }

    public function suggestion(SpecialFile $specialFile)
    {
        $this->authorize('viewSuggestion' , SpecialFile::class);

        $business = auth()->user()->business();
        $specialFileId = $specialFile->id;
        if ($specialFile->getRawOriginal('type_sale') == 'buy')
        {
            $minPrice = $specialFile->getRawOriginal('selling_price') * 0.8; // 80% of the customer's price
            $maxPrice = $specialFile->getRawOriginal('selling_price') * 1.2; // 120% of the customer's price

            $suggestions = Customer::where('status', 'active')->where('business_id', $business->id)->where('type_sale', 'buy')
                ->whereDoesntHave('dontSuggestionForFile', function ($query) use ($specialFileId) {
                    $query->where('file_id', $specialFileId)->where('suggest_business' , 1);
                })->whereBetween('selling_price', [$minPrice, $maxPrice])->orderBy('selling_price' , 'asc')->limit(10)->get();
        }
        else
        {
            //20% diff
            $minRahn = $specialFile->getRawOriginal('rahn_amount') * 0.8;
            $maxRahn = $specialFile->getRawOriginal('rahn_amount') * 1.2;
            $minRent = $specialFile->getRawOriginal('rent_amount') * 0.8;
            $maxRent = $specialFile->getRawOriginal('rent_amount') * 1.2;

            $suggestions = Customer::where('status', 'active')->where('business_id', $business->id)->where('type_sale', 'rahn')
                ->whereDoesntHave('dontSuggestionForFile', function ($query) use ($specialFileId) {
                    $query->where('file_id', $specialFileId)->where('suggest_business' , 1);
                })->whereBetween('rahn_amount', [$minRahn, $maxRahn])
                ->whereBetween('rent_amount', [$minRent, $maxRent])->orderBy('rahn_amount' , 'asc')
                ->orderBy('rent_amount' , 'asc')->limit(10)->get();
        }

        foreach ($suggestions as $suggestion) {
            if ($suggestion->getRawOriginal('expire_date') > Carbon::now()) {
                $daysLeft = Carbon::now()->diffInDays($suggestion->getRawOriginal('expire_date')) + 1;
                $suggestion->daysLeft = $daysLeft;
            }
        }

        return view('special_file.suggestion' , compact('suggestions' ,'specialFile'));
    }

    public function send_block_message(Request $request)
    {
        $request->validate([
            'file_id' => 'required',
            'customer_id' => 'required'
        ]);

        $file = SpecialFile::findOrFail($request->file_id);
        $link = new LinkGenerator();
        $link = $link->generateLinkForSpecialFile($file , 'remove_from_suggestion' , 30 , $request->customer_id);
        $link = route('confirmation.confirmPage' ,
            ['type' => $link->type , 'token' => $link->token]);

        $smsApi = new SmsAPI();
//        $smsApi->sendSmsLink($file->number ,$file->name , $link);

        return redirect()->back()->with('message' , 'پیامی برای تایید مشتری ارسال شد.');
    }

    public function share_file_with_customer(Request $request)
    {
        $user = auth()->user();
        if($user->isVipUser() || ($user->isMidLevelUser() && $user->getPremiumCountSms() <= 1000))
        {
            $user->incrementPremiumCountSms();
            $file = SpecialFile::findOrFile($request->file_id);
            $customer = Customer::findOrFile($request->customer_id);

            if($customer->getRawOriginal('type_sale') == 'rahn')
                $price = $customer->rahn_amount.'/'.$customer->rent_amount;
            else
                $price = $customer->selling_price;
            $smsApi = new SmsAPI();
            $smsApi->sendSmsShareFile($file->number ,$file->name , $customer->scale , $price  , $file->business->number);
            return redirect()->back()->with('message' , 'پیام پیشنهاد شما برای مشتری ارسال شد.');
        }
        else
        {
            return redirect()->back()->with('message' , 'شما قابلیت ارسال پیام ندارید.');
        }
    }

    public function star(SpecialFile $specialFile)
    {
        $this->authorize('star' , SpecialFile::class);

        if ($specialFile->getRawOriginal('is_star') == 0) {
            $specialFile->is_star = 1;
            $specialFile->save();
        } else {
            $specialFile->is_star = 0;
            $specialFile->save();
        }
        return redirect()->back()->with('message' , 'جایگاه فایل موردنظر تغییر کرد.');
    }

    public function setRemainderTime(Request $request){
        $this->authorize('setReminder' , SpecialFile::class);

        $file = SpecialFile::find($request->file_id);
        $date = Verta::parse($request->remainder)->datetime()->format('Y-m-d H:i:s');
        $time = new Carbon($date);
        auth()->user()->notify((new ReminderForSpecialFileNotification($file , $date))->delay($time));

        return back()->with('message' , 'یک هشدار برای شما اعمال شد.');
    }
}
