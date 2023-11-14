<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CouponController extends Controller
{
    public function all_coupon(){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            $allcoupon=DB::table('coupon')->orderby('idma','desc') ->get();
            $manager_coupon = view ('admin.all_coupon') -> with('allcoupon',$allcoupon);
            return view ('admin_layout')->with('admin.all_coupon', $manager_coupon);
        }else{
            return Redirect::to('/admin');

        }
    }
    public function add_coupon(){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            $coupon = DB::table('coupon')->get();
            return view ('admin.add_coupon');
        }else{
            return Redirect::to('/admin');
        }
    }
    public function save_coupon(Request $request){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            $data = array();
            $data['tenma'] = $request->tenma;
            $coupon = Str::random(6);
            $data['coupon_code'] = $coupon;
            $data['soluongma'] = $request -> soluongma;
            $data['dieukien'] = $request ->dieukien;
            $data['status'] = $request ->status;
            $data['tiengiam'] = $request ->tiengiam;
            DB::table('coupon')->insert($data);
            Session::put('message','thêm mã thành công');
            return Redirect::to('all-coupon');
        }else{
            return Redirect::to('/admin');
        }

    }
    public function unactive_coupon ($idma){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            DB::table('coupon')-> where('idma',$idma)->update(['status'=>0]);
            Session::put('message','Đóng mã giảm giá thành công');
            return Redirect::to('all-coupon');
        }else{
            return Redirect::to('/admin');
        }
    }
    public function active_coupon($idma){

        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            DB::table('coupon')-> where('idma',$idma)->update(['status'=>1]);
            Session::put('message','Mã giảm giá có thể sử dụng');
            return Redirect::to('all-coupon');
        }else{
            return Redirect::to('/admin');
        }
    }
    public function delete_coupon($idma){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            DB::table('coupon')->where('idma', $idma) ->delete();
            Session::put('message','Xóa mã thành công');
            return Redirect::to('all-coupon');
        }else{
            return Redirect::to('/admin');
        }
    }


}
