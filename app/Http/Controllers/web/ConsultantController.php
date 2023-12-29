<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    public function index()
    {
        $this->authorize('viewConsultantIndex' , Business::class);

        $user = auth()->user();
        $business = $user->joinedBusinesses()->first();
        $business->loadCount(['customers' , 'landowners']);
        return view('consultant.index', compact('business', 'user'));
    }

    public function findBusiness()
    {
        return view('Consultant.find_business');
    }

    public function search(Request $request)
    {
        $request->validate([
            'owner_number' => 'required|max:11|digits:11'
        ]);

        $this->authorize('createOrJoin', Business::class);

        $ownerNumber = $request->input('owner_number');
        $business = Business::whereHas('owner', function ($query) use ($ownerNumber) {
            $query->where('number', $ownerNumber);
        })->first();

        if (!$business) {
            return redirect()->back()->with('error' , 'املاکی برای شماره موردنظر یافت نشد.');
        }

        return view('consultant.search', compact('business'));
    }

    public function join(Request $request)
    {
        $this->authorize('createOrJoin', Business::class);

        $user = auth()->user();
        $business = Business::where('id', $request->business_id)->first();
        $business->members()->attach($user);

        return redirect()->route('dashboard')
            ->with('success', 'You have successfully joined the business.');
    }

    public function leaveMember(User $user)
    {
        $this->authorize('leaveMember' , Business::class);

        $business = $user->joinedBusinesses()->first();
        $business->members()->detach($user->id);
        return redirect()->route('dashboard')->with('success', 'شما با موفقیت از بیزینس انصراف دادید');
    }

}
