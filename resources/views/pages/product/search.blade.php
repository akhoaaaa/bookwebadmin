@extends('welcome')
@section('content')

    <div class="features_items text-center"><!--features_items-->
        <h2 class="title text-center">Kết Quả Tìm Kiếm</h2>

        @if(isset($noResults) && $noResults)
            <div class="alert alert-warning">
                Không tìm thấy kết quả nào phù hợp với tìm kiếm của bạn.
            </div>
        @else
            @foreach($search_product as $key =>$product)
                <a href="{{URL::to('chitiet-sanpham/'.$product->id)}}">
                    <div class="col-sm-3 mx-auto">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">

                                    <img src="{{URL::to('public/uploads/product/'.$product->hinhanh)}}" alt="" width="300" height="350" />
                                    <h2>{{($product->tensp)}}</h2>
                                    <p>{{number_format($product->giasp) }} VNĐ</p>

                                    @if ($product->soluongtonkho === 0)
                                        <a class="btn btn-default add-to-cart out-of-stock">Hết Hàng</a>
                                    @else
                                        <a href="{{URL::to('/chitiet-sanpham/'.$product->id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Giỏ Hàng</a>
                                    @endif
                                </div>
                            </div>
                            <div class="choose">
                                <ul class="nav nav-pills nav-justified">
                                    <li><a href="#"><i class="fa fa-plus-square"></i>Thêm Yêu Thích</a></li>
                                    <li><a href="#"><i class="fa fa-plus-square"></i>Thêm So Sánh</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
            {{-- Hiển thị kết quả tìm kiếm ở đây --}}
        @endif


    </div><!--features_items-->
@endsection
