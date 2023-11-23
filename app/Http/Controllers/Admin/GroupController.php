<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupFormRequest;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Guid\Guid;

class GroupController extends Controller
{
    //
    public function index(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_group')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        $group =Group::all();
        return view('group.allgroup',compact('group','appsettings'));
    }

    public function create(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('create_group')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        return view('group.addgroup',compact('appsettings'));
    }

    public function store(GroupFormRequest $request){
        $validatedata=$request->validated();
        $group=new Group();
        $group->name=$validatedata['name'];
        $group->description=$validatedata['description'];
        $group->status=$request->status==true?'1':'0';

        $group->save();
        notify()->success('Group is Added !');

        return redirect('admin/groups');
    }

    public function update(GroupFormRequest $request,$group_id){
        $validatedata=$request->validated();
        $group=Group::findOrFail($group_id);
        $group->name=$validatedata['name'];
        $group->description=$validatedata['description'];
        $group->status=$request->status==true?'1':'0';

        $group->update();
        notify()->warning('Group is Updated !');

        return redirect('admin/groups');
    }


    public function edit($group_id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_group')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        $group=Group::find($group_id);
        return view('group.editgroup',compact('group','appsettings'));
    }
    public function destory($group_id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('delete_group')) {
            return view('admin.errors.unauthorized');
        }
        $group=Group::find($group_id);
        $group->delete();
        notify()->error('Group is Deleted !','Deleted');
        return redirect('admin/groups');
    }
    public function active($group_id){
        $group=Group::find($group_id);
        $group->status=1;
        $group->update();
        notify()->success('Group Status !!','Active');
        return redirect('admin/groups');
    }
    public function inactive($group_id){
        $group=Group::find($group_id);
        $group->status=0;
        $group->update();
        notify()->error('Group Status !!','Inactive');
        return redirect('admin/groups');
    }
}
