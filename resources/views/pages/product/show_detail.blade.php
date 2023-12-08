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
            <h2>{{mb_strtoupper($value->tensp)}}</h2>
            <h2 style="font-size: 15px">Tác giả:  {{$value->tacgia}}</h2>
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


<div class="category-tab shop-details-tab" style="background: white"><!--category-tab-->

    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active" ><a href="#details" data-toggle="tab">Chi tiết sản phẩm</a></li>
            <li ><a href="#comment" data-toggle="tab">Bình Luận</a></li>
        </ul>
    </div>
    <div class="tab-content">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{session()->get('message')}}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger">
                {{session()->get('error')}}
            </div>
        @endif

        <div class="tab-pane fade active in" id="details" >
            <p style="margin-left: 10px">{!!$value -> mota!!}</p>
        </div>

        <div class="tab-pane fade" id="comment" >
            @if($comment->count()>0)
            @foreach($comment as $key => $cmt)
            <div class="fa-comment" style="margin-bottom: 5px" >
                <div class="username" style="display: flex;">
                    <h3 style="color: #1b6d85; margin-left: 15px;font-size: 15px">{{$cmt->username}}</h3>
                    <span class="comment-user"><?php
                                                                        $timestamp = strtotime($cmt->created_at);
                                                                        $formattedDate = date("d/m/Y", $timestamp);
                                                                        echo $formattedDate;

                                                                        ?></span>
                </div>
                <div class="comment" style="border-radius: 3px;border: 1px dashed #1b6d85;padding: 10px;text-align: left;font-weight: normal;margin-left: 10px;margin-right: 10px">
                    <p style="display: block;margin: 0" class="comment-useradd">{{$cmt->comment}}</p>
                    @if(Session::has('chucnang') && Session::get('chucnang') == 'quanly')
                        <a href="#" class="reply-link"><i class="fa fa-solid fa-reply" style="margin-right: 5px"></i>Reply</a>
                        <div class="reply-container" style="display: none;">
                            <form id="replyForm" action="{{URL::to('reply-comment/'.$cmt->id)}}" method="post">
                                {{csrf_field()}}
                                <textarea name="comment_reply" class="form-control" placeholder="Nhập reply của bạn"></textarea>
                                <button type="submit">Reply</button>
                            </form>
                        </div>
                    @endif
                    <div class="admin-replycomment">
                        @foreach($cmt->replies ?? [] as $admin)
                                <div class="admin-info" >
                                <p style="margin: 0" class="asdwqe">{{$admin->username}}</p>
                                <span style="margin-left: 10px;padding: 4px" class="dwewe">QTV</span>
                                <span  class="reply-timeeea">
                                    <?php
                                        $timestamp = strtotime($admin->create_time);
                                        $formattedDate = date("d/m/Y", $timestamp);
                                        echo $formattedDate;

                                        ?>

                                        </span>
                            </div>
                            <div class="admin-content">
                                <p  class="asdwqedf">{{$admin->comment_reply}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
                <div aria-label="Page navigation" class="asdadwed">

                    {{$comment->links()}}

                </div>

            @else
                <p style="margin-left: 15px"><b>Không có bình luận nào</b></p>
            @endif
                <div class="col-sm-12" style="margin-top: 15px">
                @if(Session::has('id'))
                <ul>
                        <li style="color: white"><i class="fa fa-user" style="margin-left: 10px"></i> xin chào: {{Session::get('username')}}</li>
                </ul>
                @endif
                    @if(Session::has('id'))
                    <form action="{{URL::to('upload-comment/'.$value->id)}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group" style="margin: 10px">
                            <textarea name="comment" class="form-control" placeholder="Nhập bình luận của bạn tại đây"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default pull-right" style="margin-right: 15px">Gửi Bình Luận</button>
                    </form>
                    @else
                        <p style="margin-left: 15px;font-style: italic"><b>Vui Lòng Đăng Nhập Để Có Thể Bình Luận</b></p>
                    @endif

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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".reply-link").click(function(event){
                event.preventDefault();
                $(".reply-container").toggle();
            });
        });
    </script>
    <style>
        ul.pagination {
            margin-top: 15px;
            background: white;
            border: none;
        }
    </style>

@endsection
