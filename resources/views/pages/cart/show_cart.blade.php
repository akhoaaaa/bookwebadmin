@extends('welcome')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                    <li class="active">Giỏ hàng của bạn</li>
                </ol>
            </div>
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{session()->get('message')}}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger">
                    {{session()->get('error')}}
                </div>
            @endif
            <div class="table-responsive cart_info" style="background: white;padding: 10px">
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
                        <td class="ca   rt_product">
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
                                <form action="{{ URL::to('/update-cart-quantity') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $v_content->rowId }}" name="rowId_cart" class="form-control">
                                    <div class="quantity-input">
                                        <button type="submit" class="quantity-btn minus" name="update_qty" value="minus">-</button>
                                        <input class="cart_quantity_input form-control" type="text" name="quantity_cart" value="{{ $v_content->qty }}" readonly>
                                        <button type="submit" class="quantity-btn plus" name="update_qty" value="plus">+</button>
                                    </div>
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


                    </tbody>
                    <tr>
                        <td>
                            <form action="{{ URL::to('/check-coupon') }}" method="post">
                                @csrf
                                <input type="text" class="form-control" name="coupon_code" placeholder="Mã giảm giá">
                                <br>
                                <input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính mã giảm giá">
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
    <!--/#cart_items-->


    <section id="do_action">
        <div class="container" style="background: white; padding: 20px; width: 75%">

                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            <li>Tổng <span>{{number_format(doubleval(str_replace([',',], '', $total)), 0, '.', ',') }} vnđ</span></li>

                                @if(session()->has('coupon'))
                                <li>
                                    @php
                                            $couponInfo = session('coupon');
                                            $couponCode = $couponInfo['coupon_code'];
                                            $dieukien = $couponInfo['dieukien'];
                                            $soluongma = $couponInfo['soluongma'];
                                            $tiengiam = $couponInfo['tiengiam'];

                                            // Assuming that $total contains the numeric value, strip off any 'vnđ' or other non-numeric characters.
                                            $total = preg_replace("/[^0-9.]/", "", $total);

                                            if (is_numeric($total) && is_numeric($tiengiam)) {
                                                if ($dieukien == 0) {
                                                    // Mã giảm giá theo phần trăm
                                                    $discountAmount = $total * $tiengiam / 100;
                                                } elseif ($dieukien == 1) {
                                                    // Mã giảm giá theo số tiền cố định
                                                    $discountAmount = $tiengiam;
                                                }
                                                // Tính tổng tiền sau khi áp dụng giảm giá
                                                $finalTotal = $total - $discountAmount;
                                            } else {
                                                // Xử lý lỗi nếu không phải là số
                                                $finalTotal = $total;
                                            }
                                    @endphp
                                    <div class="alert alert-success">
                                        <p>Mã giảm giá: {{ $couponCode }}</p>
                                        <p>@if ($dieukien == 0)
                                                Giảm: {{ number_format($tiengiam, 0, '.', '.') }} %
                                            @elseif ($dieukien == 1)
                                                Giảm: {{ number_format($tiengiam, 0, '.', '.') }} VND
                                            @endif </p>
                                    </div>
                                </li>
                                @endif


                            <li>Phí vận chuyển <span>Free</span></li>

                            @if(Session::has('coupon'))
                                @if($finalTotal < 0)
                                    <li>Thành Tiền <span>0 vnđ</span></li>
                                @else
                                    <li>Thành Tiền <span>{{ number_format($finalTotal, 0, '.', ',') }} vnđ</span></li>
                                @endif
                            @else
                                <li>Thành Tiền <span>{{ number_format(doubleval(str_replace([',',], '', $total)), 0, '.', ',') }} vnđ</span></li>
                            @endif

                        </ul>
                        <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">Thanh Toán</a>
                    </div>

                </div>
            </div>
        </div>
    </section><!--/#do_action-->


@endsection
