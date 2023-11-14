<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use DB;

use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CartController extends Controller
{
    public function save_cart(Request $request)
    {
        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $info = DB::table('sanpham')->where('id', $productId)->first();
//        Cart::add('293ad', 'Product 1', 1, 9.99, 550);
//        Cart::destroy();
        $data['id'] = $info->id;
        $data['qty'] = $quantity;
        $data['name'] = $info->tensp;
        $data['price'] = $info->giasp;
        $data['weight'] = '123';

        $data['options']['hinhanh'] = $info->hinhanh;
        Cart::add($data);
//        Cart::destroy();
        return Redirect::to('/show-cart');
    }

    public function show_cart()
    {
        if (Session::has('id')) {
            $finalTotal = 0;
            $cartItems = Cart::content();
            $total = Cart::subtotal();

            return view('pages.cart.show_cart', compact('cartItems', 'total','finalTotal'));
        } else {
            return redirect()->to('/login');
        }
    }

    public function delete_cart($rowId)
    {
        Cart::remove($rowId);
        return redirect('/show-cart');
    }

    public function update_cart_quantity(Request $request)
    {
        $rowId = $request->rowId_cart;
        $qty = $request->quantity_cart;

        $cartItem = Cart::get($rowId);

        if ($cartItem) {
            // Lấy thông tin sản phẩm từ cơ sở dữ liệu dựa trên id sản phẩm
            $product = DB::table('sanpham')->where('id', $cartItem->id)->first();

            if ($request->update_qty == 'plus') {
                // Tăng số lượng
                $qty += 1;
            } elseif ($request->update_qty == 'minus') {
                // Giảm số lượng, nhưng không thấp hơn 1
                $qty = max(1, $qty - 1);
            }

            // Kiểm tra số lượng cập nhật không được lớn hơn soluongtonkho
            if ($product && $qty <= $product->soluongtonkho) {
                Cart::update($rowId, $qty);
            }
        }

        return Redirect::to('/show-cart');
    }

    public function check_coupon(Request $request)
    {
        $iduser = Session::get('id');
        $coupon_code = $request->input('coupon_code');

        $coupon = DB::table('coupon')
            ->where('coupon_code', $coupon_code)
            ->where('status', 1)
            ->first();

        if ($coupon) {
            // Kiểm tra xem mã giảm giá có hợp lệ theo điều kiện nào đó
            // Ví dụ: Kiểm tra số lượng mã giảm giá còn lại, điều kiện, và tiền giảm
            $donhangs = DB::table('donhang')->where('iduser', $iduser)->get();
            $couponUsed = false;

            foreach ($donhangs as $donhang) {
                if ($donhang->idcoupon == $coupon->idma) {
                    $couponUsed = true;
                    break;
                }
            }
            $count_coupon = $coupon->soluongma;
            if ($couponUsed) {
                return redirect()->back()->with('error', 'Bạn đã sử dụng mã giảm giá này trong đơn hàng trước đó');
            }


            if ($count_coupon > 0) {
                // Lấy thông tin của mã giảm giá
                $couponInfo = [
                    'idma' => $coupon->idma,
                    'coupon_code' => $coupon->coupon_code,
                    'dieukien' => $coupon->dieukien,
                    'soluongma' => $count_coupon,
                    'tiengiam' => $coupon->tiengiam,
                ];

                // Lưu thông tin mã giảm giá vào session "coupon"
                Session::put('coupon', $couponInfo);
                Session::save();

                return redirect()->back()->with('message', 'Đã sử dụng mã giảm giá thành công');
            } else {
                return redirect()->back()->with('error', 'Mã giảm giá đã hết lượt sử dụng');
            }
        } else {
            Session::forget('coupon');
            return redirect()->back()->with('error', 'Mã giảm giá không tồn tại hoặc không hợp lệ');
        }
    }

}
