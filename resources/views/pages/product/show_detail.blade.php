@extends('welcome')
@section('content')


    @foreach($product_detail as $key => $value)
        <meta property="og:url"           content="{{Request::url()}}" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="{{$value->tensp}}" />
        <meta property="og:description"   content="{{$value->mota}}" />
        <meta property="og:image"         content="{{ URL::to('public/uploads/product/'.$value->hinhanh) }}" />
<div class="product-details"><!--product-details-->
    <div class="col-sm-5">
        <div class="view-product">
            <img src="{{URL::to('public/uploads/product/'.$value->hinhanh)}}" alt="" style="width: 300px;margin-top: 20px;margin-right: 20px"/>
        </div>


    </div>
    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->
            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
            <h2>{{$value->tensp}}</h2>
            <p>Tác giả:  {{$value->tacgia}}</p>
            <img src="images/product-details/rating.png" alt="" />
            <form action="{{URL::to('/save-cart')}}" method="POST">
                {{csrf_field()}}
            <span>
									<span>{{number_format($value->giasp)}} VNĐ</span>
									<label>Số lượng:</label>
									<input name="qty" type="number" min="1" value="1" max="{{$value->soluongtonkho}}" />
                                    <input name="productid_hidden" type="hidden"  value="{{$value->id}}"  />
									<button type="submit" class="btn btn-fefault cart">
										<i class="fa fa-shopping-cart"></i>
										Thêm Giỏ Hàng
									</button>
            </span>
            </form>
            <div class="fb-share-button" data-href="{{ Request::url() }}" data-layout="button" data-size="large">
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}&src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a>
            </div>
            <p><b>Tình Trạng:</b>
                @if($value->soluongtonkho == 0)
                    Hết Hàng
                @else
                    Còn Hàng
                @endif
            </p>
            <p><b>Điều kiện:</b> New</p>
            <p><b>Thể Loại:</b> {{$value->tentheloai}}</p>
            <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->


<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active" ><a href="#details" data-toggle="tab">Chi tiết sản phẩm</a></li>
            <li ><a href="#reviews" data-toggle="tab">Nhận Xét</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="details" >
            <p>{!!$value -> mota!!}</p>
        </div>

        <div class="tab-pane fade" id="reviews" >
            <div class="col-sm-12">
                <ul>
                    <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                    <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                    <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <p><b>Write Your Review</b></p>

                <form action="#">
										<span>
											<input type="text" placeholder="Your Name"/>
											<input type="email" placeholder="Email Address"/>
										</span>
                    <textarea name="" ></textarea>
                    <b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
                    <button type="button" class="btn btn-default pull-right">
                        Submit
                    </button>
                </form>
            </div>
        </div>

    </div>
</div><!--/category-tab-->
    @endforeach
    <div class="recommended_items"><!--recommended_items-->
        <h2 class="title text-center">Sản phẩm liên quan</h2>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach($related as $key => $relateds)
                    @if ($key % 3 == 0)
                        <div class="item{{ $key == 0 ? ' active' : '' }}">
                            <div class="row">
                                @endif
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <a href="{{ URL::to('chitiet-sanpham/'.$relateds->id) }}">
                                                    <img src="{{ URL::to('public/uploads/product/'.$relateds->hinhanh) }}" alt="" />
                                                    <h2>{{ number_format($relateds->giasp) }} VNĐ</h2>
                                                    <p>{{ $relateds->tensp }}</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (($key + 1) % 3 == 0 || $key == count($related) - 1)
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div><!--/recommended_items-->
@endsection
