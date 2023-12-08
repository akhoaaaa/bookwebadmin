@extends('admin_layout')
@section('admin_content')
    <div class="product">
        <h2 style="margin: 10px">Chi tiết sản phẩm</h2>
        @foreach($detail_pro as $key => $detail)
        <div class="infopro" style="display: flex">

            <img src="{{asset('public/uploads/product/'.$detail->hinhanh) }}" height="250" width="200" style="margin-top: 40px">
            <div class="product-info">
                <p class="asd">Tên sản phẩm: <span>{{$detail->tensp}}</span></p>
                <p class="asd">Tên tác giả: <span>{{$detail->tacgia}}</span></p>
                <p class="asd">Giá: <span>{{$detail->giasp}} vnđ</span></p>
                <p class="asd">Mô tả: <span>{{$detail->mota}}</span></p>
                <p class="asd">Loại: <span>@if($detail->loai == 1)
                                   Sách
                        @else
                                   Truyện
                @endif</span></p>
                <p class="asd" >Thể loại: <span>{{$detail->tentheloai}}</span></p>
                <p class="asd">Số lượng tồn kho: <span>{{$detail->soluongtonkho}}</span></p>
                <p class="asd">Ngày nhập kho: <span><?php
                                        $timestamp = strtotime($detail->create_time);
                                        $formattedDate = date("d/m/Y", $timestamp);
                                        echo $formattedDate;

                                        ?></span></p>
                <p class="asd">Ngày cập nhật sản phẩm: <span><?php
                                                 $timestamp = strtotime($detail->update_time);
                                                 $formattedDate = date("d/m/Y", $timestamp);
                                                 echo $formattedDate;
                                                 ?></span></p>
            </div>
        </div>
    </div>
    <div style="margin: 10px">
        <a href="{{URL::to('/edit-product/'.$detail->id)}}"><i class="fa fa-pencil"></i>Edit</a>

    </div>

    @endforeach
    <style>
        .product-info{
            padding: 20px;
        }
        p{
            font-weight: bold!important;
        }
        .asd{
            border: 1px solid #8c8c8c;
            padding: 5px;
        }
        span{
            font-weight: normal;
        }
        .infopro{
            border: 1px solid #000;
            padding: 10px;
        }
    </style>
@endsection
