@extends('admin_layout')
@section('admin_content')

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm mã giảm giá
                </header>
                <div class="panel-body">

                    <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<span class ="text-alert">'.$message.' </span>';
                        Session::put('message',null);
                    }
                    ?>
                    <div class="position-center">
                        <form role="form" action="{{ URL::to('/save-coupon') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên mã giảm giá</label>
                                <input type="text" name = "tenma" class="form-control" id="exampleInputEmail1" placeholder="Tên mã giảm" minlength="10">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Số Lượng Mã</label>
                                <input type="text" name = "soluongma" class="form-control" id="exampleInputEmail1" placeholder="Số Lượng Mã"required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Điều kiện</label>
                                <select name="dieukien" class="form-control input-sm m-bot15">
                                    <option value="0">Giảm theo %</option>
                                    <option value="1">Giảm theo Tiền</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiền Giảm</label>
                                <input type="text" name = "tiengiam" class="form-control" id="exampleInputEmail1" placeholder="Số Tiền Giảm"required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng Thái</label>
                                <select name="status" class="form-control input-sm m-bot15">
                                    <option value="0">Đóng</option>
                                    <option value="1">Mở</option>
                                </select>
                            </div>

                            <button type="submit" name = "add_coupon" class="btn btn-info">Thêm Mã</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
@endsection
