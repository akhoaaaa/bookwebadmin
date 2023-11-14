@extends('welcome')
@section('content')
    <section id="form"><div class="container">
            <div class="d-flex justify-content-center">
                <div class="login-form">
                    <form action="{{URL::to('/add-user')}}" method="POST">
                        {{csrf_field()}}
                        @foreach($errors->all() as $val)
                            <ul>
                                <li>{{$val}}</li>
                            </ul>
                        @endforeach
                        <h2>Đăng ký tải khoản</h2>
                        <div class="form-group" >
                            <div style="align-items: center;display: flex">
                                <label for="username">Usernames </label>
                                <p style="margin-left: 15px; margin-top: 5px">(Bạn có thể nhập họ và tên của mình)</p>
                            </div>
                        <input type="text" name="username" placeholder="Username" style="width: 400px; padding: 10px;">
                        </div>
                        <div class="form-group">
                        <label for="email">Địa chỉ email</label>
                        <input type="email" name="email" placeholder="Địa chỉ email" style="width: 400px; padding: 10px;">
                        </div>
                        <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" name="pass" placeholder="Mật khẩu" style="width: 400px; padding: 10px;">

                        </div>
                        <div class="form-group">
                        <label for="password_confirmation">Nhập lại mật khẩu</label>
                        <input type="password" name ="repass" placeholder="Nhập lại mật khẩu" style="width: 400px; padding: 10px;">
                        </div>
                        <div class="form-group">
                        <label for="phone_number">Số điện thoại</label>
                        <input type="tel" name="sdt" placeholder="Số điện thoại" style="width: 400px; padding: 10px;">
                        </div>
                        <span>
                            <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}" style="margin-top: 10px"></div>
                        <br/>
                        @if($errors->has('g-recaptcha-response'))
                                <span class="invalid-feedback" style="display:block;color: red">
                            <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                            </span>
                            @endif
              </span>

                        <button type="submit" class="btn btn-default" name="chucnang" value="user">Register</button>

                        <p style="text-align: center; margin: 10px">
                            Nếu bạn đã có tài khoản, vui lòng đăng nhập tại đây: <a href="{{URL::to('login')}}">Đăng nhập</a>.
                        </p>
                    </form>

                    <style>
                        form {
                            background: white;
                            margin: 0 auto;
                            width: 500px;
                            padding: 20px;
                        }
                        .btn {
                            margin-top: 10px;
                            margin-left: 150px;
                        }
                    </style>
                </div></div>
        </div>
    </section>@endsection
