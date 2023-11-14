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
                                    <form role="form" action="{{ URL::to('/save-category-product') }}" method="post">
                                        {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">tên danh mục</label>
                                        <input type="text" name = "tendanhmuc" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Hình Ảnh</label>
                                        <input type="text" name = "hinhanh" class="form-control" row = " 5" id="exampleInputEmail1" placeholder="Hình Ảnh">
                                    </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hiển thị</label>
                            <select name="status" class="form-control input-sm m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiện</option>
                                </select>

                            </div>


                                    <button type="submit" name = "add_category_product" class="btn btn-info">Thêm</button>
                                </form>
                                </div>

                            </div>
                        </section>

                </div>
    @endsection
