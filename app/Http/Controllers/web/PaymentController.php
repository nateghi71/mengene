<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Landowner;
use App\Models\Order;
use App\Models\OrderCreditItem;
use App\Models\OrderFileItem;
use App\Models\OrderPackageItem;
use App\Models\Package;
use App\Models\Premium;
use Carbon\Carbon;
use http\Exception\BadConversionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class PaymentController extends Controller
{
    public function payment_for_file(Request $request)
    {
        $this->authorize('isOwner' , Business::class);

        $request->validate([
            'payment_method' => 'required',
            'file_id' => 'required',
        ]);
        $landowner = Landowner::where('id' , $request->file_id)->where('type_file' , 'buy')->first();
        if ($landowner === null)
            return redirect()->route('landowner.subscription.index')->with('message' , 'فایل موردنظر موجود نیست.');

        if($request->payment_method == 'wallet')
        {
            $price = $landowner->filePrice->price;
            $tax = $price * 0.09;
            $payment_amount = $price + $tax;
            $wallet = auth()->user()->business()->wallet;
            $paymentAfterWalletUse  = ($payment_amount - $wallet) > 0 ? ($payment_amount - $wallet) : 0;

            if($paymentAfterWalletUse > 0)
            {
                $business = auth()->user()->business();
                $business->wallet = 0;
                $business->save();

                $invoice = new Invoice;
                $invoice->amount($paymentAfterWalletUse);
                $invoice->detail(['landowner' => $landowner]);
                $invoice->detail(['price' => $price]);
                $invoice->detail(['tax' => $tax]);
                $invoice->detail(['order_type' => 'buy_file']);

                return $this->payment($invoice);
            }
            else
            {
                $business = auth()->user()->business();
                $business->decrement('wallet' , $payment_amount);

                $this->buy_file($business,$landowner);
                return redirect()->route('landowner.index')->with('message' , 'تراکنش با موفقیت انجام شد.');
            }
        }
        else
        {
            $price = $landowner->filePrice->price;
            $tax = $price * 0.09;
            $payment_amount = $price + $tax;
            $invoice = new Invoice;
            $invoice->amount($payment_amount);
            $invoice->detail(['landowner' => $landowner]);
            $invoice->detail(['price' => $price]);
            $invoice->detail(['tax' => $tax]);
            $invoice->detail(['order_type' => 'buy_file']);

            return $this->payment($invoice);
        }
    }
    public function payment_for_package(Request $request)
    {
        $this->authorize('isOwner' , Business::class);

        $request->validate([
            'package_name' => 'required',
        ]);

        if (session()->has('coupon')) {
            $checkCoupon = checkCoupon(session()->get('coupon.code'));
            if (array_key_exists('error', $checkCoupon)) {
                return back()->with('message' , $checkCoupon['error']);
            }
        }

        $package = Package::where('name' , $request->package_name)->first();
        $price = $package->price;
        $walletCharge = 50000;
        $coupon_amount = session()->has('coupon') ? session('coupon.amount') : 0;
        $tax = (($price + $walletCharge) - $coupon_amount) * 0.09;
        $payment_amount = (($price + $walletCharge) - $coupon_amount) + $tax;
        $invoice = new Invoice;
        $invoice->amount($payment_amount);
        $invoice->detail(['package' => $package]);
        $invoice->detail(['price' => $price]);
        $invoice->detail(['tax' => $tax]);
        $invoice->detail(['charge_credit' => $walletCharge]);
        $invoice->detail(['order_type' => 'buy_package']);

        return $this->payment($invoice);
    }
    public function payment_for_credit(Request $request)
    {
        $this->authorize('isOwner' , Business::class);

        $request->validate([
            'amount' => 'required|numeric|between:1000,99999999',
        ]);
        $price = $request->amount;
        $tax = $price * 0.09;
        $payment_amount = $price + $tax;
        $invoice = new Invoice;
        $invoice->amount($payment_amount);
        $invoice->detail(['price' => $price]);
        $invoice->detail(['tax' => $tax]);
        $invoice->detail(['order_type' => 'buy_credit']);

        return $this->payment($invoice);
    }

    public function payment($invoice)
    {
        $pay = Payment::callbackUrl(route('payment.verify' , ['price' => $invoice->getAmount()]))
        ->purchase($invoice, function ($driver, $transactionId) use($invoice) {
            try
            {
                DB::beginTransaction();
                $user = auth()->user();
                $details = $invoice->getDetails();

                $order = Order::create([
                    'user_id' => $user->id ,
                    'coupon_id' => session()->has('coupon') ? session('coupon.id') : null,
                    'business_id' => $user->business()->id,
                    'amount' => $details['price'],
                    'tax_amount' => $details['tax'],
                    'coupon_amount' => session()->has('coupon') ? session('coupon.amount') : 0,
                    'paying_amount' => $invoice->getAmount(),
                    'payment_type' => 'online',
                    'payment_status' => 0,
                    'token' => $transactionId,
                    'gateway_name' => 'zarinpal',
                    'order_type' => $details['order_type']
                ]);

                if($details['order_type'] === 'buy_package')
                {
                    OrderPackageItem::create([
                        'price' => $details['price'],
                        'order_id'  => $order->id,
                        'package_id' => $details['package']->id,
                        'charge_credit' => $details['charge_credit']
                    ]);
                }
                elseif ($details['order_type'] === 'buy_file')
                {
                    OrderFileItem::create([
                        'price' => $details['price'],
                        'order_id'  => $order->id,
                        'landowner_id' => $details['landowner']->id
                    ]);
                }
                else
                {
                    OrderCreditItem::create([
                        'credit_amount' => $details['price'],
                        'order_id'  => $order->id,
                    ]);
                }
                DB::commit();
            }
            catch (Exception $e)
            {
                DB::rollBack();
                return back()->with('message' , 'مشکلی در دیتابیس پیش امد دوباره امتحان کنید.');
            }
        });

        return $pay->pay()->render();
    }
    public function paymentVerify(Request $request , $price)
    {
        try {
            $receipt = Payment::amount($price)->transactionId($request->Authority)->verify();

            $order = Order::where('token' , $request->Authority)->first();
            $order->update([
                'ref_id' => $receipt->getReferenceId(),
                'payment_status' => 1
            ]);

            if($order->order_type === 'buy_package')
            {
                $orderItem = OrderPackageItem::where('order_id' , $order->id)->first();
                $package = $orderItem->package;
                $business = $order->business;
                $credit = $orderItem->charge_credit;
                $this->buy_package($business , $package , $credit);
            }
            elseif ($order->order_type === 'buy_file')
            {
                $orderItem = OrderFileItem::where('order_id' , $order->id)->first();
                $landowner = $orderItem->landowner;
                $business = $order->business;
                $this->buy_file($business,$landowner);
                return redirect()->route('landowner.index')->with('message' , $receipt->getReferenceId().'تراکنش با موفقیت انجام شد. با شماره ارجاع ');
            }
            else
            {
                $orderItem = OrderCreditItem::where('order_id' , $order->id)->first();
                $amount = $orderItem->credit_amount;
                $business = $order->business;
                $this->buy_credit($business,$amount);
            }

            return redirect()->route('dashboard')->with('message' , 'تراکنش با موفقیت انجام شد. با شماره ارجاع ' . $receipt->getReferenceId());
        } catch (InvalidPaymentException $exception) {
            return redirect()->route('dashboard')->with('message' , $exception->getMessage());
        }
    }

    private function buy_package(Business $business , Package $package, $credit)
    {
        if($business->premium->package->name !== 'free')
        {
            $premium = Premium::where('business_id' , $business->id)->first();
            $expire_date = (new Carbon($premium->expire_date))->addMonth($package->time);
        }
        else
        {
            $premium = Premium::where('business_id' , $business->id)->first();
            $expire_date = Carbon::now()->addMonth($package->time);
        }

        $premium->update([
            'package_id' => $package->id,
            'expire_date' => $expire_date,
        ]);
        $business->increment('wallet' , $credit);
    }

    private function buy_file(Business $business , Landowner $landowner)
    {
        $landowner->update([
            'type_file' => 'business' ,
            'business_id' => $business->id,
            'user_id' => auth()->user()->id,
        ]);
    }
    private function buy_credit(Business $business , $amount)
    {
        $business->increment('wallet' , $amount);
    }
}
