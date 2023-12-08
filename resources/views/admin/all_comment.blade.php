@extends('admin_layout')
@section('admin_content')
    <script src="https://unpkg.com/unorm/lib/unorm.js"></script>

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê bình luận
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

                        <th>Tên sản phẩm</th>
                        <th>Username</th>
                        <th>Bình Luận</th>
                        <th>Trạng Thái</th>
                        <th>Thời Gian Comment</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_comment as $key => $cmt)
                        <tr>
                            <td><a href="{{URL::to('chitiet-sanpham/'.$cmt->idsp)}}">{{$cmt->tensp}}</a></td>
                            <td>{{$cmt->username}}</td>
                            <td>{{$cmt->comment}}</td>
                            <td><span class="text-ellipsis">
                                    @if($cmt->status==1)
                                        <a href ="{{ URL::to('/unactive-comment/'.$cmt -> id)}}"><span>Hiển Thị</span></a>
                                    @else
                                        <a href ="{{ URL::to('/active-comment/'.$cmt -> id)}}"><span>Ẩn</span></a>
                                    @endif
                    </span></td>
                            <td><?php
                                    $timestamp = strtotime($cmt->created_at);
                                    $formattedDate = date("d/m/Y", $timestamp);
                                    echo $formattedDate;

                                    ?></td>
                        </tr>
                        {{-- Thêm dòng sau để in ra dữ liệu và dừng chương trình --}}
                    @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-5 text-center">
                    </div>

                </div>
            </footer>
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
