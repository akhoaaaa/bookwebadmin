<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Cart;
use App\Rules\Captcha;
use Validator;
use DB;
use Session;
use PDF;
use Illuminate\Support\Facades\Redirect;

session_start();

class CheckOutController extends Controller
{
    public function login_checkout(){
        return view('pages.users.login');
    }
    public function check_login(Request $request){
        $data = $request->validate([
           'email' =>   'required',
           'pass' =>   'required',
        ]);
        $email = $request -> email;
        $pass = $request -> pass;

        $result = DB::table('user') -> where('email',$email) -> where('pass',$pass)->first();
        if ($result) {
            Session::put('username',$result -> username);
            Session::put('email',$result -> email);
            Session::put('sdt',$result -> sdt);


            Session::put('id',$result -> id);
            return Redirect::to('/trang-chu');
        }else{
            Session::put('message','mật khẩu hoặc email không chính xác');
            return Redirect::to('/login');
        }
        return view('pages.users.login');
    }
    public function register_user(){
        return view('pages.users.register');
    }
    public function add_user(Request $request){

        $request->validate([
            'email' => 'required|email|unique:user,email',
            'pass' => 'required|min:6',
            'repass' => 'required|same:pass',
            'sdt' => ['required', 'string', function ($attribute, $value, $fail) {
                // Kiểm tra số điện thoại ở đây
                if (!preg_match('/^(0[19][0-9]{8})$/', $value)) {
                    $fail('Số điện thoại không hợp lệ');
                }
            }],
            'g-recaptcha-response' => new Captcha(),
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'pass.required' => 'Vui lòng nhập mật khẩu.',
            'pass.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'repass.required' => 'Vui lòng nhập mật khẩu.',
            'repass.same' => 'Mật khẩu nhập lại không khớp với mật khẩu bạn tạo.',
            'sdt.required' => 'Vui lòng nhập số điện thoại.',
            'sdt.regex' => 'Số điện thoại không hợp lệ.',
            'g-recaptcha-response.required' => 'Vui lòng xác thực captcha.',
        ]);

// Nếu kiểm tra validation thành công, bạn có thể thêm người dùng
        $data = [
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'pass' => $request->input('pass'),
            'sdt' => $request->input('sdt'),
            'chucnang' => $request->input('chucnang'),
        ];

        $id = DB::table('user')->insertGetId($data);
        return redirect('login')->with('message','tạo tài khoản thành công, vui lòng đăng nhập');
    }
    public function checkout(){
        if (Session::has('id')){
            $donhang = DB::table('donhang')->join('chitietdonhang', 'donhang.id', '=', 'chitietdonhang.iddonhang')
                ->join('sanpham', 'chitietdonhang.idsp', '=', 'sanpham.id')
                ->select('donhang.*', 'chitietdonhang.*', 'sanpham.tensp', 'sanpham.giasp')
                ->where('donhang.iduser', '=', Session::get('id'))
                ->get();
            return view('pages.checkout.checkout',compact('donhang'));
    }else{
            return Redirect::to('login');
        }
    }
    public function save_checkout(Request $request)
    {
        $totalPrice = doubleval(str_replace([',',], '', Cart::subtotal()));
        $discountAmount = 0;
        $idcoupon = 0;
// Kiểm tra nếu có mã giảm giá trong session
        if (Session()->has('coupon')) {
            $couponInfo = Session('coupon');
            $idma = $couponInfo['idma'];
            $dieukien = $couponInfo['dieukien'];
            $tiengiam = $couponInfo['tiengiam'];
            $soluongma = $couponInfo['soluongma'];

            if (is_numeric($totalPrice) && is_numeric($tiengiam)) {
                if ($dieukien == 0) {
                    // Mã giảm giá theo phần trăm
                    $discountAmount = ($totalPrice * $tiengiam) / 100;
                } elseif ($dieukien == 1) {
                    // Mã giảm giá theo số tiền cố định
                    $discountAmount = $tiengiam;
                }

                // Trừ mã giảm giá khỏi tổng tiền
                $totalPrice -= $discountAmount;

                // Đảm bảo rằng tổng tiền không nhỏ hơn 0
                if ($totalPrice < 0) {
                    $totalPrice = 0;
                }
            }
            if ($totalPrice<0){
                $totalPrice = 0;
            }
            if ($soluongma > 0) {
                $newCouponQuantity = $soluongma - 1;
                DB::table('coupon')->where('idma', $idma)->update([
                    'soluongma' => $newCouponQuantity,
                ]);
                $idcoupon = $idma;
            }
        }
        $totalPriceNumeric = doubleval(str_replace([',', '.'], '', $totalPrice));
        // Tiếp theo, bạn có thể thêm các xử lý khác như lấy thông tin địa chỉ, giao dịch và cập nhật cơ sở dữ liệu.

        // Bắt đầu một giao dịch
        DB::beginTransaction();

        try {
            // Tạo và lưu đơn hàng mới
            $orderId = DB::table('donhang')->insertGetId([
                'iduser' => Session::get('id'), // Lấy iduser từ phiên đăng nhập
                'diachi' => $request->input('diachi'),
                'soluong' => 0, // Tạo số lượng
                'tongtien' => 0, // Tạo tổng tiền update sau
                'sdt' => $request->input('sdt'),
                'email' => $request->input('email'),
                'payment' => $request->input('payment'),
                'status' => 0,
                'idcoupon' => $idcoupon,
                'note'=> $request->input('note'),
            ]);

            // Lặp qua từng sản phẩm trong giỏ hàng và lưu chi tiết đơn hàng
            $cartItems = Cart::content();
            if ($cartItems->isEmpty()) {
                return redirect('/checkout')->with('error', 'Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.');
            }
            foreach ($cartItems as $cartItem) {
                $product = DB::table('sanpham')->where('id', $cartItem->id)->first();
                if ($product) {
                    if ($cartItem->qty <= $product->soluongtonkho) {
                        // Lưu chi tiết đơn hàng
                        DB::table('chitietdonhang')->insert([
                            'iddonhang' => $orderId,
                            'idsp' => $product->id,
                            'soluong' => $cartItem->qty,
                            'giasp' => $product->giasp,
                        ]);

                        // Cập nhật soluongtonkho
                        $newStock = $product->soluongtonkho - $cartItem->qty;
                        DB::table('sanpham')->where('id', $product->id)->update([
                            'soluongtonkho' => $newStock,
                        ]);
                    } else {
                        // Xử lý khi `soluongtonkho` không đủ
                        DB::rollBack();
                        return redirect('/checkout')->with('error', 'Sản phẩm "' . $product->tensp . '" đã hết hàng hoặc số lượng không đủ.');
                    }
                }
            }

            // Cập nhật tổng số lượng và tổng tiền trong đơn hàng
            $totalQuantity = DB::table('chitietdonhang')->where('iddonhang', $orderId)->sum('soluong');

            // Cập nhật đơn hàng với tổng số lượng và tổng tiền
            DB::table('donhang')->where('id', $orderId)->update([
                'soluong' => $totalQuantity,
                'tongtien' => $totalPriceNumeric,
            ]);

            // Hoàn thành giao dịch
            DB::commit();

            // Xóa giỏ hàng
            Cart::destroy();

            //xóa session coupon
            Session::forget('coupon');


            // Điều hướng hoặc hiển thị thông báo thành công
            $orderNumber = $orderId;
            return redirect('/thank');
        } catch (\Exception $e) {
            // Nếu có lỗi xảy ra, rollback giao dịch
            DB::rollBack();
            \Log::error('Lỗi xảy ra: ' . $e->getMessage());

            // Xử lý lỗi và điều hướng hoặc hiển thị thông báo lỗi
            return redirect('/checkout')->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }
    public function thank_you(){
        return view('pages.checkout.thank');

    }
    public function logout(){
        Session::flush();
        return redirect('/trang-chu');
    }
    public function manager_order()
    {
        if (Session::has('id')&& Session::get('chucnang') === 'quanly') {
            $allorder = DB::table('donhang')->join('user', 'user.id', '=', 'donhang.iduser')
                ->select('donhang.*', 'user.username')
                ->orderby('donhang.id', 'desc')->get();
            $manager_order = view('admin.manager_order')->with('all_order', $allorder);
            return view('admin_layout')->with('admin.manager_order', $manager_order);
        }else{
            return Redirect::to('admin');
        }
    }
    public function view_order($iddonhang){
        if (Session::has('id')&& Session::get('chucnang') === 'quanly')
        {
            $orderbyid = DB::table('chitietdonhang')
                ->join('donhang', 'donhang.id', '=', 'chitietdonhang.iddonhang')
                ->join('sanpham', 'sanpham.id', '=', 'chitietdonhang.idsp')
                ->join('user', 'user.id', '=', 'donhang.iduser')
                ->leftJoin('coupon', 'donhang.idcoupon', '=', 'coupon.idma')
                ->select('chitietdonhang.soluong', 'sanpham.tensp', 'sanpham.giasp', 'user.*','coupon.*','donhang.tongtien')
                ->where('iddonhang', $iddonhang)
                ->get();
            $userInfo = DB::table('donhang')
                ->join('user', 'user.id', '=', 'donhang.iduser')
                ->select('user.username', 'donhang.diachi', 'user.email', 'user.sdt','donhang.tongtien','donhang.payment','donhang.note','donhang.id','donhang.status','donhang.cancel')
                ->where('donhang.id', $iddonhang)
                ->first();

            return view('admin.view_order', ['orderbyid' => $orderbyid, 'userinfo' => $userInfo, 'iddonhang' => $iddonhang]);
        }else{
            return Redirect::to('admin');
        }
    }

    public function active_order($iddonhang){
        $order = DB::table('donhang')->where('id',$iddonhang)->first();
        if ($order->status==0){
            DB::table('donhang')->where('id', $iddonhang)->update(['status' => 1]);
            return redirect('manager-order')->with('message','Duyệt Đơn Thành Công');
        }
        else{
            return redirect('manager-order');
        }
    }
    public function unactive_orderuser($iddonhang){
        if (Session::has('id')){
            $orderDetails = DB::table('chitietdonhang')->where('iddonhang', $iddonhang)->get();
            $order = DB::table('donhang')->where('id',$iddonhang)->first();
            if ($order->status==2){
                foreach ($orderDetails as $orderDetail) {
                    $productId = $orderDetail->idsp;
                    $quantityOrdered = $orderDetail->soluong;

                    // Lấy thông tin sản phẩm từ bảng sanpham
                    $product = DB::table('sanpham')->where('id', $productId)->first();
                    $currentStock = $product->soluongtonkho;

                    // Cập nhật lại số lượng tồn kho của sản phẩm
                    $newStock = $currentStock + $quantityOrdered;
                    DB::table('sanpham')->where('id', $productId)->update(['soluongtonkho' => $newStock]);
                }
                DB::table('donhang')->where('id',$iddonhang)->update(['cancel'=>5]);
                return redirect('manager-order')->with('message','Đã Hủy Đơn Hàng');
            }else{
                return redirect('manager-order');
            }
        }else{
            return Redirect::to('manager-order');
        }
    }


}
