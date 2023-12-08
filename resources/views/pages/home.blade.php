@extends('welcome')
@section('content')

    <div class="features_items text-center"><!--features_items-->
        <h2 class="title text-center">Sản Phẩm Mới Nhất</h2>

        @foreach($allproduct as $key =>$product)
            <a href="{{URL::to('chitiet-sanpham/'.$product->id)}}">
                <div class="col-sm-3 mx-auto">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">

                                <img src="{{URL::to('public/uploads/product/'.$product->hinhanh)}}" alt="" width="300" height="300" />
                                <h2>{{mb_strtoupper($product->tensp)}}</h2>
                                <p>{{number_format($product->giasp) }} VNĐ</p>

                                @if ($product->soluongtonkho === 0)
                                    <a class="btn btn-default add-to-cart out-of-stock">Hết Hàng</a>
                                @else
                                    <a href="{{URL::to('/chitiet-sanpham/'.$product->id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Giỏ Hàng</a>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div><!--features_items-->
@endsection
