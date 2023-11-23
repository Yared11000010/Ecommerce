<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table='categories';
    protected $fillable=[
        'group_id',
        'parent_id',
        'name',
        'image',
        'discount',
        'description',
        'url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status'
    ];
    public function group(){

        return $this->belongsTo('App\Models\Group', 'group_id')->select('id','name');
    }
    
    public function parentcategory(){
        
        return $this->belongsTo('App\Models\Category', 'parent_id')->select('id','name');
        }


    public function subcategories(){
        
     return $this->hasMany('App\Models\Category','parent_id')->where('status',1);
    }

    public static function categoryDetails($url){
        
        $categoryDetails=Category::select('id','parent_id','name','url','description')->with(['subcategories'=>function($query){
            $query->select('id','parent_id','name','url','description');
        }])->where('url',$url)->first()->toArray();
        
        //   dd($categoryDetails);
        $catIds=array();
        $catIds[]=$categoryDetails['id'];

        if($categoryDetails['parent_id']==0){
            $breadcrumbs='<li> <a href="'.$categoryDetails['url'].'" class="active">'.$categoryDetails['name'].'</a></li>';
        }
        else{
            $parentCategory=Category::select('name','url')->where('id',$categoryDetails ['parent_id'])->first()->toArray();
            $breadcrumbs='<li> <a href="'.$parentCategory['url'].'">'.$parentCategory['name'].'</a></li> /     
            <li class=" breadcrumb-item active"d>  <a href="'.$categoryDetails['url'].'" class="active">'.$categoryDetails['name'].'</a></li>';
            
        }
        foreach($categoryDetails['subcategories'] as $key=>$subcat){
            $catIds[]=$subcat['id'];
        }
        $resp=array('catIds'=> $catIds,'categoryDetails'=>$categoryDetails,'breadcrumbs'=>$breadcrumbs);
        return $resp;
    }


    public static function getCategoryName($category_id){

        $getCategoryName=Category::select('name')->where('id',$category_id)->first();
        return $getCategoryName->name;
    }
   
    public static function getCategoryStatus($category_id){
        $getCategoryStatus=Category::select('status')->where('id',$category_id)->first();
        
        return $getCategoryStatus->status;
    } 
    
}