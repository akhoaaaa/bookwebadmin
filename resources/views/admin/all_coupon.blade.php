@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê mã giảm giá
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

                        <th>Tên mã giảm giá</th>
                        <th>Mã coupon</th>
                        <th>Số lượng mã giảm giá</th>
                        <th>Điều kiện</th>
                        <th>Số giảm</th>
                        <th>Trạng thái</th>
                        <th>Delete</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allcoupon as $key => $coupon)
                        <tr>
                            <td>{{$coupon->tenma}}
                            </td>
                            <td>{{ $coupon->coupon_code}}</td>
                            <td>{{ $coupon->soluongma}}</td>
                            <td>@if($coupon->dieukien == 0)
                                    giảm theo %
                                @else
                                    giảm theo tiền
                                @endif</td>
                            <td>{{ $coupon->tiengiam }}</td>
                            <td><span class="text-ellipsis">
                <?php
                                    if($coupon->status ==1){
                                        ?>
                <a href ="{{ URL::to('/unactive-coupon/'.$coupon -> idma)}}"><span>Hiển Thị</span></a>
                <?php
                                    }else{
                                        ?>
                <a href = "{{ URL::to('/active-coupon/'.$coupon -> idma) }}"><span>Ẩn</span></a>
                <?php
                                    }
                                        ?>
            </span></td>
                            <td>
                                <button onclick="confirmDelete('{{ URL::to('/delete-coupon/'.$coupon->idma) }}')" style="background: red; color: white">Delete</button>

                                <script>
                                    function confirmDelete(url) {
                                        if (confirm('Bạn muốn xóa sản phẩm này không?')) {
                                            window.location.href = url;
                                        }
                                    }
                                </script>
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
    </style>

@endsection
