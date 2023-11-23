<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function users(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_users')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        $users=User::get()->toArray();
        // dd($users);
        return view('admin.users.allusers',compact('appsettings','users'));
    }
    public function adduser(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('create_user')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        return view('admin.users.adduser',compact('appsettings'));
    }

    public function store_user(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state'=>'required',
            'pincode'=>'required',
            'country'=>'required',
            'email'=>'email',
            'mobile'=> 'required',
        ]);
        // dd($request->all());
         $user=User::where('email',$request->input('email'))->count();
          if($user>0){
              notify()->error('User already exists','Exsit');
              return redirect()->back();
          }
          $phone=User::where('mobile',$request->input('mobile'))->count();
          if($phone>0){
            notify()->error('User phone number already exists','Exsit');
            return redirect()->back();
          }



        $user = new User();
        $user->name=$request->input('name');
        $user->address=$request->input('address');
        $user->city=$request->input('city');
        $user->state=$request->input('state');
        $user->email=$request->input('email');
        $user->mobile=$request->input('mobile');
        $user->country=$request->input('country');
        $user->pincode=$request->input('pincode');
        $user->save();

        notify()->success('Users Added','Success');
        return redirect('admin/users');
    }

    public function edit_user($id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_user')) {
            return view('admin.errors.unauthorized');
        }

        $appsettings=AppSetting::all()->toArray();
        $users=User::find($id);
        return view('admin.users.edituser',compact('users','appsettings'));
    }
    public function update_user(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state'=>'required',
            'pincode'=>'required',
            'country'=>'required',
            'email'=>'email',
            'mobile'=> 'required',
        ]);

        $user = User::find($request->input('id'));
        $user->name=$request->input('name');
        $user->address=$request->input('address');
        $user->city=$request->input('city');
        $user->state=$request->input('state');
        $user->email=$request->input('email');
        $user->mobile=$request->input('mobile');
        $user->country=$request->input('country');
        $user->pincode=$request->input('pincode');
        $user->update();

        notify()->success('Users Updated','Updated');
        return redirect('admin/users');
    }

    public function destory($user_id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('delete_user')) {
            return view('admin.errors.unauthorized');
        }
        $user=User::find($user_id);
        $user->delete();
        notify()->error('User is Deleted !','Deleted!');
        return redirect()->back();
    }

    public function active($user_id){

        $user=User::find($user_id);
        $user->status=1;
        $user->update();
        notify()->success('User Status is !','Active');

        return redirect('admin/users');
    }
    //incative a users
    public function inactive($user_id){

        $user=User::find($user_id);
        $user->status=0;
        $user->update();
        notify()->warning('User Status is !','InActive');
        return redirect('admin/users');
    }

}
