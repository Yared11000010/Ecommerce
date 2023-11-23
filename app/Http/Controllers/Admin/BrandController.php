<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Psy\CodeCleaner\ReturnTypePass;

class BrandController extends Controller
{
    //
    public function index(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_brand')) {
            return view('admin.errors.unauthorized');
        }

        $appsettings=AppSetting::all()->toArray();

        $brands=Brand::all();

        return view('brand.index',compact('brands','appsettings'));
    }


    public function create(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('create_brand')) {
            return view('admin.errors.unauthorized');
        }
         $appsettings=AppSetting::all()->toArray();

        return view('brand.addbrand',compact('appsettings'));
    }

    public function store(Request $request){

    $this->validate($request,[
      'name'=>'required|string',
    //   'image'=>'required|image',
      'status'=>'nullable'
    ]);
    $brand=new Brand();
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
        $path=$request->file('image')->storeAs('public/brand',$fileNameToStore);
        $brand->image=$fileNameToStore;
       }


    $brand->name=$request->input('name');

    $brand->status=$request->status==true?'1':'0';
    $brand->save();

    notify()->success('Brand is Added');

    return redirect('admin/brands');


    }
    public function edit($brand_id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_brand')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();

        $brand=Brand::find($brand_id);


        return view('brand.editbrand',compact('brand','appsettings'));
    }

    public function update(Request $request){

        $this->validate($request,[
            'name'=>'required|string',
            'status'=>'nullable'
          ]);


          $brand=Brand::find($request->input('id'));
          $brand->name=$request->input('name');
          $brand->status=$request->status==true?'1':'0';

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
            $path=$request->file('image')->storeAs('public/brand/',$fileNameToStore);
            if ($brand->image) {
                Storage::delete('public/brand/'.$brand->image);
              }
              $brand->image=$fileNameToStore;

           }

          $brand->update();


          notify()->success('Brand is Updated');

          return redirect('admin/brands');
    }
    public function destory($brand_id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('delete_brand')) {
            return view('admin.errors.unauthorized');
        }
        $brand=Brand::find($brand_id);
        if($brand->image){
            Storage::delete('public/brand/'.$brand->image);
        }
        $brand->delete();

        notify()->error('Brand is Deleted !','Deleted');
        return redirect('admin/brands');
    }

    public function active($brand_id){

        $brand=Brand::find($brand_id);
        $brand->status=1;
        $brand->update();
        notify()->success('Sub Brand Status is !','Active');

        return redirect('admin/brands');
    }
    public function inactive($brand_id){

        $brand=Brand::find($brand_id);
        $brand->status=0;
        $brand->update();
        notify()->error('Sub Brand Status is !','InActive');
        return redirect('admin/brands');
    }
}
