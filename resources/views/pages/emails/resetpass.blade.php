@extends('welcome')
@section('content')
    <section id="form"><div class="container">
            <div class="d-flex justify-content-top">
                <div class="login-form">

                    <form action="{{URL::to('/resetpass')}}" method="post">
                        {{csrf_field()}}
                        <h2>Quên mật khẩu</h2>
                        <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span  class ="text-alert">'.$message.' </span>';
                            Session::put('message',null);
                        }
                        ?>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" placeholder="Địa chỉ email" style="padding: 10px;">
                        </div>

                        <button type="submit" class="btn btn-default">Lấy lại mật khẩu</button>
                    </form>
                    <style>
                        form {
                            padding: 20px;
                            background: white;
                            margin: 0 auto;
                            width: 400px;
                        }
                        .btn {
                            margin-top: 10px;
                        }
                    </style>
                </div>
            </div>
        </div>
    </section>
@endsection
