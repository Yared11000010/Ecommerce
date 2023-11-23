<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\ProductAttribute;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table="products";

    use HasFactory;

    protected $fillable = [
        'group_id',
        'category_id',
        'subcategory_id',
        'brand_id',
        'vendor_id',
        'admin_id',
        'admin_type',
        'product_name',
        'product_code',
        'product_color',
        'product_price',
        'product_selling_price',
        'product_discount',
        'product_weight',
        'product_image',
        'product_video',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_featured',
        'status',
    ];
    public function group(){
        return $this->belongsTo('App\Models\Group','group_id');
    }

    public function category(){

        return $this->belongsTo('App\Models\Category','category_id');
    }
    public function brand(){
        return $this->BelongsTo('App\Models\Brand','brand_id');
    }

    // public function subcategory(){

    //     return $this->belongsTo('App\Models\SubCategory','subcategory_id');
    // }
    public function attributes(){

        return $this->hasMany('App\Models\ProductAttribute');
    }
    public function vendor(){
        return $this->belongsTo('App\Models\Vendor','vendor_id')->with('vendorbusinessdetails');
    }
    public function images(){

        return $this->hasMany('App\Models\ProductsImage');
    }


    public static function getDiscountPrice($product_id){

        $proDetails=Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first();
        $proDetails=json_decode(json_encode($proDetails),true);
        $catDetails=Category::select('discount')->where('id',$proDetails['category_id'])->first();
        $catDetails=json_decode(json_encode($catDetails),true);

        if($proDetails['product_discount']>0){
            $discounted_price=$proDetails['product_price']-($proDetails['product_price']*$proDetails['product_discount']/100);
        }else if($catDetails['discount']>0){
            $discounted_price=$proDetails['product_price']-($proDetails['product_price']*$catDetails['discount']/100);
        }
        else{
            $discounted_price=0;
        }

        return $discounted_price;

    }
    public static function getDiscountAttributePrice($product_id,$size)
    {

        $proAttrPrice=ProductAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();

        $proDetails=Product::select('product_discount','category_id')->where('id',$product_id)->first();

        $proDetails=json_decode(json_encode($proDetails),true);
        $catDetails=Category::select('discount')->where('id',$proDetails['category_id'])->first();
        $catDetails=json_decode(json_encode($catDetails),true);

        

        if($proDetails['product_discount']>0){

            $final_price=$proAttrPrice['price']-($proAttrPrice['price']*$proDetails['product_discount']/100);
            $discount=$proAttrPrice['price'] - $final_price;

        }elseif($catDetails['discount']>0){

            $final_price=$proAttrPrice['price']-($proAttrPrice['price']*$catDetails['discount']/100);
            $discount=$proAttrPrice['price'] - $final_price;

        }
        else{
            $final_price=$proAttrPrice['price'];
            $discount=0;
        }

        return array('product_price'=>$proAttrPrice['price'],'final_price'=>$final_price,'discount'=>$discount);
    }




    public static function getProductImage($product_id){
        $getProductImage=Product::select('product_image')->where('id',$product_id)->first()->toArray();

        return $getProductImage['product_image'];
    }

    public static function getProductStatus($product_id){
        $getProductStatus=Product::select('status')->where('id',$product_id)->first();

        return $getProductStatus->status;
    }
    public static function deleteCartProduct($product_id){
        Cart::where('product_id',$product_id)->delete();
    }
    public static function isProductNew($product_id){
        $productIds= Product::select('id')->where('status',1)->orderby('id','Desc')->limit(3)->pluck('id');

        $productIds = json_decode(json_encode($productIds),true);
    //   dd($productIds);
        if(in_array($product_id,$productIds)){
            $isProductNew = "Yes";
        }else{
            $isProductNew = "No";
        }

        return $isProductNew;

    }

    public static function productCount($category_id){
        $productCount=Product::where(['category_id'=>$category_id,'status'=>1])->count();
        return $productCount;
    }

    public static function RatingCount($product_id){
        $ratingCount=Rating::where(['product_id'=>$product_id])->count();
        return $ratingCount;
    }

}
