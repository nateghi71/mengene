<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        $businesses = Business::latest()->paginate(10);
        return view('admin.business.index' , compact('businesses'));
    }

    public function show(Business $business)
    {
        return view('admin.business.show' , compact('business'));
    }

    public function changeStatus(Business $business)
    {
        if ($business->status == 'active') {
            $business->status = 'deactive';
            $business->save();
        } else {
            $business->status = 'active';
            $business->save();
        }
        return back();
    }
}
