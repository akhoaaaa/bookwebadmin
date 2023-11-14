<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;

session_start();

class ProductController extends Controller
{

    public function add_product(){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly')
        {
            $type = DB::table('theloai')->orderby('idtheloai','desc')->get();
            return view ('admin.add_product')->with('theloai',$type);
        }else{
            return Redirect::to('/admin');
        }

    }

    public function all_product()
    {
//        if (Session::has('id') && Session::get('chucnang')=== 'quanly') {
        if (Session::has('id')&& Session::get('chucnang') === 'quanly')
        {
            $allproduct = DB::table('sanpham')->join('theloai', 'theloai.idtheloai', '=', 'sanpham.idtheloai')
                ->orderby('sanpham.id', 'desc')->get();
            $manager_product = view('admin.all_product')->with('all_product', $allproduct);
            return view('admin_layout')->with('admin.all_product', $manager_product);
        } else {
            return Redirect::to('/admin');
        }
    }


    public function save_product(Request $request){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            $data = array();
        $data['tensp'] = $request->tensp;
        $data['tacgia'] = $request -> tacgia;
        $data['giasp'] = $request ->giasp;
        $get_image = $request-> file('hinhanh');

        $data['idtheloai'] = $request ->idtheloai;
        $data['mota'] = $request ->mota;
        $data['loai'] = $request->loai;
        $data['soluongtonkho'] = $request ->soluongtonkho;
        $data['status'] = $request ->status;


        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['hinhanh'] = $new_image;
            DB::table('sanpham')->insert($data);
            Session::put('message','thêm sản phẩm thành công');
            return Redirect::to('all-product');
        }
        $data['hinhanh'] = '';
        DB::table('sanpham')->insert($data);
        Session::put('message','thêm sản phẩm thành công');
        return Redirect::to('add-product');
        }else{
            return Redirect::to('/admin');
        }
    }
    public function unactive_product ($idproduct){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            DB::table('sanpham')-> where('id',$idproduct)->update(['status'=>0]);
            Session::put('message','Ẩn sản phẩm thành công');
            return Redirect::to('all-product');
        }else{
            return Redirect::to('/admin');
        }



    }
    public function active_product($idproduct){

        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            DB::table('sanpham')-> where('id',$idproduct)->update(['status'=>1]);
            Session::put('message','Mở sản phẩm thành công');
            return Redirect::to('all-product');
        }else{
            return Redirect::to('/admin');
        }

    }
    public function edit_product($idproduct){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            $type = DB::table('theloai')->orderby('idtheloai','desc')->get();
            $editproduct = DB::table('sanpham')->where('id', $idproduct)->get();
        $manager_product = view ('admin.edit_product') -> with('edit_product',$editproduct)->with('theloai',$type);
        return view ('admin_layout')->with('admin.edit_product', $manager_product);
        }else{
            return Redirect::to('/admin');
        }

    }
    public function update_product(Request $request,$idproduct){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
        $data = array();
        $data['tensp'] = $request->tensp;
        $data['tacgia'] = $request ->tacgia;
        $data['giasp'] = $request ->giasp;
        $data['mota'] = $request ->mota;
        $data['loai'] = $request->loai;
        $data['soluongtonkho'] = $request ->soluongtonkho;
        $data['idtheloai'] = $request ->idtheloai;
        $get_image = $request->file('hinhanh');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['hinhanh'] = $new_image;
            DB::table('sanpham')->where('id',$idproduct)->update($data);
            Session::put('message','cập nhật sản phẩm thành công');
            return Redirect::to('all-product');
        }
        DB::table('sanpham')->where('id',$idproduct)->update($data);
        Session::put('message','cập nhật sản phẩm thành công');
        return Redirect::to('all-product');
        }else{
            return Redirect::to('/admin');
        }

    }
    public function delete_product($idproduct){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            DB::table('sanpham')->where('id', $idproduct) ->delete();
        Session::put('message','Xóa sản phẩm thành công');
        return Redirect::to('all-product');
        }else{
            return Redirect::to('/admin');
        }
    }

    //end admin ------------------------------------------->>>>


    public function show_categoryhome_sach(){
        $cate_product = DB::table('danhmuc')->where('status','1')->orderby('id','desc')->get();
        $allproduct=DB::table('sanpham')->where('status','1')->where('loai',1)->orderby('id','desc')->get();
        return view('pages.category.show_category')->with('category',$cate_product)->with('allproduct',$allproduct);
    }
    public function show_categoryhome_truyen(){
        $allproduct=DB::table('sanpham')->where('status','1')->where('loai',2)->orderby('id','desc')->get();
        return view('pages.category.show_category') ->with('allproduct',$allproduct);
    }
    public function show_category(){
        $allproduct=DB::table('sanpham')->where('status','1')->orderby('id','desc')->get();
        return view('pages.category.show_category') ->with('allproduct',$allproduct);
    }

    public function detail_product($idproduct){
        $cate_product = DB::table('danhmuc')->where('status','1')->orderby('id','desc')->get();

        $detail_product=DB::table('sanpham')->join('theloai','theloai.idtheloai','=','sanpham.idtheloai')
            ->where('sanpham.id',$idproduct)->get();

        foreach ($detail_product as $key => $value){
            $type  = $value-> idtheloai;
        }
        $related_product=DB::table('sanpham')->join('theloai','theloai.idtheloai','=','sanpham.idtheloai')
            ->where('sanpham.idtheloai',$type)->whereNotIn('sanpham.id',[$idproduct])->limit(6)->get();
        return view('pages.product.show_detail')->with('category',$cate_product)->with('product_detail',$detail_product)->with('related',$related_product);
    }
}
