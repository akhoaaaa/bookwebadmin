@extends('welcome')
@section('content')
    <div class="col-sm-4">
        <div class="profile-menu">
            <ul>
                <li><a href="{{URL::to('/user/'.Session::get('id'))}}" ><i class="fa fa-user"> </i> Hồ Sơ</a></li>
                <li><a href="{{URL::to('/password')}}"><i class="fa fa-lock"></i> Đổi Mật Khẩu</a></li>
                <li><a href="{{URL::to('/address')}}"><i class="fa fa-map-marker"></i> Địa Chỉ</a></li>
                <li><a href="{{URL::to('/order')}}"><i class="fa fa-shopping-cart"></i>Đơn Mua</a></li>
            </ul>
        </div>
    </div>

    <div class="col-sm-4" style="background: white;margin-bottom: 25px;margin-top: 25px;width: 60%;">
        <div class="info-title">
            <h1 class="Sb123">Chi Tiết Đơn Hàng</h1>
            <div class="x2">
                <p>Thông tin chi tiết về đơn hàng mà bạn đã đặt</p>
            </div>
        </div>

        @php
            $previousOrderID = null;
        @endphp
        @foreach ($donhang as $order)
            @if ($order->iddonhang !== $previousOrderID)
                @php
                    $previousOrderID = $order->iddonhang;
                @endphp
                <div class="form-group" style="border: 1px solid #000; padding: 10px;">
                    <div class="form-control" style="display: flex; justify-content: space-between;">
                        <p style="color: red; font-weight: bold">Đơn hàng: {{$order->iddonhang }}</p>
                        @if($order->status == 0)
                            <p style="">Tình Trạng Đơn Hàng: Đang Xử Lý</p>
                        @elseif($order->status ==1)
                            <p style="">Tình Trạng Đơn Hàng: Đã Duyệt Đơn
                        @elseif($order->status == 2)
                            @if(is_numeric($order->cancel))
                                @if($order->cancel ==5)
                                        <p style="font-weight: bold;color: #FDF66A" >Tình Trạng Đơn Hàng: Đơn Hàng Đã Bị Hủy </p>
                                @else
                                    <p style="font-style: italic">Tình Trạng Đơn Hàng: chờ duyệt hủy đơn hàng</p>
                                @endif
                                @endif
                        @elseif($order->status == 3)
                            <p>Đang Giao Hàng</p>
                        @endif
                    </div>
                    @foreach ($order->items as $item)
                        <div class="form-group" style="display: flex;">
                            <img src="{{URL::to('public/uploads/product/'.$item->hinhanh)}}" height="40px" width="5%" style="margin:10px;">
                            <div class="order-message" style="display: block; text-align: left;">
                                <p style="font-size: 15px; margin-top: 5px">Tên Sản Phẩm: {{ $item->tensp }}</p>
                                <p style="font-size: 15px">Số Lượng: {{ $item->soluong }}</p>
                                <p style="font-size: 15px">Giá Sản Phẩm: {{ $item->giasp }}</p>
                            </div>
                        </div>
                    @endforeach
                    <div class="end-order" style="display: flex; justify-content: space-between;">
                        <p style="font-size: 20px; font-weight: bold">Tổng Tiền Đơn Hàng: {{$order->tongtien}} </p>
                        <p style="margin-top: 10px; font-weight: bold">Địa Chỉ Nhận Hàng: {{$order->diachi}}</p>
                    </div>
                    @if($order->status==1)
                    <a href ="{{ URL::to('/cancel-order/'.$order->id)}}" style="text-align: left;display: block;width: 15%">Hủy Đơn Hàng</a>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
@endsection
