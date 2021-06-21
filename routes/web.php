<?php

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

//Route::get('/', function () {
 //   return view('welcome');
//});

Route::match(['get','post'],'/',[\App\Http\Controllers\IndexController::class, 'index']);
Route::get('/products/{id}',[\App\Http\Controllers\ProductsController::class,'products']);
Route::get('/categories/{category_id}',[\App\Http\Controllers\IndexController::class,'categories']);
Route::get('/get-product-price',[\App\Http\Controllers\ProductsController::class,'getPrice']);
//Route for Login-Register
Route::get('/login-register',[\App\Http\Controllers\UsersController::class,'userLoginRegister']);
//Route for Login-User
Route::post('/user-login',[\App\Http\Controllers\UsersController::class,'login']);


//Route for middleware after front login
Route::group(['middleware'=>['frontlogin']],function (){
    Route::match(['get','post'],'/account',[\App\Http\Controllers\UsersController::class,'account']);
    Route::match(['get','post'],'/change-password',[\App\Http\Controllers\UsersController::class,'changePassword']);
    Route::match(['get','post'],'/change-address',[\App\Http\Controllers\UsersController::class,'changeAddress']);
    Route::match(['get','post'],'/checkout',[\App\Http\Controllers\ProductsController::class,'checkout']);
});

//Route for add users Registration
Route::post('/user-register',[\App\Http\Controllers\UsersController::class,'register']);
Route::get('/user-logout',[\App\Http\Controllers\UsersController::class,'logout']);
//Route for add to cart
Route::match(['get','post'],'add-cart',[\App\Http\Controllers\ProductsController::class,'addToCart']);
Route::match(['get','post'],'/cart',[\App\Http\Controllers\ProductsController::class,'cart']);
Route::get('/cart/delete-product/{id}',[\App\Http\Controllers\ProductsController::class,'deleteCartProduct']);
Route::get('/cart/update-quantity/{id}/{quantity}',[\App\Http\Controllers\ProductsController::class,'updateCartQuantity']);
//Apply coupon code
Route::post('/cart/apply-coupon',[\App\Http\Controllers\ProductsController::class,'applyCoupon']);
Route::match(['get','post'],'/admin',[\App\Http\Controllers\AdminController::class,'login']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>['auth']],function(){
    Route::match(['get','post'],'/admin/dashboard',[\App\Http\Controllers\AdminController::class,'dashboard']);

    //Category Route
Route::match(['get','post'],'/admin/add-category',[\App\Http\Controllers\CategoryController::class,'addCategory']);
Route::match(['get','post'],'/admin/view-category',[\App\Http\Controllers\CategoryController::class,'viewCategories']);
Route::match(['get','post'],'/admin/edit_category/{id}',[\App\Http\Controllers\CategoryController::class,'editCategory']);
Route::match(['get','post'],'/admin/delete_category/{id}',[\App\Http\Controllers\CategoryController::class,'deleteCategory']);
Route::post('/admin/update-category-status',[\App\Http\Controllers\CategoryController::class,'updateStatus']);





    //Product Route
    Route::match(['get','post'],'/admin/add-product',[\App\Http\Controllers\ProductsController::class,'addProduct']);
    Route::match(['get','post'],'/admin/view-products',[\App\Http\Controllers\ProductsController::class,'viewProducts']);
    Route::match(['get','post'],'/admin/edit-product/{id}',[\App\Http\Controllers\ProductsController::class,'editProduct']);
  //  Route::match(['get','post'],'/admin/edit-product/{id}',[\App\Http\Controllers\ProductsController::class,'edit']);
    Route::match(['get','post'],'/admin/delete-product/{id}',[\App\Http\Controllers\ProductsController::class,'deleteProduct']);
    Route::post('/admin/update-product-status',[\App\Http\Controllers\ProductsController::class,'updateStatus']);
    Route::post('/admin/update-featured-product-status',[\App\Http\Controllers\ProductsController::class,'updateFeatured']);


    //Products Attributes
    Route::match(['get','post'],'/admin/add-attributes/{id}',[\App\Http\Controllers\ProductsController::class,'addAttributes']);
    Route::get('/admin/delete-attribute/{id}',[\App\Http\Controllers\ProductsController::class,'deleteAttribute']);
    Route::match(['get','post'],'/admin/edit-attributes/{id}',[\App\Http\Controllers\ProductsController::class,'editAttribute']);
    Route::match(['get','post'],'/admin/update-attribute/{id}',[\App\Http\Controllers\ProductsController::class,'updateAttribute']);
    Route::match(['get','post'],'/admin/images/{id}',[\App\Http\Controllers\ProductsController::class,'images']);
    Route::match(['get','post'],'/admin/add-images/{id}',[\App\Http\Controllers\ProductsController::class,'addImages']);
    Route::get('/admin/delete-alt-image/{id}',[\App\Http\Controllers\ProductsController::class,'deleteAltImage']);


    //Banner Route
    Route::match(['get','post'],'/admin/banners',[\App\Http\Controllers\BannersController::class,'banners']);
    Route::match(['get','post'],'/admin/add-banner',[\App\Http\Controllers\BannersController::class,'addBanner']);
    Route::match(['get','post'], '/admin/edit-banner/{id}',[\App\Http\Controllers\BannersController::class,'editBanner']);
    Route::match(['get','post'],'/admin/delete-banner/{id}',[\App\Http\Controllers\BannersController::class,'deleteBanner']);
    Route::post('/admin/update-banner-status',[\App\Http\Controllers\BannersController::class,'updateStatus']);


    Route::match(['get','post'],'/admin/add-coupon',[\App\Http\Controllers\CouponsController::class,'addCoupon']);
    Route::match(['get','post'],'/admin/view-coupons',[\App\Http\Controllers\CouponsController::class,'viewCoupons']);
    Route::match(['get','post'],'/admin/edit-coupons/{id}',[\App\Http\Controllers\CouponsController::class,'editCoupons']);
    Route::match(['get','post'],'/admin/delete-coupons/{id}',[\App\Http\Controllers\CouponsController::class,'deleteCoupons']);
    Route::post('/admin/update-coupon-status',[\App\Http\Controllers\CouponsController::class,'updateStatus']);
});
//Route::resource('/admin/products',[App\Http\Controllers\ProductsController::class]);

Route::get('/logout',[\App\Http\Controllers\AdminController::class,'logout']);


