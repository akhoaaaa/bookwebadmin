<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\categoryProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TheLoaiProduct;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\ResetPassController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserController;



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
//Frontedn
Route::get('/',[HomeController::class,'index']);
Route::get('/trang-chu',[HomeController::class,'index']);
Route::post('/tim-kiem',[HomeController::class,'search']);

//danh mục
Route::get('/danhmuc-sanpham',[ProductController::class,'show_category']);
Route::get('/danhmuc-sanpham/sach',[ProductController::class,'show_categoryhome_sach']);
Route::get('/danhmuc-sanpham/truyen',[ProductController::class,'show_categoryhome_truyen']);
Route::get('/chitiet-sanpham/{idproduct}',[ProductController::class,'detail_product']);





//Backend
Route::get('/admin',[AdminController::class,'index']);
Route::get('/dashboard',[AdminController::class,'show_dashboard']);
Route::get('/logout',[AdminController::class,'logout']);
Route::post('/admin-dashboard',[AdminController::class,'dashboard']);

//category
Route::get('/add-category-product',[categoryProduct::class,'add_category_product']);
Route::get('/all-category-product',[categoryProduct::class,'all_category_product']);

Route::post('/save-category-product',[categoryProduct::class,'save_category_product']);

Route::get('/unactive-category/{iddanhmuc}',[categoryProduct::class,'unactive_category']);
Route::get('/active-category/{iddanhmuc}',[categoryProduct::class,'active_category']);

Route::get('/edit-category-product/{iddanhmuc}',[categoryProduct::class,'edit_category_product']);
Route::get('/delete-category-product/{iddanhmuc}',[categoryProduct::class,'delete_category_product']);
Route::post('/update-category-product/{iddanhmuc}',[categoryProduct::class,'update_category_product']);

//product
Route::get('/add-product',[ProductController::class,'add_product']);
Route::get('/all-product',[ProductController::class,'all_product']);


Route::get('/unactive-product/{idproduct}',[ProductController::class,'unactive_product']);
Route::get('/active-product/{idproduct}',[ProductController::class,'active_product']);

Route::get('/edit-product/{idproduct}',[ProductController::class,'edit_product']);
Route::get('/delete-product/{idproduct}',[ProductController::class,'delete_product']);

Route::post('/save-product',[ProductController::class,'save_product']);
Route::post('/update-product/{idproduct}',[ProductController::class,'update_product']);

//type
Route::get('/add-type',[TheLoaiProduct::class,'add_type']);
Route::get('/all-type',[TheLoaiProduct::class,'all_type']);


Route::get('/unactive-type/{idloai}',[TheLoaiProduct::class,'unactive_type']);
Route::get('/active-type/{idloai}',[TheLoaiProduct::class,'active_type']);

Route::get('/edit-type/{idloai}',[TheLoaiProduct::class,'edit_type']);
Route::get('/delete-type/{idloai}',[TheLoaiProduct::class,'delete_type']);

Route::post('/save-type',[TheLoaiProduct::class,'save_type']);
Route::post('/update-type/{idproduct}',[TheLoaiProduct::class,'update_type']);


//cart
Route::post('/save-cart',[CartController::class,'save_cart']);
Route::post('/update-cart-quantity',[CartController::class,'update_cart_quantity']);
Route::post('/check-coupon',[CartController::class,'check_coupon']);

Route::get('/show-cart',[CartController::class,'show_cart']);
Route::get('/delete-cart/{rowId}',[CartController::class,'delete_cart']);

//CheckOut
Route::post('/checklogin',[CheckOutController::class,'check_login']);
Route::post('/save-checkout',[CheckOutController::class,'save_checkout']);
Route::get('/logout',[CheckOutController::class,'logout']);

Route::get('/login',[CheckOutController::class,'login_checkout']);
Route::get('/register-user',[CheckOutController::class,'register_user']);

Route::get('/checkout',[CheckOutController::class,'checkout']);
Route::get('/thank',[CheckOutController::class,'thank_you']);
Route::post('/add-user',[CheckOutController::class,'add_user']);

//Order
Route::get('/manager-order',[CheckOutController::class,'manager_order']);
Route::get('/view-order/{iddonhang}',[CheckOutController::class,'view_order']);
Route::get('/active-order/{iddonhang}',[CheckOutController::class,'active_order']);
Route::get('//unactive-orderuser/{iddonhang}',[CheckOutController::class,'unactive_orderuser']);

//forgot pass
Route::get('/resetpass',[ResetPassController::class,'show_reset'])->name('resetpass');;
Route::post('/resetpass',[ResetPassController::class,'activereset']);

//coupon
Route::get('/add-coupon',[CouponController::class,'add_coupon']);
Route::get('/all-coupon',[CouponController::class,'all_coupon']);
Route::post('/save-coupon',[CouponController::class,'save_coupon']);
Route::get('/unactive-coupon/{idma}',[CouponController::class,'unactive_coupon']);
Route::get('/active-coupon/{idma}',[CouponController::class,'active_coupon']);
Route::get('/delete-coupon/{idma}',[CouponController::class,'delete_coupon']);

//user
Route::get('/user/{iduser}',[UserController::class,'User'])->name('user.show');
Route::get('/order',[UserController::class,'order']);
Route::get('/password',[UserController::class,'Password']);
Route::get('/cancel-order/{iddonhang}',[UserController::class,'cancel_order']);
Route::post('/unactive-order/{iddonhang}',[UserController::class,'unactive_order']);

Route::post('/update-password', [UserController::class,'update_password']);
Route::post('/save-info/{iduser}',[UserController::class,'save_info']);


