<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminsRole;
use App\Models\AppSetting;
use App\Models\Coupon;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    // display all Coupons
    public function coupons(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_coupon')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();

        Session::put('page','coupons');
        $adminType=Auth::guard('admin')->user()->type;
        $vendor_id=Auth::guard('admin')->user()->vendor_id;
        if($adminType=="vendor"){
          $vendorStatus=Auth::guard('admin')->user()->status;
          if($vendorStatus==0){
            notify()->error('Your Vendor Account is not approved yet. Please make sure to fill your valid personal, business and bank details','Inactive Vendor Account!');
            return redirect('admin/updatevendordetails');
          }
          $coupons=Coupon::where('vendor_id',$vendor_id)->get()->toArray();

        }else{
          $coupons=Coupon::get()->toArray();
        }
        $couponModuleCount=AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'coupons'])->count();

        $couponModule=AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'coupons'])->first()->toArray();


        // dd($coupons);
        return view('admin.coupons.allcoupons',compact('appsettings','coupons','couponModule'));
    }
    //delete coupons

    public function destory($coupon_id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('delete_coupon')) {
            return view('admin.errors.unauthorized');
        }
        $coupon_id=Coupon::find($coupon_id);
        $coupon_id->delete();

        notify()->error('Coupon is Deleted !','Deleted!');
        return redirect()->back();
    }
    //active a coupons
    public function active($coupon_id){

        $coupon=Coupon::find($coupon_id);
        $coupon->status=1;
        $coupon->update();
        notify()->success('Coupon Status is !','Active');

        return redirect('admin/coupons');
    }
    //incative a coupons
    public function inactive($coupon_id){

        $coupon=Coupon::find($coupon_id);
        $coupon->status=0;
        $coupon->update();
        notify()->error('Coupon Status is !','InActive');
        return redirect('admin/coupons');
    }

    //add edit coupons
    public function addEditCoupon(Request $request,$id=null){

        if($id==""){
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_coupon')) {
                return view('admin.errors.unauthorized');
            }
            $title="Add Coupon";
            $coupon =new Coupon();
            $selCats=array();
            $selBrands=array();
            $selUsers=array();
            $message="Coupon added successfully!";


        }else{
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_coupon')) {
                return view('admin.errors.unauthorized');
            }
            $title="Edit Coupon";
            $coupon=Coupon::find($id);
            $selCats = explode(',',$coupon['categories']);
            $selBrands=explode(',',$coupon['brands']);
            $selUsers=explode(',',$coupon['users']);
            $message="Coupon updated successfully!";

        }

        if($request->isMethod('post')){
            $data=$request->all();
            $rules=[
                'categories'=>'required',
                'brands'=>'required',
                'coupon_option'=>'required',
                'coupon_type'=>'required',
                'amount'=>'required|numeric',
                'expiry_date'=>'required',
            ];

            $this->validate($request,$rules);
            if(isset($data['categories'])){
                $categories=implode(",",$data['categories']);
            }else{
                $categories="";
            }
            if(isset($data['brands'])){
                $brands=implode(",",$data['brands']);
            }else{
                $brands="";
            }
            if(isset($data['users'])){
                $users=implode(",",$data['users']);
            }else{
                $users="";
            }

            if ($data['coupon_option'] =="Automatic"){
              $coupon_code=str_random(8);
              }
            else
              {
             $coupon_code = $data['coupon_code'];
             }

            $adminType=Auth::guard('admin')->user()->type;
            if($adminType=="vendor"){
                $coupon->vendor_id=Auth::guard('admin')->user()->vendor_id;
            }else{
                $coupon->vendor_id=0;
            }
            // dd($request->all());

            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code=$coupon_code;
            $coupon->categories= $categories;
            $coupon->brands= $brands;
            $coupon->users = $users;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->amount_type= $data ['amount_type'];
            $coupon->amount =$data ['amount'];
            $coupon->expiry_date= $data['expiry_date'];
            $coupon->status=1;
            $coupon->save();

            return redirect('admin/coupons')->with('success_message',$message);
        }

        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('create_coupon')) {
            return view('admin.errors.unauthorized');
        }

        $appsettings=AppSetting::all()->toArray();

        $categories=Group::with('categories')->get()->toArray();
        $brands=Brand::where('status',1)->get()->toArray();
        $users=User::select('email')->where('status',1)->get();

        return view('admin.coupons.addcoupon',compact('appsettings','selUsers','selBrands','selCats','title','coupon','categories','brands','users'));

    }

}
