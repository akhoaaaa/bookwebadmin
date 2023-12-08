@extends('admin_layout')
@section('admin_content')
    <script src="https://unpkg.com/unorm/lib/unorm.js"></script>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê đơn hàng
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">

                </div>
            </div>
            <div class="search_box">
                <label for="search">Tìm Kiếm:</label>
                <input type="text" id="search" placeholder="Nhập từ khóa...">
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
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái Đơn Hàng</th>
                        <th>Ngày Đặt Đơn</th>

                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_order as $key => $order_pro)
                        <tr>
                            <td>{{ $order_pro ->username }}</td>
                            <td>{{ $order_pro ->diachi }}</td>
                            <td>{{ number_format($order_pro ->tongtien,0,',',',') }}</td>
                            <td><?php
                                    if($order_pro->status ==1){
                                        echo "Đã duyệt đơn";
                                    }elseif($order_pro->status ==2)   {
                                        if (is_numeric($order_pro->cancel) && $order_pro->cancel ==5){
                                            echo "Đã Hủy Đơn Hàng";
                                        }
                                        else
                                        {
                                            echo "Khách Hàng Hủy Đơn";
                                        }
                                    }elseif ($order_pro->status==4)
                                    {
                                        echo "Giao Hàng Thành Công";
                                    }
                                    elseif ($order_pro->momoid!== null)
                                    {
                                        echo "Đơn hàng thanh toán qua momo";
                                    }
                                    else{
                                        echo "Đang Chờ Xử Lý";
                                    }
                                    ?>
                            </td>
                            <td>
                                    <?php
                                    $timestamp = strtotime($order_pro->create_time);
                                    $formattedDate = date("d/m/Y", $timestamp);
                                    echo $formattedDate;
                                    ?>
                            </td>
                            <td>
                                <a href="{{ URL::to('/view-order/'.$order_pro->id) }}" class="active styling-edit" style="font-size: 15px">
                                    <i></i>Chi Tiết</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
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
        .search_box{
            display: table;
            background: #ddede0;
            margin: 5px;
        }

    </style>

    <script>
        $(document).ready(function(){
            // Xử lý sự kiện khi nhập từ khóa tìm kiếm
            $('#search').on('input', function(){
                var searchText = unorm.nfkd($(this).val().toLowerCase());
                $('table tbody tr').filter(function(){
                    var rowText = unorm.nfkd($(this).text().toLowerCase());
                    $(this).toggle(rowText.indexOf(searchText) > -1);
                });
            });
        });
    </script>
@endsection
