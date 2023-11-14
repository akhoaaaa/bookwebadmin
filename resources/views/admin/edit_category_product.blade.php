@extends('admin_layout')
@section('admin_content')

<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm danh mục sản phẩm
                        </header>
                        <div class="panel-body">
                            @foreach($edit_category_product as $key => $edit_value)

                            <div class="position-center">
                                <form role="form" action="{{ URL::to('/update-category-product/'.$edit_value->id) }}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">tên danh mục</label>
                                    <input type="text" value="{{ ($edit_value->tendanhmuc) }}" name = "tendanhmuc" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình Ảnh</label>
                                    <input type="text" value="{{ ($edit_value->hinhanh) }}" name = "hinhanh" class="form-control" row = " 5" id="exampleInputEmail1" placeholder="Hình Ảnh">
                                </div>

                                <button type="submit" name = "add_category_product" class="btn btn-info">Cập nhật danh mục</button>
                            </form>
                            </div>
                            @endforeach

                        </div>
                    </section>

            </div>
@endsection