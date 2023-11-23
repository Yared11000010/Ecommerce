<?php

namespace App\Http\Controllers\Dashboard;

use App\Charts\MonthlyOrderChart;
use App\Charts\MonthlyUserRegisterChart;
use App\Charts\MonthlyUsersChart;
use App\Charts\Order_Payment_StatusChart;
use App\Charts\paymentChart;
use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index(MonthlyUsersChart $chart,MonthlyOrderChart $c,MonthlyUserRegisterChart $user,Order_Payment_StatusChart $payment){
        //generate report for a users
        $current_month_users=User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->count();
        $before_1_month_users=User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(1))->count();
        $before_2_month_users=User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(2))->count();
        $before_3_month_users=User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(3))->count();
        $userCount=array($current_month_users,$before_1_month_users,$before_2_month_users,$before_3_month_users);

        $appsettings=AppSetting::all()->toArray();

        // $orderproducts=OrderProduct::all()->where('vendor_id',Auth::guard ('admin')->user()->vendor_id);
        // $vendorproducts=Product::all()->where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();

        // dd($vendorproducts);

        // dd($appsettings);
        $allproducts=Product::all()->where('status',1)->count();
        $allusers=User::all()->where('status',1)->count();
        $allvendors=Vendor::all()->where('status',1)->count();

        return view('layouts.maindashboard',compact('appsettings','allproducts','allusers','allvendors'));
    }

    public function order_reports(){

        $appsettings=AppSetting::all()->toArray();
        // $current_month_order=Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->count();
        // $before_1_month_order=Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(1))->count();
        // $before_2_month_order=Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(2))->count();
        // $before_3_month_order=Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(3))->count();

        // $ordersCount=array($current_month_order,$before_1_month_order,$before_2_month_order,$before_3_month_order);
//        dd($ordersCount);die;
        return view('layouts.orders_reports');
    }
    public function userscity(){

        $appsettings=AppSetting::all()->toArray();
        $getUserCity=User::select('city',DB::raw('count(city) as count'))->groupBy('city')->get();
//        dd($getUserCity);die;
       return view('layouts.city_reports',compact('getUserCity','appsettings'));
    }
}
