<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\SpecialFile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        $this->authorize('viewIndex' , Business::class);

        $businesses = Business::latest()->paginate(10);
        return view('admin.business.index' , compact('businesses'));
    }
    public function adminPanel()
    {
        $this->authorize('viewAdmin' , Business::class);
        return view('admin.admin_panel');
    }

    public function show(Business $business)
    {
        $this->authorize('viewShow' , Business::class);

        return view('admin.business.show' , compact('business'));
    }

    public function changeStatus(Business $business)
    {
        $this->authorize('changeStatus' , Business::class);

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
