<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class TheLoaiProduct extends Controller
{
    public function add_type(){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            return view ('admin.add_type');
        }else{
            return Redirect::to('/admin');
        }

    }

    public function all_type(){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            $alltype=DB::table('theloai') ->get();
            $manager_category = view ('admin.all_type') -> with('alltype',$alltype);
            return view ('admin_layout')->with('admin.all_type', $manager_category);
        }else{
            return Redirect::to('/admin');

        }


    }
    public function save_type(Request $request){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            $data = array();
            $data['idloai'] = $request->idloai;
            $data['tentheloai'] = $request ->tentheloai;


            DB::table('theloai')->insert($data);
            Session::put('message','thêm thể loại thành công');
            return Redirect::to('all-type');
        }else{
            return Redirect::to('/admin');

        }


    }
//    public function unactive_type ($idloai){
//        if (Session::has('id') ) {
//            DB::table('theloai')-> where('idloai',$iddanhmuc)->update(['status'=>0]);
//            Session::put('message','Ẩn danh mục thành công');
//            return Redirect::to('all-category-product');
//        }
//        else{
//            return Redirect::to('/admin');
//        }
//
//
//
//    }
//    public function active_type($idloai){
//        if (Session::has('id')) {
//            DB::table('danhmuc')-> where('id',$iddanhmuc)->update(['status'=>1]);
//            Session::put('message','Mở danh mục thành công');
//            return Redirect::to('all-category-product');
//        }else{
//            return Redirect::to('/admin');
//
//        }
//
//    }
    public function edit_type($idtheloai){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            $edittype = DB::table('theloai')->where('idtheloai', $idtheloai)->get();
            $manager_type = view ('admin.edit_type') -> with('edit_type',$edittype);
            return view ('admin_layout')->with('admin.edit_type', $manager_type);
        }else{
            return Redirect::to('/admin');

        }

    }
    public function update_type(Request $request,$idtheloai){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            $data = array();
            $data['idloai'] = $request->idloai;
            $data['tentheloai'] = $request ->tentheloai;
            DB::table('theloai')->where('idtheloai', $idtheloai) ->update($data);
            Session::put('message','cập nhật thành công');
            return Redirect::to('all-type');
        }else{
            return Redirect::to('/admin');

        }

    }
    public function delete_type($idtheloai){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            DB::table('theloai')->where('idtheloai', $idtheloai) ->delete();
            Session::put('message','Xóa danh mục thành công');
            return Redirect::to('all-type');
        }else{
            return Redirect::to('/admin');

        }
    }
    //
}
