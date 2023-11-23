<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\CmsPage;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    //
    public function index(){
        $cms_pages=CmsPage::get()->toArray();
        $appsettings=AppSetting::all()->toArray();
        return view('fontend.login_register',compact('cms_pages','appsettings'));
    }
}
