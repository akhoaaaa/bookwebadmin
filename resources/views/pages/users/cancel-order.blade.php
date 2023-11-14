@extends('welcome')
@section('content')
    <div class="col-sm-4">
        <div class="profile-menu">
            <ul>
                <li><a href="{{URL::to('/user/'.Session::get('id'))}}" ><i class="fa fa-user"> </i> Hồ Sơ</a></li>
                <li><a href="{{URL::to('/password')}}"><i class="fa fa-lock"></i> Đổi Mật Khẩu</a></li>
                <li><a href="{{URL::to('/address')}}"><i class="fa fa-map-marker"></i> Địa Chỉ</a></li>
                <li><a href="{{URL::to('/order')}}"><i class="fa fa-shopping-cart"></i> Đơn Mua</a></li>
            </ul>
        </div>
    </div>

    <div class="col-sm-4" style="background: white;margin-bottom: 25px;margin-top: 25px;width: 60%;">
        <div class="info-title" style="height: 200px">
            <h1 class="Sb123">Bạn Muốn Hủy Đơn Hàng ?</h1>
            <form method="POST" action="{{ URL::to('/unactive-order/'.$order->id) }}">
                {{csrf_field()}}

                <div class="x2">
                <p>Vui Lòng Chọn Lý Do Hủy Đơn Hàng</p>
                <select id="cancel" name="cancel" style="background: #F5F5F5">
                    <option value="0">Sản phẩm không khả dụng</option>
                    <option value="1">Thay đổi ý định mua</option>
                    <option value="2">Tôi Muốn Đổi Địa Chỉ</option>
                    <option value="3">Tôi Không Muốn Mua Nữa</option>
                </select>
            </div>
            <button type="submit" >Xác Nhận Hủy Đơn</button>
            </form>



        </div>
@endsection
