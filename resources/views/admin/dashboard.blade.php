@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">Chào mừng bạn đến trang quản trị</h2>
        </div>
    </div>

    <div class="row">

            <div class="panel panel-info">
                <div class="panel-heading">
                    Thông tin quản trị
                </div>
                <div class="panel-body">
                    <p>Xin chào, {{ Session::get('username') }}!</p>
                    <p>Bạn có thể quản lý các danh mục, sản phẩm, đơn hàng và nhiều tùy chọn khác ở đây.</p>
                    <p>Chúc Bạn Một Ngày Làm Việc Vui Vẻ</p>
                </div>
            </div>

        <!-- Thêm các thông tin hoặc widget khác ở đây -->

    </div>

@endsection
