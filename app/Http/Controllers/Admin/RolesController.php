<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appsettings=AppSetting::all()->toArray();

        $roles = Roles::paginate(5);
        return view('admin.role_and_permissions.roles.index', compact('roles','appsettings'));
    }

    public function create()
    {
        $appsettings=AppSetting::all()->toArray();

        return view('admin.role_and_permissions.roles.create',compact('appsettings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
        ]);

        Roles::create([
            'name' => $request->name,
        ]);

        notify()->success('Role created successfully!','Saved');
        return redirect()->route('roles.index');
    }

    public function edit(Roles $role)
    {
        $appsettings=AppSetting::all()->toArray();

        return view('admin.role_and_permissions.roles.edit', compact('role','appsettings'));
    }

    public function update(Request $request, Roles $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        notify()->success('Role updated successfully.','Updated!');

        return redirect()->route('roles.index');
    }

    public function destroy(Roles $role)
    {
        $role->delete();
        notify()->error('Role deleted successfully','Deleted!');
        return redirect()->route('roles.index');
    }
}
