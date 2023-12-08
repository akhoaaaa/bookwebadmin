@extends('admin_layout')
@section('admin_content')
    <link href="{{asset('public/Backend/css/dashboard.css')}}" rel="stylesheet"/>

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
    <section class="main-course">
        <h1 style="margin-left: 5px">Dashboard</h1>
        <div class="course-box">
            <ul>
                <li class="active">Thống kê</li>

            </ul>
            <div class="course">
                <div class="box">
                    <h3>Doanh Thu</h3>
                    <p>Tổng doanh thu: <span>{{ number_format($tong, 0, '.', ',') }}</span></p>
                    <i class="fas fa-circle fa-dollar-sign"></i>
                    <form action="{{URL::to('/doanhthu')}}">
                        <button type="submit" href="">Xem chi tiết</button>
                    </form>
                </div>
                <div class="box">
                    <h3>Đơn hàng</h3>
                    <p>Tổng đơn hàng: {{$donhang}}</p>
                    <button>Xem chi tiết</button>
                    <i class="fas fa-truck-fast"></i>
                </div>
                <div class="box">
                    <h3>khách hàng</h3>
                    <p>Tổng khách hàng: {{$user}}</p>
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
    </section>
{{--    <section>--}}
{{--        <div class="container">--}}
{{--            <!-- Revenue Widget -->--}}
{{--            <div class="widget revenue-widget">--}}
{{--                <div style="display: flex">--}}
{{--                    <h2>Tổng doanh thu</h2>--}}
{{--                    <a href="{{URL::to('/doanhthu')}}" style="margin-left: auto">Chi tiết</a>--}}
{{--                </div>--}}
{{--                <p class="revenue-amount">{{ number_format($tong, 0, '.', ',') }} vnđ</p>--}}
{{--                <p>Doanh Thu Theo Tháng</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        nav {
            background-color: #f0f0f0;
            padding: 10px;
        }


        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .widget {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 10px;
            flex: 1 0 300px; /* Flexbox properties for responsiveness */
        }

        .revenue-widget {
            color: #333;
        }

        .revenue-widget h2 {
            color: #e44d26; /* Orange color for emphasis */
        }

        .revenue-amount {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>

@endsection
