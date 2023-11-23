<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminsRole;
use App\Models\AppSetting;
use Illuminate\Support\Str;
use App\Models\CmsPage;
use App\Models\Country;
use App\Models\Roles;
use App\Models\Vendor;
use App\Models\VendorBankDetails;
use App\Models\VendorBussinessDetails;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    // for update admin password
    public function update_admin_password(Request $request){

        $request->validate([
            'oldpassword' => 'required',
            'new_password' => ['required'],
            'new_password_confirmation' => ['same:new_password'],
        ]);
        // return $request->all();
        if(!Hash::check($request->oldpassword, Auth::guard('admin')->user()->password)){

            notify()->warning('your old password is not correct!');
            return back();
        }
        // Current password and new password same
        if (!strcmp($request->get('new_password'), $request->get('new_password_confirmation')) == 0)
        {
            notify()->warning('new password and confirm password  not the same. !');
            return back();
        }
         #Update the new Password
         Admin::whereId(Auth::guard('admin')->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        notify()->success('Password Updated Succesfully !');
        return back();
    }
    public function updateadminpassword(){

        $appsettings=AppSetting::all()->toArray();


        $adminDetails=Admin::where('email',Auth::guard('admin')->user()->email)->first();

        return view('admin.auth.updateadminpassword',compact('adminDetails','appsettings'));
    }


    //for upate admin details
    public function updateadmindetails(){

        $appsettings=AppSetting::all()->toArray();

        $adminDetails=Admin::where('email',Auth::guard('admin')->user()->email)->first();


        return view('admin.auth.updateadmindetails',compact('adminDetails','appsettings'));
    }


    public function update_admin_details(Request $request){


        // dd($request->all());
        $this->validate($request,[
            'name' => ['required','alpha'],
            'mobile'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:10'
         ]);

        $admin = Admin::find(Auth::guard('admin')->user()->id);
        $admin->name=$request->input('name');
        $admin->mobile=$request->input('mobile');
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
            $path=$request->file('image')->storeAs('public/admin/image',$fileNameToStore);
            if($admin->product_image!='noimage.jpg'){
                Storage::delete('public/admin/image'.$admin->image);
            }
            $admin->image=$fileNameToStore;
        }
        $admin->email=$request->input('email');

        $admin->update();


     notify()->success('Upated Admin Details Successfully!');
     return redirect()->back();

    }



    //for display login page
    public function loginpage(){

        return view('admin.auth.login');
    }

    //for check if admin login or not
    public function loginvalidate(Request $request){

           $data=$request->all();
           $validateData=$request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8',
           ]);

        if(Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'],'status'=>1])){
           if(Auth::guard('admin')->user()->type=="vendor" & Auth::guard('admin')->user()->confirm=="No"){

               notify()->success('Please confirm your email to active your Vendor Account','Errors');
               return redirect()->back();
           }else if(Auth::guard('admin')->user()->type!="vendor" && Auth::guard('admin')->user()->status="0"){
               notify()->error('Your account is not acitve','Not Active');
               return redirect()->back();
           }else{

            notify()->success('Welcome to Dashboard','Welcome');
            return redirect('/admin/dashboard');
           }

        }
        else{
            notify()->error('Your Email or Password is incorrect ','Alert');
            return redirect()->back();
        }
        // return view('admin.auth.login');

    }
    public function logout(){

        Auth::guard('admin')->logout();
        return view('admin.auth.login');


    }

    //for update vendor details,vendor bank details and vendor business details


    public function updatevendordetails(){

        $appsettings=AppSetting::all()->toArray();


        $country=Country::where('status',1)->get();

        $vendorDetails=Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();

        return view('admin.vendor.updatevendordetails',compact('vendorDetails','country','appsettings'));
    }



    public function update_vendor_details(Request $request){

        $data=$request->all();


        if($request->hasFile('vendor_image')){

            //get file name with ext
            $fileNameWithExt=$request->file('vendor_image')->getClientOriginalName();
            //get just file name
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just file extenstion
            $extension=$request->file('vendor_image')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;

            //upload image
            $path=$request->file('vendor_image')->storeAs('public/admin/image',$fileNameToStore);

            if('image') {
                Storage::delete('public/admin/image/'.$data['vendor_image']);
              }

            Admin::where('id',Auth::guard('admin')->user()->id)->update([
                'image'=>$fileNameToStore
            ]);
        }

        Admin::where('id',Auth::guard('admin')->user()->id)->update([
        'name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile']
        ]);


        Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->update([
            'name'=>$data['vendor_name'],
            'mobile'=>$data['vendor_mobile'],
            'city'=>$data['vendor_city'],
            'state'=>$data['vendor_state'],
            'address'=>$data['vendor_address'],
            'mobile'=>$data['vendor_mobile'],
            'country'=>$data['vendor_country'],
            'pincode'=>$data['vendor_pincode']
            ]);

        notify()->success('Upated Vendor Details Successfully!');
        return redirect()->back();

    }



    public function updatevendorbusinessdetails(){

        $country=Country::where('status',1)->get();
        $appsettings=AppSetting::all()->toArray();


       $vendorCount=VendorBussinessDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();

       if($vendorCount >0){

        $vendorbusiness=VendorBussinessDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
       }else{
        $vendorbusiness=array();
       }
        return view('admin.vendor.updatevendorbusinessdetails',compact('appsettings','vendorbusiness','country'));
    }

    //for update Vendor Commissions
     public function updateVendorCommission(Request $request){
         if($request->isMethod('post')){
             $data=$request->all();
             Vendor::where('id',$data['vendor_id'])->update(['commission'=>$data['commission']]);

             notify()->success('Vendor Commission updated');
           return  redirect()->back();
         }
     }

    public function update_vendor_businessdetails(Request $request){

        $data=$request->all();
        // dd($data);
        $vendorCount=VendorBussinessDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();

        if($vendorCount >0){
            if($request->hasFile('address_proof_image'))
            {

                //get file name with ext
                $fileNameWithExt=$request->file('address_proof_image')->getClientOriginalName();
                //get just file name
                $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                //get just file extenstion
                $extension=$request->file('address_proof_image')->getClientOriginalExtension();
                //file name to store
                $fileNameToStore=$fileName.'_'.time().'.'.$extension;

                //upload image
                $path=$request->file('address_proof_image')->storeAs('public/admin/image',$fileNameToStore);

                if('address_proof_image'){
                    Storage::delete('public/admin/image/'.$data['address_proof_image']);
                }

            } else if(!empty($data['current_address_proof'])){
                $fileNameToStore=$data['current_address_proof'];
            } else{
                $fileNameToStore="";
            }

            VendorBussinessDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update([
                'address_proof_image'=>$fileNameToStore
            ]);

            //shoping image
            if($request->hasFile('shop_image'))
            {

                //get file name with ext
                $fileNameWithExt=$request->file('shop_image')->getClientOriginalName();
                //get just file name
                $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                //get just file extenstion
                $extension=$request->file('shop_image')->getClientOriginalExtension();
                //file name to store
                $fileNameToStore=$fileName.'_'.time().'.'.$extension;

                //upload image
                $path=$request->file('shop_image')->storeAs('public/admin/image',$fileNameToStore);

                if('shop_image'){
                    Storage::delete('public/admin/image/'.$data['shop_image']);
                }

            } else if(!empty($data['current_shop_image'])){
                $fileNameToStore=$data['current_shop_image'];
            } else{
                $fileNameToStore="";
            }

            VendorBussinessDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update([
                'shop_image'=>$fileNameToStore
            ]);

            VendorBussinessDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update([
                'shop_name'=>$data['shop_name'],
                'shop_mobile'=>$data['shop_mobile'],
                'shop_address'=>$data['shop_address'],
                'shop_city'=>$data['shop_city'],
                'shop_state'=>$data['shop_state'],
                'shop_website'=>$data['shop_website'],
                'shop_country'=>$data['shop_country'],
                'business_license_number'=>$data['business_license_number'],
                'shop_email'=>$data['shop_email'],
                'address_proof'=>$data['address_proof'],
                'shop_pincode'=>$data['shop_pincode'],
                ]);
        }
    else
        {

                    if($request->hasFile('address_proof_image'))
                    {

                    //get file name with ext
                    $fileNameWithExt=$request->file('address_proof_image')->getClientOriginalName();
                    //get just file name
                    $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                    //get just file extenstion
                    $extension=$request->file('address_proof_image')->getClientOriginalExtension();
                    //file name to store
                    $fileNameToStore=$fileName.'_'.time().'.'.$extension;

                    //upload image
                    $path=$request->file('address_proof_image')->storeAs('public/admin/image',$fileNameToStore);

                    if('address_proof_image'){
                        Storage::delete('public/admin/image/'.$data['address_proof_image']);
                    }

                    } else if(!empty($data['current_address_proof'])){
                        $fileNameToStore=$data['current_address_proof'];
                    } else{
                        $fileNameToStore="";
                    }

                            //shoping image
                    if($request->hasFile('shop_image'))
                    {

                        //get file name with ext
                        $fileNameWithExt=$request->file('shop_image')->getClientOriginalName();
                        //get just file name
                        $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                        //get just file extenstion
                        $extension=$request->file('shop_image')->getClientOriginalExtension();
                        //file name to store
                        $fileNameToStore=$fileName.'_'.time().'.'.$extension;

                        //upload image
                        $path=$request->file('shop_image')->storeAs('public/admin/image',$fileNameToStore);

                        if('shop_image'){
                            Storage::delete('public/admin/image/'.$data['shop_image']);
                        }

                    } else if(!empty($data['shop_image'])){
                        $fileNameToStores=$data['shop_image'];
                    } else{
                        $fileNameToStores="";
                    }
                    VendorBussinessDetails::insert(['vendor_id',Auth::guard('admin')->user()->vendor_id,
                                'shop_image'=>$fileNameToStores
                            ]);
                    VendorBussinessDetails::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,
                        'address_proof_image'=>$fileNameToStore
                    ]);

                    VendorBussinessDetails::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,
                    'shop_name'=>$data['shop_name'],
                    'shop_mobile'=>$data['shop_mobile'],
                    'shop_address'=>$data['shop_address'],
                    'shop_city'=>$data['shop_city'],
                    'shop_state'=>$data['shop_state'],
                    'shop_website'=>$data['shop_website'],
                    'shop_country'=>$data['shop_country'],
                    'business_license_number'=>$data['business_license_number'],
                    'shop_email'=>$data['shop_email'],
                    'address_proof'=>$data['address_proof'],
                    'shop_pincode'=>$data['shop_pincode'],
                    ]);
        }

        notify()->success('Upated Vendor_Business_Details Successfully!');
        return redirect()->back();
    }

    public function updatevendorbankdetails(){

        $appsettings=AppSetting::all()->toArray();



        $vendorCount=VendorBankDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
        if($vendorCount >0){
         $VendorBankDetails=VendorBankDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }else{
         $VendorBankDetails=array();
        }

        return view('admin.vendor.updatevendorbankdetails',compact('VendorBankDetails','appsettings'));
    }
    public function update_vendor_bank_details(Request $request){

        $data=$request->all();
        $vendorCount=VendorBankDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
        if($vendorCount >0){
         VendorBankDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update([
            'account_holder_name'=>$data['account_holder_name'],
            'bank_name'=>$data['bank_name'],
            'account_number'=>$data['account_number'],
            ]);
        }else{
            VendorBankDetails::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,
                'account_holder_name'=>$data['account_holder_name'],
                'bank_name'=>$data['bank_name'],
                'account_number'=>$data['account_number'],
                ]);
        }

        notify()->success('Upated Vendor_Bank_Details Successfully!');
        return redirect()->back();
    }

    // for active and inactive admin type

    public function active_user($vendor_id){

        $vendor=Admin::find($vendor_id);
        $vendor->status=1;
        $vendor->update();

        // $vendorstatus=Vendor::where('id',$vendor_id)->first()->toArray();

        // $admin=Vendor::where('id',$vendor_id)->update(['status'=>1]);

        $adminDetails=Admin::where('id',$vendor_id)->first()->toArray();
        if($adminDetails['type']=="vendor" && $adminDetails['status']==1){
            $email=$adminDetails['email'];
            $messageData=[
                'email'=>$adminDetails['email'],
                'name'=>$adminDetails['name'],
                'mobile'=>$adminDetails['mobile']
            ];
            Mail::send('emails.vendor_approved',$messageData,function($message)use($email){
                $message->to($email)->subject('Vendor Account is Approved');
            });
        }
        notify()->success('Vendor Status is !','Active');
        return redirect('admin/displayall');
    }


    public function inactive_user($vendor_id){

        $vendor=Admin::find($vendor_id);
        $vendor->status=0;
        $vendor->update();


        notify()->warning('Vendor Status is !','InActive');
       return redirect('admin/displayall');
    }



        // public function display_vendor(){
        // if(Auth::guard('admin')->user()->type!="superadmin"){
        //     notify()->error('This feature is restricted ','Restricted');
        //     return redirect('admin/dashboard');
        // }
        // $appsettings=AppSetting::all()->toArray();
        //

        // $vendor=Admin::where('type','vendor')->get()->toArray();
        // $admin=Admin::where('type','Admin')->get()->toArray();
        // $subadmin=Admin::where('type','superadmin')->get()->toArray();

        // return view('admin.admin.allvendor',compact('vendor'),compact('admin','appsettings'),compact('subadmin'));

        // }
        // public function display_admin(){

        //     if(Auth::guard('admin')->user()->type!="superadmin"){
        //         notify()->error('This feature is restricted ','Restricted');
        //         return redirect('admin/dashboard');
        //     }
        //     $admin=Admin::where('type','Admin')->get()->toArray();
        //     $appsettings=AppSetting::all()->toArray();
        //

        //     return view('admin.admin.alladmin',compact('admin','appsettings'));

        // }
        // public function display_subadmin(){
        //     $appsettings=AppSetting::all()->toArray();
        //
        //     if(Auth::guard('admin')->user()->type!="superadmin"){
        //         notify()->error('This feature is restricted ','Restricted');
        //         return redirect('admin/dashboard');
        //     }
        //     $subadmin=Admin::where('type','superadmin')->get()->toArray();

        //     return view('admin.admin.allsubadmin',compact('appsettings','subadmin'));

        // }
        public function displayall(){
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_all_admins')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings=AppSetting::all()->toArray();


            $all=Admin::all();

            return view('admin.admin.all',compact('appsettings','all'));
        }


        //for view details about vendor
        public function viewVendorDetails($id){
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_vendor_detail')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings=AppSetting::all()->toArray();


            $vendorDetails=Admin::with(['vendorPersonal','vendorBusiness','vendorBank'])->find($id);
            $vendorDetails=json_decode(json_encode($vendorDetails),true);
        //  dd($vendorDetails);
          return view('admin.vendor.vendor_view_details',compact('appsettings','vendorDetails'));

        }


        public function adminsubadmins(){
            $appsettings=AppSetting::all()->toArray();



            $admin_subadmins=Admin::all();
            return view('admin.admin.admin_and_subadmin',compact('appsettings','admin_subadmins'));
        }

        public function  active_admin_and_subadmin($id){
            $admin=Admin::find($id);
            $admin->status=1;
            $admin->update();
            notify()->success(' Status is !','Active');

            return redirect()->back();
        }
        public function  inactive_admin_and_subadmin($id){
            $admin=Admin::find($id);
            $admin->status=0;
            $admin->update();
            notify()->error(' Status is !','InActive');
            return redirect()->back();
        }
        public  function delete_admin_and_subadmin($id){
           $admin=Admin::find($id);
           $admin->delete();
            notify()->error(' Admin or Subadmin ','Deleted');
            return redirect()->back();
        }

        public function add_admin_or_subadmin(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('create_admin')) {
            return view('admin.errors.unauthorized');
        }

        $appsettings=AppSetting::all()->toArray();


        $all_admin=Admin::all();
        $role=Roles::all();
        return view('admin.admin.add_admin_and_subadmin',compact('appsettings','role','all_admin'));

        }

        public function store_admin_or_subadmin(Request $request){
            $this->validate($request,[
                'image'=>'required',
                'name' => 'required',
                'email'=>'email',
                'mobile'=> 'required',
                'password'=>'required'
            ]);
//            dd($request->all());
             $adminCount=Admin::where('email',$request->input('email'))->count();
              if($adminCount>0){
                  notify()->error('Admin/Sub-Admin already exists','Exsit');
                  return redirect()->back();
              }
              $adminmobile=Admin::where('mobile',$request->input('mobile'))->first();
            //   dd($adminmobile);
              if($adminmobile!=null){
                 notify()->error('Admin/Sub-Admin mobile number exists','Exsit');
                 return redirect()->back();
              }
            $admin = new Admin();

            $admin->name=$request->input('name');
            $admin->type=$request->input('type');
            $admin->email=$request->input('email');
            $admin->mobile=$request->input('mobile');
            $admin->password=Hash::make($request->input('password'));


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
                $path=$request->file('image')->storeAs('public/admin/image',$fileNameToStore);

                $admin->image=$fileNameToStore;
            }
            $admin->save();

            notify()->success('Admin/Sub-Admin Added','Success');
            return redirect('admin/displayall');
        }

        public  function edit_admin_or_subadmin($id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_admin')) {
            return view('admin.errors.unauthorized');
        }
        $role=Roles::all();


        $appsettings=AppSetting::all()->toArray();


        $admin=Admin::find($id);
        return view('admin.admin.edit_admin_and_subadmin',compact('role','admin','appsettings'));
        }

        public function update_admin_or_subadmin(Request $request){
            $this->validate($request,[
                'name' => 'required',
                'email'=>'email',
                'mobile'=> 'required',
            ]);
                //           dd($request->all());
                // $adminCount=Admin::where('email',$request->input('email'))->count();
                // if($adminCount>0){
                //     notify()->error('Admin/Sub-Admin already exists','Exsit');
                //     return redirect()->back();
                // }
                // $adminmobile=Admin::where('mobile',$request->input('mobile'));
                // if($adminmobile>0){
                // notify()->error('Admin/Sub-Admin mobile number exists','Exsit');
                // return redirect()->back();
                // }

            $admin = Admin::find($request->input('id'));
            $admin->name=$request->input('name');
            $admin->type=$request->input('type');
            $admin->email=$request->input('email');
            $admin->mobile=$request->input('mobile');

            if($request->hasFile('image'))
            {

                //get file name with ext
                $fileNameWithExt=$request->file('image')->getClientOriginalName();
                //get just file name
                $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                //get just file extenstion
                $extension=$request->file('image')->getClientOriginalExtension();
                //file name to store
                $fileNameToStore=$fileName.'_'.time().'.'.$extension;

                //upload image
                $path=$request->file('image')->storeAs('public/admin/image',$fileNameToStore);

                if('image'){
                    Storage::delete('public/admin/image/'.$admin['image']);
                }
                $admin->image=$fileNameToStore;
            }
            $admin->update();

            notify()->success('Admin/Sub-Admin Updated','Updated');
            return redirect('admin/displayall');
        }
        public function updateRole(Request $request,$id){
        if($request->isMethod('post')){
            $data=$request->all();
            unset($data['_token']);
            AdminsRole::where('admin_id',$id)->delete();

            foreach ($data as $key => $value){
               if(isset($value['view'])) {
                   $view = $value['view'];
               }else{
                   $view=0;
               }
               if(isset($value['edit'])) {
                    $edit = $value['edit'];
                }else{
                    $edit=0;
               }
               if(isset($value['full'])) {
                    $full = $value['full'];
                }else{
                    $full=0;
               }
               AdminsRole::where('admin_id',$id)->insert(['admin_id'=>$id,'module'=>$key,'view_access'=>$view,'edit_access'=>$edit,'full_access'=>$full]);

            }
            notify()->success('Roles Updated Successfully!');
            return redirect()->back();
        }
        $appsettings=AppSetting::all()->toArray();
        $adminDetails=Admin::where('id',$id)->first()->toArray();
        $adminRoles=AdminsRole::where('admin_id',$id)->get()->toArray();
        return view('admin.admin.admin_role.update_roles',compact('appsettings','adminDetails','adminRoles'));
        }


        public function ForgetPassword() {
            return view('admin.forget_password.forget');
        }
        public function ForgetPasswordStore(Request $request) {
            $request->validate([
                'email' => 'required|email|exists:users',
            ]);

            $token = Str::random(64);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::send('emails.reset-password', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                $message->subject('Reset Password');
            });
            notify('We have emailed your password reset link!');
            return back();
        }
        public function ResetPassword($token) {

            return view('admin.forget_password.forget-password-link', ['token' => $token]);
        }

        public function ResetPasswordStore(Request $request) {
            $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required'
            ]);

            $update = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();

            if(!$update){
                return back()->withInput()->with('error', 'Invalid token!');
            }

            $user = Admin::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

            // Delete password_resets record
            DB::table('password_resets')->where(['email'=> $request->email])->delete();


            notify('Your password has been successfully changed!');
            return redirect('admin/admin_login');
        }

}
