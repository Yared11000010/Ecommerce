<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Group;
use App\Models\ProductFilter;
use App\Models\ProductFilterValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
class FilterController extends Controller
{
    //
    public function filters(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_filters')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        Session::put('page','filters');
        $filters=ProductFilter::get()->toArray();

        // dd($filters);die;
        return view('admin.filters.filters',compact('appsettings','filters'));
    }
    public function active($id){


        $filters=ProductFilter::find($id);
        $filters->status=1;
        $filters->update();
        notify()->success('Product Filters','Active');

        return redirect('admin/filters');
    }
    public function inactive($id){

        $filters=ProductFilter::find($id);
        $filters->status=0;
        $filters->update();
        notify()->error('Product Filters','InActive');
        return redirect('admin/filters');
    }

    public function create(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('create_filters')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();

        $categories=Group::with('categories')->get()->toArray();

        return view('admin.filters.add_filter',compact('appsettings','categories'));
    }

    public function store(Request $request){

        $data=$this->validate($request,[
            'cat_ids'=>'required',
            'filter_name'=>'required',
            'fiter_column'=>'required',
          ]);

        //   echo "<pre>";
        //   print_r($data);die;
          $cat_ids=implode(',',$data['cat_ids']);
          $filter=new ProductFilter();
          $filter->cat_ids=$cat_ids;
          $filter->filter_name=$data['filter_name'];
          $filter->filter_column=$data['fiter_column'];
          $filter->status=1;

          DB::statement('Alter table products add '.$data['fiter_column'].' varchar(255) after description');

          $filter->save();
          notify()->success('Filter is Added !');

        return  redirect('admin/filters');
    }




    //for filters_values
    public function filtersValues(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_filters_value')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        Session::put('page','filters');
        $filters_values=ProductFilterValues::get()->toArray();

        // dd($filters);die;
        return view('admin.filters.filters_value',compact('appsettings','filters_values'));
    }
    public function active_filters_value($id){

        $filters=ProductFilterValues::find($id);
        $filters->status=1;
        $filters->update();
        notify()->success('Product Filters Values','Active');

        return redirect('admin/filters_value');
    }
    public function inactive_filters_value($id){

        $filters=ProductFilterValues::find($id);
        $filters->status=0;
        $filters->update();
        notify()->warning('Product Filters Values','InActive');
        return redirect('admin/filters_value');
    }



    public function createfiltervalues(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('create_filters_value')) {
            return view('admin.errors.unauthorized');
        }
        $filters=ProductFilter::where('status',1)->get()->toArray();
        $appsettings=AppSetting::all()->toArray();

        return view('admin.filters.add_filter_value',compact('appsettings','filters'));
    }

    public function storefiltervalues(Request $request){

        $data=$this->validate($request,[
            'filter_value'=>'required',
            'filter_id'=>'required',
          ]);

        //   echo "<pre>";
        //   print_r($data);die;
          $filter=new ProductFilterValues();
          $filter->filter_id=$data['filter_id'];
          $filter->filter_value=$data['filter_value'];
          $filter->status=1;


          $filter->save();
          notify()->success('Filter Values is Added !');

        return  redirect('admin/filters_values');
    }
    public function categoryFilters(Request $request){
       
         if($request->ajax()){
            $data=$request->all();
            // echo "<pre>"; print_r($data);die;

            $category_id=$data['category_id'];
            return response()->json(['view'=>(String)View::make('admin.filters.category_filters')->with(compact('category_id'))]);
         }
    }

}
