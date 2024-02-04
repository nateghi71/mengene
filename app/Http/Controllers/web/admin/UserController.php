<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewIndex' , User::class);
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create' , User::class);

        $roles = Role::all();
        $provinces = Province::all();
        return view('admin.users.create' , compact('provinces' , 'roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('create' , User::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|iran_mobile|digits:11|unique:users,number',
            'city_id' => 'required',
            'email' => 'nullable|max:255|email',
            'password' => 'required|confirmed',
            'role' => 'required'
        ]);

        try {
            DB::beginTransaction();
            $myRole = Role::where('name' , $request->role)->first();

            $user = $myRole->users()->create([
                'name' => $request->name,
                'email' => $request->email,
                'number' => $request->number,
                'city_id' => $request->city_id,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('message' , 'در دیتابیس خطایی رخ داد.');
        }

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        $this->authorize('viewShow' , User::class);

        return view('admin.users.show' , compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('edit' , User::class);

        $roles = Role::all();
        $provinces = Province::all();
        return view('admin.users.edit' , compact('user' , 'provinces' , 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('edit' , User::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|iran_mobile|digits:11',
            'city_id' => 'required',
            'email' => 'nullable|max:255|email',
            'password' => 'nullable|confirmed',
            'role' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'city_id' => $request->city_id,
            'password' => $request->password !== null ? Hash::make($request->password) : $user->password,
            'role_id' => $request->role
        ]);

        return redirect()->route('admin.users.index');
    }

    public function changeStatus(User $user)
    {
        $this->authorize('changeStatus' , User::class);
        if($user->status == 'active')
        {
            $user->status = 'deActive';
            $user->save();
        }
        else if($user->status == 'deActive')
        {
            $user->status = 'active';
            $user->save();
        }
        return redirect()->back()->with('message' , 'وضعیت کاربر موردنظر تغییر کرد.');;
    }

    public function loginToAdmin()
    {
        return view('auth.loginToAdmin');
    }
    public function handleLoginToAdmin(Request $request)
    {
        $credentials = $request->validate([
            'number' => 'required|numeric',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials,$request->has('remember_me'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.adminPanel');
        }

        return back()->with(
            'message', 'The provided credentials do not match our records.',
        )->withInput();
    }
}
