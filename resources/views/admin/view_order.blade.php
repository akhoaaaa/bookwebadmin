@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin khách hàng
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class ="text-alert">'.$message.' </span>';
                    Session::put('message',null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>

                    <tr>

                        <th>Tên Người Đặt</th>
                        <th>Địa chỉ nhận hàng</th>
                        <th>Địa chỉ email</th>
                        <th>Số điện thoại</th>
                        <th>Hình Thức Thanh Toán</th>
                        @if($userinfo->note!==null)
                        <th>Ghi Chú</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{$userinfo->username}}</td>
                            <td>{{$userinfo->diachi}}</td>
                            <td>{{$userinfo->email}}</td>
                            <td>{{$userinfo->sdt}}</td>
                            <td>@if($userinfo->payment==0)
                                    Thanh Toán Tiền Mặt
                                @else
                                    Chuyển Khoản
                            @endif</td>
                            <td>{{$userinfo->note}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Chi tiết đơn hàng
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class ="text-alert">'.$message.' </span>';
                    Session::put('message',null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($orderbyid as $sanpham)
                        <tr>
                        <td>{{$sanpham->tensp}}</td>
                        <td>{{$sanpham->soluong}}</td>
                        <td>{{number_format($sanpham->giasp * $sanpham->soluong,0,',',',')}}</td>
                        </tr>

                    @endforeach
                    <tr>
                        <td colspan="2"><strong style="color: red">Tổng tiền:</strong></td>
                        <td>{{number_format($userinfo->tongtien, 0,',',',')}}</td>
                    </tr>
                    @if(isset($orderbyid[0]->idma))
                        <p style="margin-left: 10px">Giảm Giá: {{$orderbyid[0]->tenma}}</p>
                        <p style="margin-left: 10px">Số tiền giảm giá:
                            @if ($orderbyid[0]->dieukien == 0)
                                {{ number_format($orderbyid[0]->tiengiam)  }}%
                            @else
                                {{ number_format($orderbyid[0]->tongtien, 0, ',', ',') }} vnđ
                            @endif
                        </p>
                    @else
                        <p></p>
                    @endif


                    </tbody>
                </table>
            </div>
        </div>
        @if($userinfo->status==0)
        <button onclick="confirmDelete('{{ URL::to('/active-order/'.$userinfo->id) }}')" style="background: #5cff0e; color: white">Duyệt Đơn Hàng</button>

        <script>
            function confirmDelete(url) {
                if (confirm('Duyệt Đơn Hàng')) {
                    window.location.href = url;
                }
            }
        </script>
        @elseif($userinfo->status==1)
            <p>Đang Update</p>
        @elseif($userinfo->status ==2)
            @if($userinfo->cancel == 0)
                    <span>Khách Hàng Hủy Lý Do: Sản phẩm không khả dụng </span>
                    <a href="{{ URL::to('/unactive-orderuser/'.$userinfo->id)}}" style="text-align: right;display: block">Hủy Đơn Hàng </a>
                @elseif($userinfo->cancel == 1)
                    <span>Khách Hàng Hủy Lý Do: Thay đổi ý định mua</span>
                    <a href="{{ URL::to('/unactive-orderuser/'.$userinfo->id)}}" style="text-align: right;display: block">Hủy Đơn Hàng </a>
                @elseif($userinfo->cancel == 2)
                    <span>Khách Hàng Hủy Lý Do: Đổi Địa Chỉ </span>
                    <a href="{{ URL::to('/unactive-orderuser/'.$userinfo->id)}}" style="text-align: right;display: block">Hủy Đơn Hàng </a>
                @elseif($userinfo->cancel == 3)
                    <span>Khách Hàng Hủy Lý Do: Không muốn mua sản phẩm </span>
                    <a href="{{ URL::to('/unactive-orderuser/'.$userinfo->id)}}" style="text-align: right;display: block;">Hủy Đơn Hàng </a>
                @else
                <h3 style="margin-left: 10px;color: red" >Đơn Hàng Đã Bị Hủy</h3>
                @endif
        @else

        @endif
    </div>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            border-bottom: 3px solid #000000;
            padding: 3px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>

@endsection
