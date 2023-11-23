<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Permissions;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public function index()
    {
        $appsettings=AppSetting::all()->toArray();

        $permissions = Permissions::paginate(15);
        return view('admin.role_and_permissions.permissions.index', compact('permissions','appsettings'));
    }

    public function create()
    {
        $appsettings=AppSetting::all()->toArray();

        return view('admin.role_and_permissions.permissions.create',compact('appsettings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions',
        ]);

        Permissions::create([
            'name' => $request->name,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permissions $permission)
    {
        $appsettings=AppSetting::all()->toArray();

        return view('admin.role_and_permissions.permissions.edit', compact('permission','appsettings'));
    }

    public function update(Request $request, Permissions $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permissions $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
