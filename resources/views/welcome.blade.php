<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Book Store</title>
    <link href="{{asset('public/fontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/fontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/fontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('public/fontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('public/fontend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('public/fontend/css/userprofile.css')}}" rel="stylesheet">
    <link href="{{asset('public/fontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('public/fontend/css/responsive.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{('public/fontend/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
    <header id="header"><!--header-->
        <div class="header_top"><!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-phone"></i> +84 785339021</a></li>
                                <li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header_top-->

        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href="index.html"><img src="{{('public/fontend/images/home/logo.png')}}" alt="" /></a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
                                @if (Session::has('id'))
                                    <li><a href="#"><i class="fa fa-star"></i> Yêu Thích</a></li>
                                    <li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh Toán</a></li>
                                    <li><a href="{{URL::to('/show-cart')}}"><i class="fa fa-shopping-cart"></i> Giỏ Hàng</a></li>
                                    <li><a href="{{URL::to('/user/'.Session::get('id'))}}"><i class="fa fa-user"></i> {{ Session::get('username') }}</a></li>
                                    <li><a href="{{URL::to('/logout')}}"><i class="fa fa-lock"></i> Đăng Xuất</a></li>
                                @else
                                    <li><a href="{{URL::to('/register-user')}}"><i class="fa fa-pencil-square-o"></i> Đăng Ký</a></li>
                                    <li><a href="{{URL::to('/login')}}"><i class="fa fa-sign-in"></i> Đăng Nhập</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-middle-->

        <div class="header-bottom"><!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li class="active"><a href="{{URL::to('/trang-chu') }}" >Trang Chủ</a></li>
                                <li class="dropdown"><a href="{{URL::to('/danhmuc-sanpham')}}">Sản Phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="{{URL::to('/danhmuc-sanpham/sach')}}">Sách</a></li>
                                        <li><a href="{{URL::to('/danhmuc-sanpham/truyen')}}">Truyện</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="#">Tin tức<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="blog.html">Blog List</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{URL::to('')}}">Liên Hệ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <form action="{{URL::to('/tim-kiem')}}" method="post">
                            {{csrf_field()}}
                        <div class="search_box pull-right">
                            <input name="keywords_submit" type="text" placeholder="Nhập sản phẩm cần tìm"/>
                            <input type="submit" name="search_items" class="btn btn-info btn-sm" value="Tìm kiếm">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/header-bottom-->
    </header><!--/header-->

    <section id="slider"><!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#slider-carousel" data-slide-to="1"></li>
                            <li data-target="#slider-carousel" data-slide-to="2"></li>
                        </ol>

                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="col-sm-6">
                                    <h1><span>BOOK</span>-STORE</h1>
                                    <h2>Chào mừng bạn đến với BookStore</h2>
                                    <p> Bạn có thể tìm kiếm được những cuốn sách và truyện trong bookstore</p>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{asset('public/fontend/images/book1.jpg')}}" class="girl img-responsive" alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-sm-6">
                                    <h1><span>BOOK</span>-STORE</h1>
                                    <h2>Chào mừng bạn đến với BookStore</h2>
                                    <p> Bạn có thể tìm kiếm được những cuốn sách và truyện trong bookstore</p>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{asset('public/fontend/images/book2.jpg')}}" class="girl img-responsive" alt="" />
                                </div>
                            </div>

                            <div class="item">
                                <div class="col-sm-6">
                                    <h1><span>BOOK</span>-STORE</h1>
                                    <h2>Chào mừng bạn đến với BookStore</h2>
                                    <p> Bạn có thể tìm kiếm được những cuốn sách và truyện trong bookstore</p>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{asset('public/fontend/images/book3.jpg')}}" class="girl img-responsive" alt="" />
                                </div>
                            </div>

                        </div>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section><!--/slider-->

    <section>
        <div class="container-fluid" style="background: #F5F5F5">
            <div class="row justify-content-center" style="margin-left: 50px;margin-right: 50px">
                <div class="col-sm-12">

                    @yield('content')


                </div>
            </div>
        </div>
    </section>

    <footer id="footer"><!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="companyinfo">
                            <h2><span>book</span>-store</h2>
                            <p>Chào mừng bạn đến với trang bán sách, Hãy mua những cuốn sách hữu ích cho bạn..</p>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="{{URL::to('/danhmuc-sanpham/sach')}}">
                                    <div class="iframe-img">
                                        <img src="{{asset('public/fontend/images/book1.jpg')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Nhấn vào hình ảnh để đến trang sách</p>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="{{URL::to('/danhmuc-sanpham/truyen')}}">
                                    <div class="iframe-img">
                                        <img src="{{asset('public/Fontend/images/book2.jpg')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Nhấn vào hình ảnh để mua truyện</p>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>

        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Hỗ Trợ</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Online Help</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Order Status</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Cửa Hàng</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="{{URL::to('/danhmuc-sanpham/sach')}}">Sách</a></li>
                                <li><a href="{{URL::to('/danhmuc-sanpham/truyen')}}">Truyện</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Policies</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Terms of Use</a></li>
                                <li><a href="#">Privecy Policy</a></li>
                                <li><a href="#">Refund Policy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3 col-sm-offset-1">
                        <div class="single-widget">
                            <h2>About Shopper</h2>
                            <form action="#" class="searchform">
                                <input type="text" placeholder="Your email address" />
                                <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                                <p>Get the most recent updates from <br />our site and be updated your self...</p>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
                    <p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
                </div>
            </div>
        </div>

    </footer><!--/Footer-->



    <script src="{{asset('public/fontend/js/jquery.js')}}"></script>
    <script src="{{asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>

    <script src="{{asset('public/fontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/fontend/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('public/fontend/js/price-range.js')}}"></script>
    <script src="{{asset('public/fontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('public/fontend/js/main.js')}}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v18.0" nonce="Dgg4hi0p"></script>
</body>
</html>
