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
        if (Session::has('id') && Session::get('chucnang') === 'quanly') {
            $tensp = $request->tensp;
            $tacgia = $request->tacgia;
            $giasp = $request->giasp;
            $idtheloai = $request->idtheloai;
            $mota = $request->mota;
            $loai = $request->loai;
            $soluongtonkho = $request->soluongtonkho;
            $status = $request->status;

            $get_image = $request->file('hinhanh');

            // Kiểm tra xem có ảnh được tải lên hay không
            if ($get_image) {
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move('public/uploads/product', $new_image);
            } else {
                // Nếu không có ảnh, đặt giá trị new_image là rỗng
                $new_image = '';
            }

            // Sử dụng parameter binding để tránh SQL injection
            DB::table('sanpham')->insert([
                'tensp' => $tensp,
                'tacgia' => $tacgia,
                'giasp' => $giasp,
                'idtheloai' => $idtheloai,
                'mota' => $mota,
                'loai' => $loai,
                'soluongtonkho' => $soluongtonkho,
                'status' => $status,
                'hinhanh' => $new_image,
            ]);

            Session::put('message', 'thêm sản phẩm thành công');
            return Redirect::to('all-product');
        } else {
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
            $tensp = $request->tensp;
            $tacgia = $request->tacgia;
            $giasp = $request->giasp;
            $idtheloai = $request->idtheloai;
            $mota = $request->mota;
            $loai = $request->loai;
            $soluongtonkho = $request->soluongtonkho;

            $get_image = $request->file('hinhanh');

            if ($get_image) {
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = pathinfo($get_name_image, PATHINFO_FILENAME);
                $new_image = $name_image . '_' . time() . '.' . $get_image->getClientOriginalExtension();
                $get_image->move('public/uploads/product', $new_image);
        }else{
            $new_image = $request->hinhanh;
        }
            $updateData = [
                'tensp' => $tensp,
                'tacgia' => $tacgia,
                'giasp' => $giasp,
                'idtheloai' => $idtheloai,
                'mota' => $mota,
                'loai' => $loai,
                'soluongtonkho' => $soluongtonkho,
            ];
            if ($get_image) {
                $updateData['hinhanh'] = $new_image;
            }

            DB::table('sanpham')
                ->where('id', $idproduct)
                ->update($updateData);
            Session::put('message','cập nhật sản phẩm thành công');
            return Redirect::to('all-product');
        }else{
            return Redirect::to('/admin');
        }

    }
    public function delete_product($idproduct){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            if (is_numeric($idproduct)) {
                DB::table('sanpham')->where('id', $idproduct)->delete();
                Session::put('message', 'Xóa sản phẩm thành công');
                return Redirect::to('all-product');
            } else {
                return Redirect::to('/admin')->with('error', 'ID sản phẩm không hợp lệ');
            }
        }else{
            return Redirect::to('/admin');
        }
    }

    //end admin ------------------------------------------->>>>


    public function show_categoryhome_sach(){
        $cate_product = DB::table('danhmuc')->where('status','1')->orderby('id','desc')->get();
        $allproduct=DB::table('sanpham')->where('status','1')->where('loai',1)->orderby('id','desc')->paginate(8);
        return view('pages.category.show_category')->with('category',$cate_product)->with('allproduct',$allproduct);
    }
    public function show_categoryhome_truyen(){
        $allproduct=DB::table('sanpham')->where('status','1')->where('loai',2)->orderby('id','desc')->paginate(8);
        return view('pages.category.show_category') ->with('allproduct',$allproduct);
    }
    public function show_category(){
        $allproduct=DB::table('sanpham')->where('status','1')->orderby('id','desc')->paginate(8);
        return view('pages.category.show_category') ->with('allproduct',$allproduct);
    }

    public function detail_product(Request $request){
        $idproduct = $request->route('idproduct');
        $cate_product = DB::table('danhmuc')->where('status', '1')->orderby('id', 'desc')->get();

        $detail_product = DB::table('sanpham')
            ->join('theloai', 'theloai.idtheloai', '=', 'sanpham.idtheloai')
            ->where('sanpham.id', '=', $idproduct)
            ->get();

        $type = null;
        foreach ($detail_product as $key => $value) {
            $type = $value->idtheloai;
        }

        if ($type !== null) {
            $comment = DB::table('comment')
                ->join('user', 'user.id', '=', 'comment.iduser')
                ->select('user.username', 'comment.*')
                ->where('comment.status', '1')
                ->where('idsp', $idproduct)
                ->orderby('id','desc')
                ->paginate(5);

            $commentIds = $comment->pluck('id')->toArray(); // Extract comment IDs

            if (!empty($commentIds)) {
                $reply = DB::table('replycomment')
                    ->join('user', 'user.id', '=', 'replycomment.iduser')
                    ->select('replycomment.comment_reply', 'user.username', 'replycomment.create_time', 'replycomment.idcomment')
                    ->whereIn('idcomment', $commentIds)
                    ->get();

                // Group replies by comment ID for easier association
                $groupedReplies = $reply->groupBy('idcomment');

                foreach ($comment as $singleComment) {
                    // Assign replies to each comment
                    $singleComment->replies = $groupedReplies[$singleComment->id] ?? [];
                }
            } else {
                // No comments found
                $reply = null;
            }
            $related_product = DB::table('sanpham')->join('theloai', 'theloai.idtheloai', '=', 'sanpham.idtheloai')
                ->where('sanpham.idtheloai', $type)->whereNotIn('sanpham.id', [$idproduct])->limit(6)->get();

            return view('pages.product.show_detail')
                ->with('category', $cate_product)
                ->with('product_detail', $detail_product)
                ->with('related', $related_product)
                ->with('comment', $comment)
                ->with('reply', $reply)
                ->with('i',(request()->input('page',1)-1)*5);
        } else {
            // No product found
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm.');
        }
    }
    public function detail_productadmin($idproduct){
        $detail_pro = DB::table('sanpham')->join('theloai','theloai.idtheloai','=','sanpham.idtheloai')
            ->select('theloai.tentheloai','sanpham.*')->where('id',$idproduct)->get();

        return view('admin.detail_productadmin')->with('detail_pro',$detail_pro);
    }
}
