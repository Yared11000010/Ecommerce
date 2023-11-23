<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Models\Advertisement;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdvertisementController extends Controller
{
    //
    public function index(){


        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_advertisment')) {
            return view('admin.errors.unauthorized');
        }

        $adver=Advertisement::all()->all();
        $appsettings=AppSetting::all()->toArray();

        return view('admin.advertisement.alladvertisement',compact('adver','appsettings'));
    }
    public function create(){

        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('create_advertisment')) {
            return view('admin.errors.unauthorized');
        }

        $appsettings=AppSetting::all()->toArray();

        return view('admin.advertisement.add_advertisement',compact('appsettings'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image'=>'required|image',
            'price' => 'required|integer|min:0',
            'adver_links' => 'required|string',
        ]);

        $adver=new Advertisement();
        $adver->title=$request->input('title');
        $adver->description=$request->input('description');
        $adver->price=$request->input('price');
        $adver->adv_links=$request->input('adver_links');
        $adver->is_approved=0;
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
            $path=$request->file('image')->storeAs('public/adver',$fileNameToStore);
            $adver->image=$fileNameToStore;
           }

        $adver->save();
        $appsettings=AppSetting::all()->toArray();

        // notify()->success('Adverstisements is Added !');

        Alert::toast('advertisement has been added successfully!','success');
        return redirect('admin/adverstisements');


    }

    public function edit($id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_advertisment')) {
            return view('admin.errors.unauthorized');
        }

       $adver =Advertisement::find($id);
       $appsettings=AppSetting::all()->toArray();

       return view('admin.advertisement.edit_advertisement',compact('adver','appsettings'));
    }

    public function update(Request $request){

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'adver_links' => 'required|string',
        ]);

        $adver=Advertisement::find($request->input('adver_id'));
        $adver->title=$request->input('title');
        $adver->description=$request->input('description');
        $adver->price=$request->input('price');
        $adver->adv_links=$request->input('adver_links');


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
            $path=$request->file('image')->storeAs('public/adver',$fileNameToStore);
            if ($adver->image) {
                Storage::delete('public/adver/'.$adver->image);
              }
              $path=$request->file('image')->storeAs('public/adver/',$fileNameToStore);

              $adver->image=$fileNameToStore;
           }


        $adver->update();
        $appsettings=AppSetting::all()->toArray();

        // Alert::toast('','success');
        notify()->success('advertisement has been updated successfully!');
        return redirect('admin/adverstisements');

    }

    public function active($id){

        $adver=Advertisement::find($id);
        $adver->is_approved=1;
        $adver->update();

        notify()->success('advertisement has been updated successfully!','Actived');

        return redirect('admin/adverstisements');
    }


    public function inactive($id){
        $adver=Advertisement::find($id);
        $adver->is_approved=0;
        $adver->update();

        notify()->error('advertisement has been updated successfully!','Inactive');

        return redirect('admin/adverstisements');
    }

    public function delete($id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('delete_advertisment')) {
            return view('admin.errors.unauthorized');
        }

        $adver=Advertisement::find($id);
        if($adver->image){
            Storage::delete('public/category/'.$adver->image);
        }
        $adver->delete();

        notify()->error('advertisement has been deleted successfully!','Deleted');
        return redirect()->back();
    }



}
