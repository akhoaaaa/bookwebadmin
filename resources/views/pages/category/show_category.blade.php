@extends('welcome')
@section('content')


    <div class="features_items text-center"><!--features_items-->
        <h2 class="title text-center">
            @if(isset($allproduct) && count($allproduct) > 0)
                @if($allproduct[0]->loai == 1)
                    Danh Mục Sách
                @elseif($allproduct[0]->loai == 2)
                    Danh Mục Truyện
                @else
                    Danh Mục Sản Phẩm
                @endif
            @else
                Danh Mục Sản Phẩm
            @endif
        </h2>

        @if(isset($allproduct) && count($allproduct) > 0)
            @foreach($allproduct as $key => $product)
                <a href="{{URL::to('chitiet-sanpham/'.$product->id)}}">
                <div class="col-sm-3 mx-auto">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{URL::to('public/uploads/product/'.$product->hinhanh)}}" alt="" height="350" width="300"/>
                                <p>{{($product->tensp)}}</p>
                                <h2>{{number_format($product->giasp) }} VNĐ</h2>

                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Giỏ Hàng</a>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            @endforeach
        @else
            <p>Không có sản phẩm nào.</p>
        @endif
    </div><!--features_items-->
@endsection
