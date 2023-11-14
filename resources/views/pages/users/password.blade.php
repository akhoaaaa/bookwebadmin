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
    <div class="col-sm-4" style="background: white;margin-bottom: 25px;margin-top: 25px;width: 60%">
        <div class="info-title">
            <h1 class="Sb123">Đổi Mật Khẩu</h1>
            <div class="x2">
                <p>Thay Đổi Mật Khẩu Của Bạn</p>
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
                <form method="post" action="{{ URL::to('/update-password') }}">
                    {{ csrf_field() }}
                    @if ($errors->has('old_password'))
                        <span class="error">{{ $errors->first('old_password') }}</span>
                    @endif
                    @if ($errors->has('new_password'))
                        <span class="error">{{ $errors->first('new_password') }}</span>
                    @endif
                    @if ($errors->has('confirm_password'))
                        <span class="error">{{ $errors->first('confirm_password') }}</span>
                    @endif

                        <table class="form-x">
                            <tr>
                                <td class="user_info">
                                    <label for="old_password">Mật Khẩu Cũ</label>
                                </td>
                                <td>
                                    <div class="form-input">
                                        <input type="password" id="old_password" name="old_password" >
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="user_info">
                                    <label for="new_password">Mật Khẩu Mới</label>
                                </td>
                                <td>
                                    <div class="form-input">
                                        <input type="password" id="new_password" name="new_password"  >

                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="user_info">
                                    <label for="confirm_password">Nhập Lại Mật Khẩu Mới</label>
                                </td>
                                <td>
                                    <div class="form-input">
                                        <input type="password" id="confirm_password" name="confirm_password">
                                    </div>
                                </td>



                            </tr>
                            <tr class="user_info">
                                <td>
                                    <button class="button-click" type="submit" >Đổi Mật Khẩu</button>
                                </td>
                            </tr>
                        </table>
                    </form>

            </div>
        </div>

    </div>


@endsection
