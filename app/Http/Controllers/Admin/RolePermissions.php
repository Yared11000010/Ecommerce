<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Http\Request;

class RolePermissions extends Controller
{
    public function edit($id)
    {
        $appsettings=AppSetting::all()->toArray();

        $roles = Roles::find($id);
        $permissions = Permissions::all();
        // dd($roles);
        return view('admin.role_and_permissions.role_permissions.edit', compact('appsettings','roles', 'permissions'));
    }

    public function update(Request $request, Roles $role)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Permissions assigned to role successfully.');
    }
}
