<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
            $role->givePermissionTo($request->permissions);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex->getMessage());
            return redirect()->back();
        }
        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        if($role->name == 'user' || $role->name == 'admin')
            return back();

        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        if($role->name == 'user' || $role->name == 'admin')
            return back();

        $request->validate([
            'name' => 'required',
            'permissions' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $role->update([
                'name' => $request->name,
            ]);
            $role->syncPermissions($request->permissions);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back();
        }
        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        if($role->name == 'user' || $role->name == 'admin')
            return back();

        $role->delete();
        return back();
    }
}
