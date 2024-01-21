<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('viewIndex' , Role::class);
        $roles = Role::whereNot('name' , 'user')->whereNot('name' , 'admin')->latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorize('create' , Role::class);
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->authorize('create' , Role::class);

        $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name,
            ]);

            $role->permissions()->attach($request->permissions);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('message' , 'نقش مور نظر ثبت نشد.');
        }
        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        $this->authorize('viewShow' , Role::class);
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $this->authorize('edit' , Role::class);

        if($role->name == 'user' || $role->name == 'admin')
            return back()->with('message' , 'شما نمی توانید این کار را انجام دهید.');

        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $this->authorize('edit' , Role::class);

        if($role->name == 'user' || $role->name == 'admin')
            return back()->with('message' , 'شما نمی توانید این کار را انجام دهید.');

        $request->validate([
            'name' => 'required',
            'permissions' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $role->update([
                'name' => $request->name,
            ]);

            $role->permissions()->sync($request->permissions);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();

            return redirect()->back();
        }
        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete' , Role::class);

        if($role->name == 'user' || $role->name == 'admin')
            return back()->with('message' , 'شما نمی توانید این کار را انجام دهید.');

        $role->delete();
        return back();
    }
}
