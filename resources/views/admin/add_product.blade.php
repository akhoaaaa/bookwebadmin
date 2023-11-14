@extends('admin_layout')
@section('admin_content')

<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm sản phẩm
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
                                <form role="form" action="{{ URL::to('/save-product') }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" name = "tensp" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm" minlength="10">
                                </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên tác giả</label>
                                        <input type="text" name = "tacgia" class="form-control" id="exampleInputEmail1" placeholder="Tên tác giả"required>
                                    </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá sản phẩm</label>
                                    <input type="text" name = "giasp" class="form-control" id="exampleInputEmail1" placeholder="Giá sản phẩm" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình Ảnh</label>
                                    <input type="file" name = "hinhanh" class="form-control" row = " 5" id="exampleInputEmail1" required >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="mota" id="editor" placeholder="Mô tả danh mục"required></textarea>
                                </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Loại</label>
                        <select name="loai" class="form-control input-sm m-bot15">
                                <option value="1">Sách</option>
                                <option value="2">Truyện</option>
                            </select>
                    </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng tồn kho</label>
                                    <input type="text" name = "soluongtonkho" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm" required>
                                </div>
                                <div class="form-group">
                        <label for="exampleInputEmail1">Hiển Thị</label>
                        <select name="status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển</option>
                            </select>
                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Thể Loại</label>
                                        <select name="idtheloai" class="form-control input-sm m-bot15">
                                            @foreach($theloai as $loai)
                                                <option value="{{ $loai->idtheloai }}">{{ $loai->tentheloai }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                <button type="submit" name = "add_product" class="btn btn-info">Thêm sản phẩm</button>
                            </form>
                            </div>
                        </div>
                    </section>
            </div>
@endsection
