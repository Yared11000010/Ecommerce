<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AppSetting;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_admin')) {
            return view('admin.errors.unauthorized');
        }

        $appsettings=AppSetting::all()->toArray();

        $users = Admin::paginate(4);
        return view('admin.role_and_permissions.admins.index', compact('users','appsettings'));
    }

    public function assignRole(Admin $user)
    {
        $users = Auth::guard('admin')->user();
        if (!$users || !$users->hasPermissionByRole('assign_role')) {
            return view('admin.errors.unauthorized');
        }

        $roles = Roles::all();
        $appsettings=AppSetting::all()->toArray();

        return view('admin.role_and_permissions.admins.assing_role', compact('user','roles','appsettings'));
    }

    public function updateRole(Request $request, Admin $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $role=Roles::find($request->role_id);


        $admin=Admin::find($request->input('user_id'));
        $admin->type=$role->name;
        $admin->save();

        $user->roles()->sync([$request->role_id]);

        notify()->success('Role assigned to user successfully.');
        return redirect()->route('all-admins.index');
    }
}
