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
        <div class="info-title">
            <h1 class="Sb123">Chi Tiết Đơn Hàng</h1>
            <div class="x2">
                <p>Thông tin chi tiết về đơn hàng mà bạn đã đặt</p>
            </div>
        </div>
        <div class="col-sm-4" style="background: white;margin-bottom: 25px;margin-top: 25px;width: 60%">
            <div class="info-title">
            <h1 class="Sb123">Hồ Sơ Của Tôi</h1>
                <div class="x2">
                    <p>Quản Lý Thông Tin Hồ Sơ Để Bảo Mật Tài Khoản</p>
                </div>
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

            <div class="x3">
                <div class="x4">
                    @foreach($user as $key => $users)
                        <form class="centered-form" method="post" action="{{URL::to('/save-info/' . $users->id)}}" id="save-form">
                            {{ csrf_field() }}

                            <table class="form-x">
                            <tr>
                                <td class="user_info">
                                    <label for="username">Username</label>
                                </td>
                                <td>
                                    <div class="form-input">
                                        <input type="text" id="username" name="username" value="{{$users->username}}">
                                        <a class="aa">Thay Đổi</a>
                                    </div>
                                        <p style="display: block;font-style: italic">
                                            Bạn có thể nhập họ và tên của mình vào username
                                        </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="user_info">
                                    <label for="username">Số Điện Thọai</label>
                                </td>
                                <td>
                                    <div class="form-input">
                                        <input type="text" id="sdt" name="sdt"  value="{{$users->sdt}}" readonly>
                                        <a class="aa">Thay Đổi</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="user_info">
                                    <label for="username">Email</label>
                                </td>
                                <td>
                                    <div class="form-input">
                                        <input type="text" id="email" name="email"  value="{{$users->email}}" readonly>
                                        <a class="aa" >Thay Đổi</a>
                                    </div>
                                </td>



                            </tr>
                            <tr class="user_info">
                                <td >
                                    <button class="button-click" type="button" id="save-button" >Lưu</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    @endforeach

                </div>
            </div>

        </div>

        <script>
            document.getElementById('save-button').addEventListener('click', function() {
                console.log('Button clicked');
                document.getElementById('save-form').submit();
            });
        </script>


@endsection
