@extends('welcome')
@section('content')
    <section id="form">
        <div class="container">
            <div class="d-flex justify-content-top">
                <div class="login-form">
                    <form action="{{URL::to('/checklogin')}}" method="post" style="background: white;margin: 0 auto;width: 450px;padding: 20px;">
                        {{csrf_field()}}
                        <h2>Đăng nhập tải khoản</h2>
                        <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span  class ="text-alert">'.$message.' </span>';
                            Session::put('message',null);
                        }
                        ?>

                        <div class="form-group">

                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="Địa chỉ email" style=" width: 400px; padding: 10px;">
                        </div>

                        <label for="password">Password</label>
                        <input type="password" name="pass" placeholder="Password" style="width: 400px; padding: 10px;">

                        <button type="submit" class="btn btn-default">Login</button>


                        <p style="text-align: center; margin: 10px">
                            Nếu bạn chưa có tài khoản, vui lòng đăng ký tại đây: <a href="{{URL::to('register-user')}}">Đăng ký</a>.
                        </p>
                        <p style="text-align: center; margin: 10px">
                            Quên mật khẩu vui lòng nhấn vào: <a style="color: blue" href="{{URL::to('resetpass')}}">Quên mất khẩu</a>.
                        </p>
                    </form>

                </div></div>
        </div>
    </section>
@endsection
