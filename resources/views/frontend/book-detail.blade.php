@extends('layouts.home')
@section('title')
    <title>Book Detail</title>
@endsection
@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Book Detail</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Detail Start -->
    <div class="product-detail">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="product-detail-top">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="product-slider-single normal-slider">
                                    <img src="{{asset('storage/'.$book->avatar)}}" alt="Product Image">
                                </div>
                                {{--
                                                                <div class="product-slider-single-nav normal-slider">
                                                                    <div class="slider-nav-img"><img src="{{asset('storage/'.$book->avatar)}}" alt="Product Image"></div>
                                                                </div>
                                --}}
                            </div>
                            <div class="col-md-7">
                                <div class="product-content">
                                    <div class="title"><h2>Name: {{$book->name}}</h2></div>
                                    <div class="title"><h6>
                                            Authors: @foreach($book->authors as $author){{$author->name.','}}@endforeach</h6>
                                    </div>
                                    <div class="title"><h6>
                                            Category: @foreach($book->categories as $category){{$category->name.','}}@endforeach</h6>
                                    </div>
                                    <div class="title"><h6>Language: {{$book->lang}}</h6></div>
                                    <div class="title"><h6>Publisher: {{$book->publisher}}</h6></div>
                                    <div class="title"><h6>Published date: {{$book->publish_date}}</h6></div>
                                    <div class="title"><h6>Republish No: {{$book->republish_no}}</h6></div>
                                    <div class="title"><h6>ISBN: {{$book->isbn_no}}</h6></div>
                                    <div class="ratting">
                                        <span style="font-size: 15px">(Ordered: {{$book->orders_count}})</span></i>
                                    </div>
                                    <div class="price">
                                        <h4>Price:</h4>
                                        <p>${{$book->price}}</p>
                                    </div>
                                    <div class="action">
                                        <input type="hidden" class="bookId" value="{{$book->id}}">
                                        <a class="btn addToCart"><i class="fa fa-shopping-cart"></i>Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row product-detail-bottom">
                        <div class="col-lg-12">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#description">Description</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="description" class="container tab-pane active">
                                    <h4>Product description</h4>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. In condimentum quam ac
                                        mi viverra dictum. In efficitur ipsum diam, at dignissim lorem tempor in.
                                        Vivamus tempor hendrerit finibus. Nulla tristique viverra nisl, sit amet
                                        bibendum ante suscipit non. Praesent in faucibus tellus, sed gravida lacus.
                                        Vivamus eu diam eros. Aliquam et sapien eget arcu rhoncus scelerisque.
                                        Suspendisse sit amet neque neque. Praesent suscipit et magna eu iaculis. Donec
                                        arcu libero, commodo ac est a, malesuada finibus dolor. Aenean in ex eu velit
                                        semper fermentum. In leo dui, aliquet sit amet eleifend sit amet, varius in
                                        turpis. Maecenas fermentum ut ligula at consectetur. Nullam et tortor leo.
                                    </p>
                                </div>
                                <div id="specification" class="container tab-pane fade">
                                    <h4>Product specification</h4>
                                    <ul>
                                        <li>Lorem ipsum dolor sit amet</li>
                                        <li>Lorem ipsum dolor sit amet</li>
                                        <li>Lorem ipsum dolor sit amet</li>
                                        <li>Lorem ipsum dolor sit amet</li>
                                        <li>Lorem ipsum dolor sit amet</li>
                                    </ul>
                                </div>
                                <div id="reviews" class="container tab-pane fade">
                                    <div class="reviews-submitted">
                                        <div class="reviewer">Phasellus Gravida - <span>01 Jan 2020</span></div>
                                        <div class="ratting">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <p>
                                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                                            doloremque laudantium, totam rem aperiam.
                                        </p>
                                    </div>
                                    <div class="reviews-submit">
                                        <h4>Give your Review:</h4>
                                        <div class="ratting">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <div class="row form">
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Name">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="email" placeholder="Email">
                                            </div>
                                            <div class="col-sm-12">
                                                <textarea placeholder="Review"></textarea>
                                            </div>
                                            <div class="col-sm-12">
                                                <button>Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product">
                                <div class="section-header">
                                    <h1>Related Products</h1>
                                </div>

                                <div class="row align-items-center product-slider product-slider-3">
                                    @foreach($relatedBooks as $book)
                                        <div class="col-lg-3">
                                            <div class="product-item">
                                                <div class="product-title">
                                                    <a href="#">{{$book->name}}</a>
                                                    <div class="ratting">
                                                        <p style="color:red;">Sale: {{$book->orders_count}}<span
                                                                style="color: red;padding-left: 20px">View: {{$book->views}}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="product-image">
                                                    <a href="product-detail.html">
                                                        <img style="height: 300px"
                                                             src="{{asset('storage/'.$book->avatar)}}"
                                                             alt="Product Image">
                                                    </a>
                                                    <div class="product-action">
                                                        <input class="bookId" type="hidden" value="{{$book->id}}">
                                                        <a class="addToCart"><i class="fa fa-cart-plus"></i></a>
                                                        <a href="#"><i class="fa fa-heart"></i></a>
                                                        <a href="{{route('book.detail',$book->id)}}"><i
                                                                class="fa fa-search"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product-price">
                                                    <h3><span>$</span>{{$book->price}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Side Bar Start -->
                <!-- Side Bar End -->
            </div>
        </div>
    </div>
    <!-- Product Detail End -->

    <!-- Brand Start -->
    <!-- Brand End -->
@endsection
