<?php
use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\AdminRolesController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CouponsController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\FontendController;
use App\Http\Controllers\Front\AddressController as FrontAddressController;
use App\Http\Controllers\Front\ProductController as FrontProductController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\VendorController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Product;

use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolePermissions;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Socail\AuthController;
use App\Http\Controllers\VendorController as ControllersVendorController;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),
 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::prefix('admin')->group(function(){
    // Routing for Admin
         // Google login
         Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
         Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback']);

         // Github login
         Route::get('login/github', [AuthController::class, 'redirectToGithub'])->name('login.github');
         Route::get('login/github/callback', [AuthController::class, 'handleGithubCallback']);

            // Github login
        Route::get('login/linkedin', [AuthController::class, 'redirectToLinkedIn'])->name('login.linkedin');
        Route::get('login/linkedin/callback', [AuthController::class, 'handleLinkedInCallback']);


    Route::group(['middleware'=>['admin']],function(){

        //routing for warehouse



        //for role and permission
       Route::resource('roles',RolesController::class);
       Route::resource('permissions',PermissionsController::class);

       Route::get('role/{id}/permission',[RolePermissions::class,'edit'])->name('role_permissions_edit');
       Route::put('roles/{role}/permissions', [RolePermissions::class, 'update'])->name('role_permissions.update');

       Route::get('user/{id}/role',[RolePermissions::class,'edit'])->name('user_role_edit');
       Route::put('users/{user}/roles', [AdmminRolesController::class, 'update'])->name('user_roles.update');

       Route::get('all-admins', [AdminAdminController::class, 'index'])->name('all-admins.index');
       Route::get('users/{user}/assign-role', [AdminAdminController::class, 'assignRole'])->name('users.assign_role');
       Route::post('users/{user}/update-role', [AdminAdminController::class, 'updateRole'])->name('users.update_role');

    //    assing role to delivery-boy
       Route::get('all-delivery-boys', [DeliveryBoyRolesController::class, 'index'])->name('all-delivery-boy.index');
       Route::get('delivery-boy/{user}/assign-role', [DeliveryBoyRolesController::class, 'assignRole'])->name('delivery_boy.assign_role');
       Route::post('delivery-boy/{user}/update-role', [DeliveryBoyRolesController::class, 'updateRole'])->name('delivery_boy.update_role');



        Route::get('dashboard',[DashboardController::class,'index'])->name('maindashboard');
        Route::get('adminlogout',[AdminController::class,'logout'])->name('adminlogout');
        Route::get('update_admin_password',[AdminController::class,'updateadminpassword'])->name('update_admin_password');
        Route::post('updateadminpassword',[AdminController::class,'update_admin_password'])->name('updateadminpassword');

        Route::get('updateadmindetails',[AdminController::class,'updateadmindetails'])->name('updateadmindetails');
        Route::put('update_admin_details',[AdminController::class,'update_admin_details'])->name('update_admin_details');

       //for update vendor
       Route::get('updatevendordetails',[AdminController::class,'updatevendordetails'])->name('updatevendordetails');
       Route::get('updatevendorbankdetails',[AdminController::class,'updatevendorbankdetails'])->name('updatevendorbankdetails');
       Route::get('updatevendorbusinessdetails',[AdminController::class,'updatevendorbusinessdetails'])->name('updatevendorbusinessdetails');

       Route::put('update_vendor_details',[AdminController::class,'update_vendor_details'])->name('update_vendor_details');
       Route::put('update_vendor_businessdetails',[AdminController::class,'update_vendor_businessdetails'])->name('update_vendor_businessdetails');
       Route::put('update_vendor_bank_details',[AdminController::class,'update_vendor_bank_details'])->name('update_vendor_bank_details');

       //display admintype
    //    Route::get('display_vendor',[AdminController::class,'display_vendor'])->name('display_vendor');
    //    Route::get('display_admin',[AdminController::class,'display_admin'])->name('display_admin');
    //    Route::get('display_subadmin',[AdminController::class,'display_subadmin'])->name('display_subadmin');

       //routing for vendor status
        Route::get('active/{vendor_id}',[AdminController::class,'active_user'])->name('active_user');
       Route::get('inactive/{vendor_id}',[AdminController::class,'inactive_user'])->name('inactiveuser');

        // display all users on admin table
       Route::get('displayall',[AdminController::class,'displayall'])->name('displayall');

       Route::get('view_vendor_details/{id}',[AdminController::class,'viewVendorDetails'])->name('viewVendorDetails');



       //Routing for products tables
       Route::get('products',[ProductController::class,'product'])->name('products');
       Route::get('products/addproduct',[ProductController::class,'create'])->name('addproduct');



       Route::get('active/product/{product_id}',[ProductController::class,'active'])->name('active_products');
       Route::get('inactive/product/{product_id}',[ProductController::class,'inactive'])->name('inactive_products');
       Route::get('product/delete/{product_id}',[ProductController::class,'deleteproduct'])->name('delete_product');

       Route::get('featured/product/{product_id}',[ProductController::class,'featured'])->name('featured_products');
       Route::get('notfeatured/product/{product_id}',[ProductController::class,'notfeatured'])->name('notfeatured_product');

       //Route::post('storepro',[ProductController::class,'addproduct'])->name('store_product');
       Route::post('store_product',[ProductController::class,'addproduct'])->name('store_product');

       Route::post('fetchsubcategory',[ProductController::class,'fetchSubcategory'])->name('fetchsubcategory');
       //for edit products

       Route::get('edit/product/{product_id}',[ProductController::class,'edit'])->name('edit_product');
       Route::put('products/update/',[ProductController::class,'update'])->name('update_product');

       Route::get('products/add_attribute/{id}',[ProductController::class,'add_attribute'])->name('add_attribute');
       Route::post('products/addattributes',[ProductController::class,'addattributes'])->name('addattributes');

       Route::get('products/active_attribute/{id}',[ProductController::class,'active_attribute'])->name('active_attribute');
       Route::get('products/inactive_attribute/{id}',[ProductController::class,'inactive_attribute'])->name('inactive_attribute');
       Route::get('products/delete_attribute/{id}',[ProductController::class,'deleteattribute'])->name('deleteattribute');

       Route::post('products/attributes/{id}',[ProductController::class,'editAttributes'])->name('editAttributes');


       //Routing for product image
       Route::get('products/images/{id}',[ProductController::class,'addImages'])->name('addImages');
       Route::post('products/images',[ProductController::class,'add_image'])->name('add_image');

       //routing for active and inactive product images
       Route::get('products/active_productimage/{id}',[ProductController::class,'active_ProdcutImage'])->name('active_ProdcutImage');
       Route::get('products/inactive_prodcutImage/{id}',[ProductController::class,'inactive_ProductImage'])->name('inactive_ProdcutImage');

       //routing for delete images
       Route::get('products/delete_image/{id}',[ProductController::class,'deleteaImageProduct'])->name('deleteaImageProduct');


       //Routing for banners

       Route::match(['get','post'],'banners',[BannerController::class,'banners'])->name('banners');
        //routing for active and inactive product images
       Route::get('banners/active/{id}',[BannerController::class,'active_banner'])->name('active_banner');
       Route::get('banners/inactive/{id}',[BannerController::class,'inactive_banner'])->name('inactive_banner');

       Route::get('banners/delete/{banner_id}',[BannerController::class,'delete'])->name('delete_banners');
       Route::get('banners/create',[BannerController::class,'create'])->name('create_banners');
    //    Route::post('banners/store',[BannerController::class,'store'])->name('store_banners');

       Route::get('banners/edit/{id}',[BannerController::class,'edit'])->name('edit_banner');
       Route::put('banner/update',[BannerController::class,'update'])->name('update_banner');

      Route::get('coupons',[CouponsController::class,'coupons'])->name('coupons');
      Route::match(['get','post'],'coupons/add-edit/{id?}',[CouponsController::class,'addEditCoupon'])->name('add_edit_coupon');
      Route::get('coupons/{coupon_id}/edit',[CouponsController::class,'edit'])->name('edit_coupon');
      Route::post('coupons/store',[CouponsController::class,'store'])->name('store_coupon');
      Route::put('coupons/update',[CouponsController::class,'update'])->name('update_coupon');
      Route::get('coupons/{coupons_id}/delete',[CouponsController::class,'destory'])->name('delete_coupon');

      Route::get('coupons/active/{coupons_id}',[CouponsController::class,'active'])->name('active_coupon');
      Route::get('coupons/inactive/{coupons_id}',[CouponsController::class,'inactive'])->name('inactive_coupon');

      Route::get('users',[AdminUserController::class,'users'])->name('users');
      Route::get('users/active/{user_id}',[AdminUserController::class,'active'])->name('active_users');
      Route::get('users/inactive/{user_id}',[AdminUserController::class,'inactive'])->name('inactive_users');
      Route::get('users/{user_id}/delete',[AdminUserController::class,'destory'])->name('delete_user');



      Route::get('admins-subadmins',[AdminController::class,'adminsubadmins'])->name('admin_subadmin');
      Route::get('admin_subadmin_active/{id}',[AdminController::class,'active_admin_and_subadmin'])->name('active_admin_subadmin');
      Route::get('admin_subadmin_inactive/{id}',[AdminController::class,'inactive_admin_and_subadmin'])->name('inactive_admin_subadmin');
      Route::get('admin-subadmin/{id}',[AdminController::class,'delete_admin_and_subadmin'])->name('delete_admin_or_subadmin');

      Route::get('add_admin',[AdminController::class,'add_admin_or_subadmin'])->name('add_admin_or_subadmin');
      Route::post('store_admin_or_subadmin',[AdminController::class,'store_admin_or_subadmin'])->name('store_admin_or_subadmin');
      Route::get('edit_admin/{id}',[AdminController::class,'edit_admin_or_subadmin'])->name('edit_admin_or_subadmin');
      Route::put('update_admin_or_subadmin',[AdminController::class,'update_admin_or_subadmin'])->name('update_admin_or_subadmin');

      Route::get('add_user',[AdminUserController::class,'adduser'])->name('add_user');
      Route::post('store_user',[AdminUserController::class,'store_user'])->name('store_user');
      Route::get('edit_user/{id}',[AdminUserController::class,'edit_user'])->name('edit_user');
      Route::put('udpate_user',[AdminUserController::class,'update_user'])->name('update_user');


      //routeing for role and permissions
      Route::match(['get','post'],'update-role/{id}',[AdminController::class,'updateRole'])->name('update_role');


        //routing for advertisement
        Route::get('adverstisements',[AdvertisementController::class,'index'])->name('adverstisements');
        Route::get('adverstisements/add',[AdvertisementController::class,'create'])->name('add_adverstisements');
        Route::post('store_adverstisements',[AdvertisementController::class,'store'])->name('store_adverstisements');
        Route::put('update_adverstisements',[AdvertisementController::class,'update'])->name('update_adverstisements');

        Route::get('adverstisements/edit/{id}',[AdvertisementController::class,'edit'])->name('edit_adverstisements');
        Route::get('adverstisements/delete/{id}',[AdvertisementController::class,'delete'])->name('delete_adverstisements');
        Route::get('adverstisements/inactive/{id}',[AdvertisementController::class,'inactive'])->name('inactive_adverstisements');
        Route::get('adverstisements/active/{id}',[AdvertisementController::class,'active'])->name('active_adverstisements');
        //routing for app settings
        Route::get('appsettings',[AppSettingController::class,'create'])->name('appsettings');
        Route::put('appsettings/update',[AppSettingController::class,'update'])->name('update_appsettings');



    //Routing for product Categories
    Route::get('append-categories-level',[CategoriesController::class,'appendCategoryLevel'])->name('append-categories-level');
    Route::get('categories',[CategoriesController::class,'index'])->name('categories');
    Route::get('categories/add',[CategoriesController::class,'create'])->name('add_categories');
    Route::post('categories/store',[CategoriesController::class,'store'])->name('store_categories');
    Route::get('categories/{id}/edit',[CategoriesController::class,'edit'])->name('edit_categories');
    Route::get('categories/{categoires_id}/delete',[CategoriesController::class,'destory'])->name('delete_categories');
    Route::put('categories/update',[CategoriesController::class,'update'])->name('upate_categories');

    Route::get('active/category/{categories_id}',[CategoriesController::class,'active'])->name('active_category');
    Route::get('inactive/category/{categories_id}',[CategoriesController::class,'inactive'])->name('inactive_category');

    //routing for groups
    Route::get('groups',[GroupController::class,'index'])->name('groups');
    Route::get('groups/{group_id}/edit',[GroupController::class,'edit'])->name('edit_group');
    Route::get('groups/delete/{group_id}',[GroupController::class,'destory'])->name('group_destory');
    Route::get('groups/add',[GroupController::class,'create'])->name('add_group');
    Route::post('groups/store',[GroupController::class,'store'])->name('store_group');
    Route::put('group/{group_id}/update',[GroupController::class,'update'])->name('update_group');

    Route::get('active/group/{group_id}',[GroupController::class,'active'])->name('active_groups');
    Route::get('inactive/group/{group_id}',[GroupController::class,'inactive'])->name('inactive_groups');


    //routing for brands
    Route::get('brands',[BrandController::class,'index'])->name('brands');
    Route::get('brands/add',[BrandController::class,'create'])->name('add_brand');
    Route::get('brands/{brand_id}/edit',[BrandController::class,'edit'])->name('edit_brand');
    Route::post('brands/store',[BrandController::class,'store'])->name('store_brand');
    Route::put('brands/update',[BrandController::class,'update'])->name('update_brand');
    Route::get('barnds/{brand_id}/delete',[BrandController::class,'destory'])->name('delete_brand');

    Route::get('active/brands/{brand_id}',[BrandController::class,'active'])->name('active_brands');
    Route::get('inactive/brands/{brand_id}',[BrandController::class,'inactive'])->name('inactive_brands');
    //Routing for Filters
    Route::get('filters',[FilterController::class,'filters'])->name('filters');
    Route::get('active/filters/{id}',[FilterController::class,'active'])->name('active_filters');
    Route::get('inactive/filters/{id}',[FilterController::class,'inactive'])->name('inactive_filters');
    Route::get('filters/create',[FilterController::class,'create'])->name('create_filter');
    Route::post('filters/store',[FilterController::class,'store'])->name('store_filter');
    //Routing for fiters_values
    Route::get('filters_values',[FilterController::class,'filtersValues'])->name('filters_values');
    Route::get('active/filters_values/{id}',[FilterController::class,'active_filters_value'])->name('active_filters_values');
    Route::get('inactive/filters_values/{id}',[FilterController::class,'inactive_filters_value'])->name('inactive_filters_values');

    Route::post('category-filters',[FilterController::class,'categoryFilters'])->name('category_filters');
    Route::get('filters/create_filter_values',[FilterController::class,'createfiltervalues'])->name('create_filter_values');
    Route::post('filters/store_filter_value',[FilterController::class,'storefiltervalues'])->name('store_filter_value');

    Route::get('view-users-city',[DashboardController::class,'userscity'])->name('users_city');
});

    Route::get('admin_login',[AdminController::class,'loginpage'])->name('admin_login');
    //forget password
    Route::get('forget-password', [AdminController::class, 'ForgetPassword'])->name('ForgetPasswordGet');
    Route::post('forget-password', [AdminController::class, 'ForgetPasswordStore'])->name('ForgetPasswordPost');
    Route::get('reset-password/{token}', [AdminController::class, 'ResetPassword'])->name('ResetPasswordGet');
    Route::post('reset-password', [AdminController::class, 'ResetPasswordStore'])->name('ResetPasswordPost');

    Route::post('login',[AdminController::class,'loginvalidate'])->name('login_admin');

});


Route::get('/',[FontendController::class,'index'])->name('bytecommerce');

 //user login
 //for newslettersubscriber
 //forget a password for users
 Route::match(['get','post'],'user/forgot-password',[UserController::class,'forgotPassword']);
 //User Logout
 Route::get('user/logout',[UserController::class,'userLogout']);
 //Confirm User Account
 Route::get('user/confirm/{code}',[UserController::class,'confirmAccount']);


