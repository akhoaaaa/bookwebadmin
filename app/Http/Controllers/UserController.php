<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Validator;

use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class UserController extends Controller
{
    public function User($iduser){
        if (Session::has('id')){

        $user = DB::table('user')->where('id',$iduser)->get();
        return view('pages.users.userpage')->with('user',$user);
        }

        else{
            return redirect('trang-chu');
        }
    }
    public function save_info(Request $request,$iduser){
        if (Session::has('id')){
            $data = array();

            $data['username'] = $request->username;
            $data['email'] = $request->email;
            $data['sdt'] = $request->sdt;
            DB::table('user')->where('id',$iduser)->update($data);

            return Redirect::route('user.show', ['iduser' => $iduser])->with('message','cập nhật thông tin thành công');
        }else{
            return Redirect::to('login');
        }
    }
    public function Password(){
        if (Session::has('id')){
            return view('pages.users.password');
        } else {
            return Redirect::to('login');
        }

    }
    public function update_password(Request $request)
    {
        if (Session::has('id')) {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ],[
                    'required' => 'Vui lòng nhập lại mật khẩu cũ',
                    'new_password' => [
                        'string' => 'Mật khẩu phải có ít nhất 6 kí tự',
                    ],
                    'same' => 'nhập lại mật khẩu trùng với mật khẩu mới',
                ]
            );
            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $oldPassword = $request->input('old_password');
            $newPassword = $request->input('new_password');
            $confirmPassword = $request->input('confirm_password');

            // Retrieve the user's hashed password from the database
            $user = DB::table('user')->where('id', Session::get('id'))->first();
            $userPasswordHash = $user->pass;

            if ($userPasswordHash == $oldPassword) {
                if ($newPassword === $confirmPassword) {
                    DB::table('user')->where('id', Session::get('id'))->update(['pass' => $newPassword]);
                    return Redirect::to('/password')->with('message', 'Đổi mật khẩu thành công');
                } else {
                    return Redirect::back()->with('error', 'Mật khẩu mới không khớp với nhập lại mật khẩu');
                }
            } else {
                return Redirect::back()->with('error', 'Mật khẩu cũ không đúng');
            }
        }
        return Redirect::to('login');
    }
    public function order(){
        if (Session::has('id')){
        $donhang = DB::table('donhang')
            ->join('chitietdonhang', 'donhang.id', '=', 'chitietdonhang.iddonhang')
            ->join('sanpham', 'chitietdonhang.idsp', '=', 'sanpham.id')
            ->join('user', 'donhang.iduser', '=', 'user.id')
            ->select('donhang.*', 'chitietdonhang.*', 'sanpham.tensp', 'sanpham.giasp')
            ->where('donhang.iduser', '=', Session::get('id'))
            ->orderBy('donhang.id', 'desc')
            ->get();

        foreach ($donhang as $order) {
            $items = DB::table('chitietdonhang')
                ->join('sanpham', 'sanpham.id', '=', 'chitietdonhang.idsp')
                ->select('sanpham.tensp', 'chitietdonhang.soluong', 'sanpham.giasp','sanpham.hinhanh')
                ->where('iddonhang', $order->iddonhang)
                ->get();
            $order->items = $items;
        }
        return view('pages.users.order', compact('donhang',));
        }
        else{
            return redirect('trang-chu');
        }
    }
    public function cancel_order($iddonhang){
        if (Session::has('id')){
            $order = DB::table('donhang')->where('id',$iddonhang)->first();
            if ($order->status==1){
                return view('pages.users.cancel-order')->with('order',$order);
            }else{
                return redirect('order');
            }
        }else{
            return redirect('trang-chu');
        }
    }
    public function unactive_order($iddonhang,Request $request){
        if (Session::has('id')){
            $order = DB::table('donhang')->where('id',$iddonhang)->first();
            if ($order && $order->status == 1){
                $cancel = $request->input('cancel');
                DB::table('donhang')->where('id', $iddonhang)->update(['cancel' => $cancel,'status'=>'2']);
                return redirect('order')->with('message', 'Hủy đơn hàng thành công');
            } else {
                return redirect('order');
            }
        }else{
            return redirect('trang-chu');
        }

    }
    public function all_user(){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            $user = DB::table('user')->where('chucnang', 'user')->get();
            return view('admin.all_user')->with('user', $user);
        }else{
            return Redirect::to('admin');
        }
    }
    public function delete_user($iduser){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            DB::table('user')->where('id', $iduser)->delete();
            Session::put('message', 'Xóa người dùng thành công');
            return Redirect::to('all-user');

        }
        else{
            return Redirect::to('admin');
        }

    }

}
