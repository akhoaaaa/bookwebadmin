@extends('admin_layout')
@section('admin_content')
        <script src="https://unpkg.com/unorm/lib/unorm.js"></script>

        <div class="table-agile-info">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liệt kê người dùng
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

                        <tr>
                            <th>Email</th>
                            <th>Số Điện Thoại</th>
                            <th>Username</th>
                            <th>Ngày tạo tài khoản</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        <tbody>
                        @foreach($user as $key => $users)

                            <tr>
                                <td>{{$users->email}}</td>
                                <td>{{$users->sdt}}</td>
                                <td>{{$users->username}}</td>
                                <td><?php
                                        $timestamp = strtotime($users->create_time);
                                        $formattedDate = date("d/m/Y", $timestamp);
                                        echo $formattedDate;

                                        ?></td>


                                <td> <button  onclick="window.location.href='{{ URL::to('/edit-product/') }}'" style="background: green;color: white">Edit</button></td>
                                <td>
                                    <button onclick="confirmDelete('{{ URL::to('/delete-user/'.$users->id) }}')" style="background: red; color: white">Delete</button>

                                    <script>
                                        function confirmDelete(url) {
                                            if (confirm('Bạn muốn xóa tài khoản này không?')) {
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
