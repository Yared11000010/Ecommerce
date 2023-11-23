<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AppSettingController extends Controller
{
    //
    public function create(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_appsetting')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();

        $appsetting=AppSetting::where('id',1)->first();
        return view('admin.app_setting.app_settings',compact('appsetting','appsettings'));
    }
    public function update(Request $request){
        $this->validate($request,[
            'title'=>'required|string',
            'description'=>'required',
            'address'=>'required',
            'email'=>'email',
            'phone_no'=>'required',
            'language'=>'required',
            'footer_text'=>'required',
            'plane_text'=>'required',
            'plane_footer_text'=>'required',
            // 'panel_icon'=>'required'
          ]);
        //   dd($request->all());

        $appsettings =AppSetting::find(1);
        $appsettings->application_title=$request->input('title');
        $appsettings->description=$request->input('description');
        $appsettings->address=$request->input('address');
        $appsettings->email_address=$request->input('email');
        $appsettings->phone_no=$request->input('phone_no');
        $appsettings->facebook=$request->input('facebook');
        $appsettings->twitter=$request->input('twitter');
        $appsettings->youtube=$request->input('youtube');
        $appsettings->panel_text=$request->input('plane_text');
        $appsettings->panel_footer_text=$request->input('plane_footer_text');

        $appsettings->whatsapp=$request->input('whatsapp');


        if($request->hasFile('favicon')){
            //get file name with ext
            $fileNameWithExt=$request->file('favicon')->getClientOriginalName();
            //get just file name
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just file extenstion
            $extension=$request->file('favicon')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;

            //upload image
            $path=$request->file('favicon')->storeAs('public/appsettings',$fileNameToStore);

            if($appsettings->favicon!='noimage.jpg'){
                Storage::delete('public/appsettings/'.$appsettings->favicon);
            }
            $appsettings->favicon=$fileNameToStore;
        }

        if($request->hasFile('panel_icon')){
            //get file name with ext
            $fileNameWithExt=$request->file('panel_icon')->getClientOriginalName();
            //get just file name
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just file extenstion
            $extension=$request->file('panel_icon')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;

            //upload image
            $path=$request->file('panel_icon')->storeAs('public/appsettings',$fileNameToStore);

            if($appsettings->panel_icon!='noimage.jpg'){
                Storage::delete('public/appsettings/'.$appsettings->panel_icon);
            }
            $appsettings->panel_icon=$fileNameToStore;
        }

        if($request->hasFile('logo')){
            //get file name with ext
            $fileNameWithExt=$request->file('logo')->getClientOriginalName();
            //get just file name
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just file extenstion
            $extension=$request->file('logo')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;

            //upload image
            $path=$request->file('logo')->storeAs('public/appsettings',$fileNameToStore);

            if($appsettings->logo!='noimage.jpg'){
                Storage::delete('public/appsettings/'.$appsettings->logo);
            }
            $appsettings->logo=$fileNameToStore;
        }



        $appsettings->language=$request->input('language');
        $appsettings->footer_text=$request->input('footer_text');
        $appsettings->update();

        notify()->success('App Settings is Updated !');

        return redirect()->back();
    }
}
