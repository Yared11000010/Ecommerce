<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

class BannerController extends Controller
{
    //
    public function banners(Request $request){

    $banners=Banner::get()->toArray();
    if($request->isMethod('post')){
        $this->validate($request,[
            'link'=>'required|string',
            'title'=>'required|string',
            'alt'=>'required|string'
        ]);

        // $data=$request->all();
        // return dd($data);
        $banner =new Banner();

        if($request->hasFile('image')){
            //get file name with ext
            $fileNameWithExt=$request->file('image')->getClientOriginalName();
            //get just file name
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just file extenstion
            $extension=$request->file('image')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;
            //upload image
            $path=$request->file('image')->storeAs('public/banner',$fileNameToStore);

            $banner->image=$fileNameToStore;
           }

        $banner->link=$request->input('link');
        $banner->type=$request->input('type');
        $banner->title=$request->input('title');
        $banner->alt=$request->input('alt');
        $banner->status=1;


        $banner->save();

        notify()->success('Banner is Added !');
        return redirect('admin/banners');

        }
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_banners')) {
            return view('admin.errors.unauthorized');
        }

     $appsettings=AppSetting::all()->toArray();

     return view('banner.allbanner',compact('banners','appsettings'));

    }

    public function create(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('create_banners')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();

        return view('banner.addbanner',compact('appsettings'));
    }

    // public function store(Request $request){




    // }

    public function edit($id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_banners')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();

        $banner=Banner::find($id);

        return view('banner.editbanner',compact('banner','appsettings'));
    }

    public function update( Request $request){

        $this->validate($request,[
            'link'=>'required|string',
            'title'=>'required|string',
            'alt'=>'required|string'
        ]);

        $banner=Banner::find($request->input('id'));
        $banner->link=$request->input('link');
        $banner->type=$request->input('type');
        $banner->title=$request->input('title');
        $banner->alt=$request->input('alt');

        if($request->hasFile('image')){
            //get file name with ext
            $fileNameWithExt=$request->file('image')->getClientOriginalName();
            //get just file name
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just file extenstion
            $extension=$request->file('image')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;

            //upload image
            $path=$request->file('image')->storeAs('public/banner',$fileNameToStore);
            if ($banner->image) {
                Storage::delete('public/banner/'.$banner->image);
              }
              $path=$request->file('image')->storeAs('public/banner/',$fileNameToStore);

              $banner->image=$fileNameToStore;
           }




        $banner->update();

        notify()->warning('Banner is Updated !');
        return redirect('admin/banners');

    }

    // for active and inactive admin type

    public function active_banner($banner_id){

        $banner=Banner::find($banner_id);
        $banner->status=1;
        $banner->update();

        notify()->success('Banner Status is !','Active');
        return redirect('admin/banners');
    }


    public function inactive_banner($banner_id){

        $banner=Banner::find($banner_id);
        $banner->status=0;
        $banner->update();

        notify()->warning('Banner Status is !','InActive');
       return redirect('admin/banners');
    }

    public function delete($banner_id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('delete_banners')) {
            return view('admin.errors.unauthorized');
        }
        $banner=Banner::find($banner_id);
        $banner->delete();

        notify()->warning('Banner is Deleted','Deleted');
        return redirect('admin/banners');
    }
}
