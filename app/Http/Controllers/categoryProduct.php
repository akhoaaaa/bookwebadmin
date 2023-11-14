<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class categoryProduct extends Controller
{



    //Start Admin
    public function add_category_product(){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly'){
         return view ('admin.add_category_product');
      }else{
         return Redirect::to('/admin');
      }

    }

    public function all_category_product(){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly'){
         $allcategory=DB::table('danhmuc') ->get();
        $manager_category = view ('admin.all_category_product') -> with('all_category_product',$allcategory);
        return view ('admin_layout')->with('admin.all_category_product', $manager_category);
      }else{
         return Redirect::to('/admin');

      }


    }
    public function save_category_product(Request $request){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
         $data = array();
        $data['tendanhmuc'] = $request->tendanhmuc;
        $data['hinhanh'] = $request ->hinhanh;
        $data['status'] = $request->status;


        echo '<pre>';
        print_r ($data);
        echo '</pre>';

        DB::table('danhmuc')->insert($data);
        Session::put('message','thêm danh mục thành công');
        return Redirect::to('all-category-product');
      }else{
         return Redirect::to('/admin');

      }


    }
    public function unactive_category ($iddanhmuc){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly')  {
         DB::table('danhmuc')-> where('id',$iddanhmuc)->update(['status'=>0]);
        Session::put('message','Ẩn danh mục thành công');
        return Redirect::to('all-category-product');
      }
      else{
         return Redirect::to('/admin');
      }



    }
    public function active_category($iddanhmuc){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
         DB::table('danhmuc')-> where('id',$iddanhmuc)->update(['status'=>1]);
        Session::put('message','Mở danh mục thành công');
        return Redirect::to('all-category-product');
      }else{
         return Redirect::to('/admin');

      }

    }
    public function edit_category_product($iddanhmuc){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly'){
         $editcategory = DB::table('danhmuc')->where('id', $iddanhmuc)->get();
        $manager_category = view ('admin.edit_category_product') -> with('edit_category_product',$editcategory);
        return view ('admin_layout')->with('admin.edit_category_product', $manager_category);
      }else{
         return Redirect::to('/admin');

      }

    }
    public function update_category_product(Request $request,$iddanhmuc){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly'){
         $data = array();
        $data['tendanhmuc'] = $request->tendanhmuc;
        $data['hinhanh'] = $request ->hinhanh;
        DB::table('danhmuc')->where('id', $iddanhmuc) ->update($data);
        Session::put('message','cập nhật thành công');
        return Redirect::to('all-category-product');
      }else{
         return Redirect::to('/admin');

      }

    }
    public function delete_category_product($iddanhmuc){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly'){
         DB::table('danhmuc')->where('id', $iddanhmuc) ->delete();
        Session::put('message','Xóa danh mục thành công');
        return Redirect::to('all-category-product');
      }else{
         return Redirect::to('/admin');

      }
    }
    //End Admin

    //Start UI


}
