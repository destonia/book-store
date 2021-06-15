{{--{{dd(session()->get('cart'))}}--}}
@extends('layouts.home')
@section('title')
    <title>Book Store</title>
@endsection

{{--
@section('slider')
    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <nav class="navbar bg-light">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-home"></i>Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-shopping-bag"></i>Best Selling</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-plus-square"></i>New Arrivals</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-female"></i>Culture</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-child"></i>Fantasy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-tshirt"></i>Science</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-mobile-alt"></i>More Categories</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-microchip"></i>Authors</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-9">
                    <div class="header-slider normal-slider">
                        <div class="header-slider-item">
                            <img src="{{asset('storage/'.$books[0]->avatar)}}" alt="Slider Image" />
                            <div class="header-slider-caption">
                                <p>Some text goes here that describes the image</p>
                                <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Shop Now</a>
                            </div>
                        </div>
                        <div class="header-slider-item">
                            <img src="{{asset('frontend/img/slider-2.jpg')}}" alt="Slider Image" />
                            <div class="header-slider-caption">
                                <p>Some text goes here that describes the image</p>
                                <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Shop Now</a>
                            </div>
                        </div>
                        <div class="header-slider-item">
                            <img src="{{asset('frontend/img/slider-3.jpg')}}" alt="Slider Image" />
                            <div class="header-slider-caption">
                                <p>Some text goes here that describes the image</p>
                                <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
--}}
@section('content')
    {{--featured products--}}
    <div class="featured-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Top Sales</h1>
            </div>
            <div class="row align-items-center product-slider product-slider-4">
                @foreach($topTenOrder as $key => $book)
                <div class="col-lg-8">
                    <div class="product-item">
                        <div class="product-title">
                            <a href="#">{{$book->name}}</a>
                            <div class="ratting">
                                <p style="color:red;">Sale: {{$book->orders_count}}<span style="color: red;padding-left: 20px">View: {{$book->views}}</span></p>
                            </div>
                        </div>
                        <div class="product-image">
                            <a href="{{route('book.detail',$book->id)}}">
                                <img src="{{asset('storage/'.$book->avatar)}}" style="height: 300px" alt="Product Image">
                            </a>
                            <div class="product-action">
                                <input type="text" class="bookId" hidden value="{{$book->id}}">
                                <a class="addToCart"><i class="fa fa-cart-plus"></i></a>
                                <a href="#"><i class="fa fa-heart"></i></a>
                                <a href="{{route('book.detail',$book->id)}}"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="product-price">
                            <h3><span>$</span>{{$book->price}}</h3>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    {{--end featured products--}}

    <!-- Recommend Product Start -->
    <div class="featured-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Top Recommend</h1>
            </div>
            <div class="row align-items-center product-slider product-slider-4">
                @foreach($recommends as $key => $book)
                    <div class="col-lg-8">
                        <div class="product-item">
                            <div class="product-title">
                                <a href="#">{{$book->name}}</a>
                                <div class="ratting">
                                    <p style="color:red;">Sale: {{$book->orders_count}}<span style="color: red;padding-left: 20px">View: {{$book->views}}</span></p>
                                </div>
                            </div>
                            <div class="product-image">
                                <a href="{{route('book.detail',$book->id)}}">
                                    <img src="{{asset('storage/'.$book->avatar)}}" style="height: 300px" alt="Product Image">
                                </a>
                                <div class="product-action">
                                    <input type="text" class="bookId" hidden value="{{$book->id}}">
                                    <a class="addToCart"><i class="fa fa-cart-plus"></i></a>
                                    <a href="#"><i class="fa fa-heart"></i></a>
                                    <a href="{{route('book.detail',$book->id)}}"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="product-price">
                                <h3><span>$</span>{{$book->price}}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Recommend Product End -->

    <!-- Recommend Product Start -->
    <div class="featured-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Top Books of Century</h1>
            </div>
            <div class="row align-items-center product-slider product-slider-4">
                @foreach($hots as $key => $book)
                    <div class="col-lg-7">
                        <div class="product-item" >
                            <div class="product-title">
                                <a href="#">{{$book->name}}</a>
                                <div class="ratting">
                                    <p style="color:red;">Sale: {{$book->orders_count}}<span style="color: red;padding-left: 20px">View: {{$book->views}}</span></p>
                                </div>
                            </div>
                            <div class="product-image">
                                <a href="{{route('book.detail',$book->id)}}">
                                    <img src="{{asset('storage/'.$book->avatar)}}" style="height: 300px" alt="Product Image">
                                </a>
                                <div class="product-action">
                                    <input type="text" class="bookId" hidden value="{{$book->id}}">
                                    <a class="addToCart"><i class="fa fa-cart-plus"></i></a>
                                    <a href="#"><i class="fa fa-heart"></i></a>
                                    <a href="{{route('book.detail',$book->id)}}"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="product-price">
                                <h3><span>$</span>{{$book->price}}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Recommend Product End -->

    <!-- Review Start -->
    {{--<div class="review">
        <div class="container-fluid">
            <div class="row align-items-center review-slider normal-slider">
                <div class="col-md-6">
                    <div class="review-slider-item">
                        <div class="review-img">
                            <img src="img/review-1.jpg" alt="Image">
                        </div>
                        <div class="review-text">
                            <h2>Customer Name</h2>
                            <h3>Profession</h3>
                            <div class="ratting">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc eget leo finibus luctus et vitae lorem
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="review-slider-item">
                        <div class="review-img">
                            <img src="img/review-2.jpg" alt="Image">
                        </div>
                        <div class="review-text">
                            <h2>Customer Name</h2>
                            <h3>Profession</h3>
                            <div class="ratting">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc eget leo finibus luctus et vitae lorem
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="review-slider-item">
                        <div class="review-img">
                            <img src="img/review-3.jpg" alt="Image">
                        </div>
                        <div class="review-text">
                            <h2>Customer Name</h2>
                            <h3>Profession</h3>
                            <div class="ratting">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc eget leo finibus luctus et vitae lorem
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
    <!-- Review End -->
@endsection
@section('script')

@endsection
