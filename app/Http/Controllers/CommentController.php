<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    //
    public function upload_comment($productid, Request $request){
        if (Session::has('id')) {
            $iduser = Session::get('id');
            $idsp = $productid;
            $newCommentContent = $request->input('comment');

            $existingComment = DB::table('comment')
                ->where('idsp', $idsp)
                ->where('iduser', $iduser)
                ->where('status', '0')
                ->first();
            if ($existingComment) {
                return Redirect::to('chitiet-sanpham/'.$productid)->with('error', 'Bạn đã gửi một bình luận chưa được duyệt. Vui lòng chờ duyệt trước khi thêm bình luận mới.');
            }
            if ($newCommentContent) {
                $data = [
                    'idsp' => $idsp,
                    'iduser' => $iduser,
                    'comment' => $newCommentContent,
                    'status' => '0'
                ];

                DB::table('comment')->insert($data);

                return Redirect::to('chitiet-sanpham/'.$productid)->with('message', 'Bình luận của bạn đã được gửi vui lòng chờ duyệt');
            } else {
                return Redirect::to('chitiet-sanpham/'.$productid)->with('error', 'Vui lòng nhập nội dung bình luận.');
            }
        } else {
            return Redirect::to('trang-chu')->with('error', 'Bạn cần đăng nhập để bình luận.');
        }
    }

    public function all_comment(){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {

            $allcomment = DB::table('comment')
                ->join('sanpham', 'sanpham.id', '=', 'comment.idsp')
                ->join('user', 'user.id', '=', 'comment.iduser')
                ->select('comment.*', 'sanpham.tensp', 'user.username')
                ->orderby('comment.id', 'desc')->get();
            $manager_view = view('admin.all_comment')->with('all_comment', $allcomment);
            return view('admin_layout')->with('admin.all_comment', $manager_view);
        }else{
            return Redirect::to('/admin');
        }
    }
    public function unactive_comment($idcomment){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            DB::table('comment')-> where('id',$idcomment)->update(['status'=>0]);
            Session::put('message','Ẩn bình luận thành công');
            return Redirect::to('all-comment');
        }else{
            return Redirect::to('/admin');
        }

    }
    public function active_comment($idcomment){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            DB::table('comment')-> where('id',$idcomment)->update(['status'=>1]);
            Session::put('message','Hiển thị bình luận thành công');
            return Redirect::to('all-comment');
        }else{
            return Redirect::to('/admin');
        }
    }
    public function reply_comment($idcomment,Request $request){
        if (Session::has('id') && Session::get('chucnang')==='quanly'){
            $iduser = Session::get('id');
            $replycomment = $request->input('comment_reply');
            if ($replycomment){
                DB::table('replycomment')->insert([
                    'idcomment' => $idcomment,
                    'iduser' => $iduser,
                    'comment_reply' => $request->input('comment_reply'),
                ]);
                return redirect()->back()->with('message', 'Reply comment thành công!');
            }
            else{
                return redirect()->back()->with('error', 'Vui nhập câu trả lời');
            }
        }else{
            return Redirect::to('trang-chu');
        }
    }
}
