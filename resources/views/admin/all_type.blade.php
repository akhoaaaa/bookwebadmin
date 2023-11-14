@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê danh mục sản phẩm
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

                        <th>Tên Loại</th>
                        <th>Thể Loại</th>
                        <th>Edit</th>
                        <th>Delete</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($alltype as $key => $type)
                        <tr>
                            <td>
                                @if($type->idloai == 1)
                                    Sách
                                @else
                                    Truyện

                                @endif
                            </td>
                            <td>{{ $type->tentheloai }}</td>


                            <td> <button  onclick="window.location.href='{{ URL::to('/edit-type/'.$type->idtheloai) }}'" style="background: green;color: white">Edit</button></td>
                            <td>
                                <button onclick="confirmDelete('{{ URL::to('/delete-type/'.$type->idtheloai) }}')" style="background: red; color: white">Delete</button>

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
