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
            'number' => 'required|numeric|digits:11|unique:users,number',
            'city_id' => 'required',
            'email' => 'nullable|max:255|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required'
        ]);

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'number' => $request->number,
                'city_id' => $request->city_id,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole($request->role);
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error' , 'در دیتابیس خطایی رخ داد.');
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
            'number' => 'required|numeric|digits:11|unique:users,number',
            'city_id' => 'required',
            'email' => 'nullable|max:255|email',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => 'required'
        ]);

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'number' => $request->number,
                'city_id' => $request->city_id,
                'password' => $request->has('password') ? Hash::make($request->password) : $user->password,
            ]);

            $user->syncRoles($request->role);
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error' , 'در دیتابیس خطایی رخ داد.');
        }

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
}
