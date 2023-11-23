<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use App\Models\AdminsRole;
use App\Models\AppSetting;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;
use PhpParser\Node\Expr\FuncCall;

class CategoriesController extends Controller
{
    //
    public function index(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_category')) {
            return view('admin.errors.unauthorized');
        }

        $appsettings=AppSetting::all()->toArray();

        $categories=Category::with(['group','parentcategory'])->get()->toArray();
        $categoryModuleCount=AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'categories'])->count();

            $categoryModule=AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'categories'])->first()->toArray();
//            dd($categoryModule);die;

        return view('categories.allcategories',compact('appsettings','categories','categoryModule'));

    }

    public function create(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('create_category')) {
            return view('admin.errors.unauthorized');
        }
        $getgroups=Group::all();
        $appsettings=AppSetting::all()->toArray();

        return view('categories.addcategory',compact('appsettings','getgroups'));
    }

    public function store(Request $request){

        $this->validate($request,[
            'group_id'=>'required|string',
            'parent_id'=>'required',
            'name'=>'required|string',
            'discount'=>'required|integer',
            'description'=>'required|string',
            'url'=>'required|string',
            'meta_title'=>'required|string',
            'meta_description'=>'required|string',
            'meta_keywords'=>'required|string',
            'meta_title'=>'required|string',
            'status'=>'nullable',
            'image'=>'required|nullable'
        ]);
        $category =new Category();
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
            $path=$request->file('image')->storeAs('public/category',$fileNameToStore);
            $category->image=$fileNameToStore;
           }

        $category->group_id=$request->input('group_id');
        $category->parent_id=$request->input('parent_id');
        $category->name=$request->input('name');
        $category->discount=$request->input('discount');
        $category->description=$request->input('description');
        $category->url=$request->input('url');
        $category->meta_title=$request->input('meta_title');
        $category->meta_description=$request->input('meta_description');
        $category->meta_keywords=$request->input('meta_keywords');
        $category->meta_title=$request->input('meta_title');
        $category->status=$request->status==true?'1':'0';

        $category->save();

        notify()->success('Category is Added !');
        return redirect('admin/categories');
    }

    public function update(CategoryFormRequest $request){

        $this->validate($request,[
            'group_id'=>'required|string',
            'parent_id'=>'required',
            'name'=>'required|string',
            'discount'=>'required|integer',
            'description'=>'required|string',
            'url'=>'required|string',
            'meta_title'=>'required|string',
            'meta_description'=>'required|string',
            'meta_keywords'=>'required|string',
            'meta_title'=>'required|string',
            'status'=>'nullable',
        ]);

            $category=Category::find($request->input('id'));
            $category->group_id=$request->input('group_id');
            $category->parent_id=$request->input('parent_id');
            $category->name=$request->input('name');
            $category->discount=$request->input('discount');
            $category->description=$request->input('description');
            $category->url=$request->input('url');
            $category->meta_title=$request->input('meta_title');
            $category->meta_description=$request->input('meta_description');
            $category->meta_keywords=$request->input('meta_keywords');
            $category->meta_title=$request->input('meta_title');

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
            $path=$request->file('image')->storeAs('public/category',$fileNameToStore);
            if ($category->image) {
                Storage::delete('public/category/'.$category->image);
              }

              $category->image=$fileNameToStore;

           }

        $category->update();

        notify()->success('Category is Updated !','Updated');
        return redirect('admin/categories');

    }

    public function edit($id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_category')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        $categories=Category::find($id);
        $groups=Group::all();
        $getcategory=Category::with('subcategories')->where(['parent_id'=>0,'group_id'=>$categories['group_id']])->get();

      return view('categories.editcategories',compact('appsettings','categories','groups','getcategory'));

    }
    public function appendCategoryLevel(Request $request){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_category')) {
            return view('admin.errors.unauthorized');
        }
        if($request->ajax()){
        $data=$request->all();
        $getcategory=Category::with('subcategories')->where(['parent_id'=>0,'group_id'=>$data['group_id']])->get()->toArray();
        return view('categories.append_categories',compact('getcategory'));
        }
    }





    public function destory($categoires_id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('delete_category')) {
            return view('admin.errors.unauthorized');
        }
        $categories=Category::find($categoires_id);
        if($categories->image){
            Storage::delete('public/category/'.$categories->image);
        }
        $categories->delete();

        notify()->error('Category is Deleted !','Deleted');
        return redirect('admin/categories');
    }

    public function active($categoires_id){

        $category=Category::find($categoires_id);
        $category->status=1;
        $category->update();
        notify()->success('Category Status is !','Active');

        return redirect('admin/categories');
    }
    public function inactive($categoires_id){

        $category=Category::find($categoires_id);
        $category->status=0;
        $category->update();
        notify()->error('Category Status is !','InActive');
        return redirect('admin/categories');
    }
}
