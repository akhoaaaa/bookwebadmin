@extends('admin_layout')
@section('admin_content')

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm danh mục sản phẩm
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
                        <form role="form" action="{{ URL::to('/save-type') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Loại</label>
                                <select name="idloai" class="form-control input-sm m-bot15">
                                    <option value="1">Sách</option>
                                    <option value="2">Truyện</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên Thể Loại</label>
                                <input type="text" name = "tentheloai" class="form-control" id="exampleInputEmail1" placeholder="Tên Thể Loại">
                            </div>

                            <button type="submit" name = "add_category_product" class="btn btn-info">Thêm Thể Loại</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
@endsection
