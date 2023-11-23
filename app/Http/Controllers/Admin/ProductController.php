<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminsRole;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductFilter;
use App\Models\ProductsImage;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Contracts\RenderlessTrace;

class ProductController extends Controller
{
    //
    public function product(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_product')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();

        Session::put('page', 'products');
        $adminType=Auth::guard('admin')->user()->type;
        $vendor_id=Auth::guard('admin')->user()->vendor_id;
        if($adminType=="vendor"){
          $vendorStatus=Auth::guard('admin')->user()->status;
          if($vendorStatus==0){
            notify()->error('Your Vendor Account is not approved yet. Please make sure to fill your valid personal, business and bank details','Inactive Vendor Account!');
            return redirect('admin/updatevendordetails');
          }
        }

        $products=Product::with(['group'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','name');
        }]);
        if($adminType=='vendor'){
          $products=$products->where('vendor_id',$vendor_id);
        }
        $products=$products->get()->toArray();
        //set Admin/Subadmin Permissions for Products

        $productModuleCount=AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'products'])->count();

            $productModule=AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'products'])->first()->toArray();
//            dd($categoryModule);die;
       return  view('admin.products.allproducts',compact('appsettings','products','productModule'));
    }

    public function active($product_id){

        $product=Product::find($product_id);
        $product->status=1;
        $product->update();

        notify()->error('product Status !!','Inactive');
        return redirect('admin/products');
    }
    public function inactive($product_id){

        $product=Product::find($product_id);
        $product->status=0;
        $product->update();
        notify()->success('product Status !!','Active');
        return redirect('admin/products');
    }
    public function featured($product_id){

        $product=Product::find($product_id);
        $product->is_featured='Yes';
        $product->update();
        notify()->success('product featured !!','Active');

        return redirect('admin/products');
    }
    public function notfeatured($product_id){

        $product=Product::find($product_id);
        $product->is_featured='No';
        $product->update();
        notify()->error('product featured !!','InActive');
        return redirect('admin/products');
    }

    public function deleteproduct($product_id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('delete_product')) {
            return view('admin.errors.unauthorized');
        }
        $product=Product::find($product_id)->delete();
        notify()->error('Product is Deleted !','Deleted');
        return redirect('admin/products');
    }
    public function create(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('add_product')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        $categories = Group::with('categories')->get()->toArray();
        $brands=Brand::where('status',1)->get()->toArray();

        $data['categories'] = Category::get(["name", "id"]);
        // $subcategory=SubCategory::where('status',1)->get()->toArray();
        //  dd($categories);
        return view('admin.products.addproduct',compact('appsettings','brands','categories'),$data);
    }

    public function fetchSubcategory(Request $request)
    {
        $data['states'] = SubCategory::where("category_id", $request->category_id)
                                ->get(["name", "id"]);

        return response()->json($data);
    }


    public function addproduct(Request $request){

            $data=$request->all();
            $product=new Product;
            $categoryDetails=Category::find($data['category']);
            $product->group_id=$categoryDetails['group_id'];
            $product->category_id=$data['category'];
            $product->brand_id=$data['brand_id'];
            // $product->subcategory_id=$data['sub_category'];
            $productFilters=ProductFilter::productFilters();
            foreach($productFilters as $filter){
            $filterAvailable=ProductFilter::filterAvailable($filter['id'],$data['category']);
              if($filterAvailable=="Yes"){
                    if(isset($filter['filter_column'])&& $data[$filter['filter_column']]){
                          $product->{$filter['filter_column']}=$data[$filter['filter_column']];
                    }
              }
            }

            $adminType=Auth::guard('admin')->user()->type;
            $vendor_id=Auth::guard('admin')->user()->vendor_id;
            $admin_id=Auth::guard('admin')->user()->id;
            $product->admin_type=$adminType;
            $product->admin_id=$admin_id;

            if($adminType=="vendor"){
              $product->vendor_id=$vendor_id;
            }else
            {
              $product->vendor_id=0;
            }
            if(empty($data['product_discount'])){
              $data['product_discount']=0;
            }
            if(empty($data['product_weight'])){
              $data['product_weight']=0;
            }

            $productcode=Product::where('product_code',$data['product_code'])->count();
            if($productcode > 0){
                notify()->error('Product code is inavalible please enter other product code');
                return redirect()->back();
            }

            $product->product_name=$data['product_name'];
            $product->product_code=$data['product_code'];
            $product->product_color=$data['product_color'];
            $product->product_price=$data['product_price'];
            $product->product_selling_price=$data['product_selling_price'];
            $product->product_discount=$data['product_discount'];
            $product->product_tax=$data['product_tax'];
            $product->product_weight=$data['product_weight'];
            $product->description=$data['description'];
            $product->meta_title=$data['meta_title'];
            $product->meta_description=$data['meta_description'];
            $product->meta_keywords=$data['meta_keywords'];
            $product->group_code=$data['group_code'];

            $product->status=1;
            $product->is_featured='Yes';
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
                $path=$request->file('image')->storeAs('public/products',$fileNameToStore);
                if ($product->image) {
                    Storage::delete('public/products/'.$product->image);
                  }
                  $product->product_image=$fileNameToStore;
               }

               //for upload video
               if($request->hasFile('product_video')){
                //get file name with ext
                $fileNameWithExt=$request->file('product_video')->getClientOriginalName();
                //get just file name
                $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                //get just file extenstion
                $extension=$request->file('product_video')->getClientOriginalExtension();
                //file name to store
                $fileNameToStorevideo=$fileName.'_'.time().'.'.$extension;

                //upload image
                $path=$request->file('product_video')->storeAs('public/products/video',$fileNameToStorevideo);
                if ($product->product_video) {
                    Storage::delete('public/products/video'.$product->product_video);
                  }
                  $product->product_video=$fileNameToStorevideo;
               }
            $product->save();

          notify()->success('Product is Added !');
          return redirect('admin/products');
      }


      public function edit($product_id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_product')) {
            return view('admin.errors.unauthorized');
        }
        $categories = Group::with('categories')->get()->toArray();
        $appsettings=AppSetting::all()->toArray();

        $brands=Brand::where('status',1)->get()->toArray();
        $brand=Brand::where('status',1)->get();
        // $subcategory=SubCategory::where('status',1)->get()->toArray();
        $data['categories'] = Category::get(["name", "id"])->toArray();
        $product=Product::find($product_id);
        //dd($product);
        return view('admin.products.editproduct',compact('appsettings','categories','brands','brand','product'),$data);

      }
      public function update(Request $request){


        $data=$request->all();

            $product=Product::find($data['id']);
            $categoryDetails=Category::find($data['category']);
            $product->group_id=$categoryDetails['group_id'];
            $product->category_id=$data['category'];
            $product->brand_id=$data['brand_id'];
            // $product->subcategory_id=$data['sub_category'];

            $productFilters=ProductFilter::productFilters();
            foreach($productFilters as $filter){
            $filterAvailable=ProductFilter::filterAvailable($filter['id'],$data['category']);
              if($filterAvailable=="Yes"){
                    if(isset($filter['filter_column'])&& $data[$filter['filter_column']]){
                          $product->{$filter['filter_column']}=$data[$filter['filter_column']];
                    }
              }
            }
            $adminType=Auth::guard('admin')->user()->type;
            $vendor_id=Auth::guard('admin')->user()->vendor_id;
            $admin_id=Auth::guard('admin')->user()->id;
            $product->admin_type=$adminType;
            $product->admin_id=$admin_id;

            if($adminType=="vendor"){
              $product->vendor_id=$vendor_id;
            }else
            {
              $product->vendor_id=0;
            }

            $product->product_name=$data['product_name'];
            $product->product_code=$data['product_code'];
            $product->product_color=$data['product_color'];
            $product->product_price=$data['product_price'];
            $product->product_selling_price=$data['product_selling_price'];
            $product->product_discount=$data['product_discount'];
            $product->product_tax=$data['product_tax'];
            $product->product_weight=$data['product_weight'];
            $product->description=$data['description'];
            $product->meta_title=$data['meta_title'];
            $product->meta_description=$data['meta_description'];
            $product->meta_keywords=$data['meta_keywords'];
            $product->group_code=$data['group_code'];

            // $product->is_featured=$data['is_featured']==true?'Yes':'No';

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
                $path=$request->file('image')->storeAs('public/products',$fileNameToStore);
                if ($product->image) {
                    Storage::delete('public/products/'.$product->image);
                  }
                  $product->product_image=$fileNameToStore;
               }

               //for upload video
               if($request->hasFile('product_video')){
                //get file name with ext
                $fileNameWithExt=$request->file('product_video')->getClientOriginalName();
                //get just file name
                $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                //get just file extenstion
                $extension=$request->file('product_video')->getClientOriginalExtension();
                //file name to store
                $fileNameToStorevideo=$fileName.'_'.time().'.'.$extension;

                //upload image
                $path=$request->file('product_video')->storeAs('public/products/video',$fileNameToStorevideo);
                if ($product->product_video) {
                    Storage::delete('public/products/video'.$product->product_video);
                  }
                  $product->product_video=$fileNameToStorevideo;
               }

            $product->update();

          notify()->success('Product is Updated !');
          return redirect('admin/products');
      }

      public function add_attribute(Request $request,$id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('add_attribute')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        $product=Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($id);

        return view('admin.products.add_attribute',compact('appsettings','product'));
      }
      //for store product attributes into database
      public function addattributes(Request $request){

        $data=$request->all();

        foreach($data['sku'] as $key=>$value){
          if(!empty($value)){

            $skuCount=ProductAttribute::where('sku',$value)->count();
            if($skuCount>0){

              return redirect()->back()->with('error_message','Sku already exists Please add another SKU !!');
            }
            $sizeCount=ProductAttribute::where(['product_id'=>$data['id'],'size'=>$data['size'][$key]])->count();
            if($sizeCount>0){
              return redirect()->back()->with('error_message','Size already exists Please add another Size !!');
            }

            $attribute=new ProductAttribute;
            $attribute->product_id=$data['id'];
            $attribute->sku=$value;
            $attribute->size=$data['size'][$key];
            $attribute->price=$data['price'][$key];
            $attribute->stock=$data['stock'][$key];
            $attribute->status=1;
            $attribute->save();
          }
        }
        notify()->success('Attribute is Added !!');

        return redirect()->back();

      }

      //for update product attribute
      public function editAttributes(Request $request){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_attribute')) {
            return view('admin.errors.unauthorized');
        }
        $data=$request->all();
        // return dd($data);
        foreach($data['attributeId'] as $key=>$attribute){
          if(!empty($attribute)){
            ProductAttribute::where(['id'=>$data['attributeId'][$key]])->update([
              'price'=>$data['price'][$key],'stock'=>$data['stock'][$key]
            ]);
          }
        }

        notify()->success('Attribute is Added !');

        return redirect()->back();
      }


    public function active_attribute($id){

        $productattribute=ProductAttribute::find($id);
        $productattribute->status=1;
        $productattribute->update();
        notify()->success('Product Attribute Status !!','Active');

        return redirect()->back();
    }
    public function inactive_attribute($id){

        $productattribute=ProductAttribute::find($id);
        $productattribute->status=0;
        $productattribute->update();
        notify()->error('Product Attribute Status !!','Not Active');
        return redirect()->back();
    }

    public function deleteattribute($id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('delete_attribute')) {
            return view('admin.errors.unauthorized');
        }
      $productattribute=ProductAttribute::find($id);
      $productattribute->delete();
      notify()->error('Product Attribute is Deleted !!','Delete');
      return redirect()->back();
     }

  //upload multiple image for products
  public function addImages($id){
    $user = Auth::guard('admin')->user();
    if (!$user || !$user->hasPermissionByRole('add_image_to_product')) {
        return view('admin.errors.unauthorized');
    }
    $appsettings=AppSetting::all()->toArray();
    $product=Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('images')->find($id);
    return view('admin.products.add_image',compact('appsettings','product'));
  }
  public function add_image(Request $request){

    $data=$request->all();

    //echo"<pre>";print_r('$images'); die;
    if($request->hasFile('images')){
      $images=$request->file('images');
     // echo "<pre>";print_r($images); die;
      foreach($images as $key=>$image){
        //get file name with ext
        $fileNameWithExt=$image->getClientOriginalName();
        //get just file name
        $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
        //get just file extenstion
        $extension=$image->getClientOriginalExtension();
        //file name to store
        $fileNameToStore=$fileName.'_'.time().'.'.$extension;

        //upload image
        $path=$image->storeAs('public/products',$fileNameToStore);

          $images=new ProductsImage();
          if ($images->image ) {
            Storage::delete('public/products/'.$image->images);
          }
          $images->image=$fileNameToStore;
          $images->product_id=$data['id'];
          $images->status=1;
          $images->save();

      }
    }
    notify()->success('Product Image is Added !!','Save');
    return redirect()->back();
  }


  //for active and inactive product Images

  public function active_ProdcutImage($id){
    $productImage=ProductsImage::find($id);
    $productImage->status=1;
    $productImage->update();
    notify()->success('Product Image Status !!','active');

    return redirect()->back();
}
public function inactive_ProductImage($id){
    $productattribute=ProductsImage::find($id);
    $productattribute->status=0;
    $productattribute->update();

    notify()->error('Product Image Status !!','InActive');
    return redirect()->back();
}

public function deleteaImageProduct($id){
    $user = Auth::guard('admin')->user();
    if (!$user || !$user->hasPermissionByRole('delete_product_image')) {
        return view('admin.errors.unauthorized');
    }
  $productImage=ProductsImage::find($id);
  $productImage->delete();

  notify()->error('Product Attribute is Deleted !!','Deleted');
  return redirect()->back();

 }



}
