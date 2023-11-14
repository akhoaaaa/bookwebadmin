@extends('admin_layout')
@section('admin_content')

<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật sản phẩm
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
                                @foreach($edit_product as $key => $pro)
                                <form role="form" action="{{ URL::to('/update-product/'.$pro->id) }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" name = "tensp" class="form-control" id="exampleInputEmail1" value="{{ $pro->tensp }}">
                                </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên tác giả</label>
                                        <input type="text" name = "tacgia" class="form-control" id="exampleInputEmail1" value="{{ $pro->tacgia }}">
                                    </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá sản phẩm</label>
                                    <input type="text" name = "giasp" class="form-control" id="exampleInputEmail1" value="{{ $pro->giasp }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình Ảnh</label>
                                    <input type="file" name = "hinhanh" class="form-control" row = " 5" id="exampleInputEmail1" >
                                    <img src="{{ URL::to('public/uploads/product/' . $pro->hinhanh) }}" height="75" width="75">
                                </div>
                                <div class="form-group" >
                                    <label for="exampleInputPassword1" >Mô tả sản phẩm</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="mota" id="exampleInputPassword1" >{{ $pro->mota }}</textarea>
                                </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Loại</label>
                            <select name="loai" class="form-control input-sm m-bot15" >
                                @foreach([1 => 'Sách', 2 => 'Truyện'] as $value => $label)
                                <option value="{{ $value }}" {{ $pro->loai == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                            </select>
                    </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1" >Số lượng tồn kho</label>
                                    <input type="text" name = "soluongtonkho" class="form-control" id="exampleInputEmail1" value="{{ $pro->soluongtonkho }}" >
                                </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Thể Loại</label>
                                        <select name="idtheloai" class="form-control input-sm m-bot15" >
                                            @foreach($theloai as $key => $type)
                                                @if($type->idtheloai == $pro->idtheloai)
                                                <option selected value="{{$type->idtheloai}}">{{$type->tentheloai}}</option>
                                                @else
                                                    <option  value="{{$type->idtheloai}}">{{$type->tentheloai}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>


                                <button type="submit" name = "add_product" class="btn btn-info">Cập nhật sản phẩm</button>
                            </form>
                            </div>
                            @endforeach

                        </div>
                    </section>

            </div>
@endsection
