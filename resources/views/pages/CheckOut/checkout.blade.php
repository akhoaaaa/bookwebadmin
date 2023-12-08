@extends('welcome')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/trang-chu')}}">Trang Chủ</a></li>
                    <li class="active">Thanh Toán</li>
                </ol>
            </div><!--/breadcrums-->

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if(session::has('id'))
                <p></p>

                @else
                <div class="register-req">
                    <p>Vui lòng đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lịch sử đơn hàng</p>
                </div>
            <!--/register-req-->
            @endif

            <div class="shopper-informations">
                <div class="row" style="background: white; padding: 10px;">

                    <div class="col-sm-3">

                        <div class="shopper-info">
                            <p>Điền thông tin đặt hàng</p>
                            <form action="{{URL::to('/save-checkout')}}" method="POST">

                            {{csrf_field()}}
                                <input type="text" name="email" placeholder="Email" value="{{session('email')}}" readonly>
                                <input type="text" name="username" placeholder="Họ và tên" value="{{session('username')}}" readonly>
                                <input type="text" name="sdt" placeholder="Phone" value="{{session('sdt')}}" readonly>
                                <input type="text" name="diachi" placeholder="Địa chỉ nhận hàng">
                                <button type="submit" class="btn btn-primary btn-sm">Xác nhận đặt hàng</button>
                                <div class="payment-options" style="margin-top: 20px">
                                    <h4 class="mb-3">Vui lòng chọn phương thức thanh toán</h4>
                                    <div class="d-block my-3">
                                        <div class="custom-control custom-radio">
                                            <input id="cod" name="payment" type="radio" class="custom-control-input" value="0">
                                            <label class="custom-control-label" for="cod">Thanh toán khi nhận hàng</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input id="momo" name="payment" type="radio" class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="momo" name="payUrl">Thanh Toán Qua Momo</label>
                                        </div>

{{--                                        <div class="custom-control custom-radio">--}}
{{--                                            <input id="paymentZaloPay" name="payment" type="radio" class="custom-control-input" value="2">--}}
{{--                                            <label class="custom-control-label" for="paymentZaloPay"></label>--}}
{{--                                        </div>--}}
                                    </div>
                                </div>

                        </div>
                    </div>
                                    <div class="col-sm-4">
                                        <div class="order-message">
                                            <p>Ghi chú</p>
                                            <textarea name="note" placeholder="Ghi chú đơn hàng của bạn" rows="16"></textarea>
                                        </div>
                                    </div>
                    </form>
                </div>
            </div>

            <div class="review-payment">
                <h2>Xem lại giỏ hàng</h2>
            </div>

            <div class="table-responsive cart_info" style="padding: 10px;background: white; width: 100%">
                <?php
                $content = Cart::content();
                ?>
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image"></td>
                        <td class="description">Tên Sản Phẩm</td>
                        <td class="price">Giá Sản Phẩm</td>
                        <td class="quantity">Số Lượng</td>
                        <td class="total">Tổng Tiền</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($content as $v_content)
                        <tr>
                            <td class="cart_product">
                                <a href=""><img src="{{URL::to('public/uploads/product/'.$v_content->options->hinhanh)}}" alt="" height="55" width="40"/></a>
                            </td>
                            <td class="cart_description">
                                <h4><a href="">{{$v_content->name}}</a></h4>
                                <p>Web ID: 1089772</p>
                            </td>
                            <td class="cart_price">
                                <p>{{number_format($v_content->price)}} VNĐ</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                        {{csrf_field()}}
                                        <input class="cart_quantity_input" type="text" name="quantity_cart" value="{{$v_content->qty}}" size="2">
                                        <input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-control">
                                        <input type="submit" value="update" name="update_qty" class="btn btn-default btn-sm">
                                    </form>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">
                                        <?php
                                        $subtotal = $v_content->price * $v_content->qty;
                                        echo number_format($subtotal).' '.'vnđ';
                                        ?>
                                </p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" href="{{URL::to('/delete-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    @if(session()->has('coupon'))
                        @php
                            $coupon = session('coupon');
                            $tiengiam = $coupon['tiengiam'];
                            $dieukien = $coupon['dieukien'];

                            if ($dieukien == 0) {
                                // Mã giảm giá theo phần trăm
                                $discountAmount = ($subtotal * $tiengiam) / 100;
                            } elseif ($dieukien == 1) {
                                // Mã giảm giá theo số tiền cố định
                                $discountAmount = $tiengiam;
                            }

                            // Tính tổng tiền sau khi áp dụng giảm giá
                            $finalTotal = $subtotal - $discountAmount;
                        @endphp
                        <div class="alert alert-success">
                            <p>Mã giảm giá: {{ $coupon['coupon_code'] }}</p>
                            @if ($dieukien == 0)
                                <p>Giảm Giá: {{ $tiengiam }} %</p>
                            @else
                                <p>Giảm Giá: {{ $tiengiam }} vnđ</p>
                            @endif
                        </div>
                        @if(Session::has('coupon'))
                            @if($finalTotal < 0)
                                <h3 style="margin-left: 10px; color: red">Tổng Tiền: <span>0 vnđ</span></h3>
                            @else
                                <h3 style="margin-left: 10px; color: red">Tổng Tiền: <span>{{ number_format($finalTotal, 0, '.', ',') }} vnđ</span></h3>
                            @endif
                        @else
                            <h3 style="margin-left: 10px; color: red">Tổng Tiền: <span>{{ number_format(doubleval(str_replace([',',], '', $total)), 0, '.', ',') }} vnđ</span></h3>
                        @endif
                    @else
                        <p></p>
                    @endif
                    <p></p>


                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->

@endsection
