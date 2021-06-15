@extends('layouts.home')
@section('title')
    <title>Checkout</title>
@endsection

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Checkout</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Start -->
    <form action="{{route('checkout')}}" method="post">
        @csrf
    <div class="checkout">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-inner">
                        <div class="billing-address">
                            <h2>Billing Address</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <label> Name</label>
                                    <input class="form-control" type="text" name="name"
                                           @if(session()->has('customer'))value="{{session()->get('customer')[0]['name']}} @endif">
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control" type="email" name="email"
                                           @if(session()->has('customer'))value="{{session()->get('customer')[0]['email']}} @endif">
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile No</label>
                                    <input class="form-control" type="text" name="phone"
                                           @if(session()->has('customer'))value="{{session()->get('customer')[0]['phone']}}@endif">
                                </div>
                                <div class="col-md-6">
                                    <label>Notice</label>
                                    <input class="form-control" type="text"  name="notice"
                                           value="">
                                </div>
                                <div class="col-md-12">
                                    <label>Address</label>
                                    <input class="form-control" type="text" name="address"
                                           @if(session()->has('customer')) value="{{session()->get('customer')[0]['address']}}@endif">
                                </div>
                                {{--
                                                                <div class="col-md-12">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="newaccount">
                                                                        <label class="custom-control-label" for="newaccount">Create an account</label>
                                                                    </div>
                                                                </div>
                                --}}
                                {{-- <div class="col-md-12">
                                     <div class="custom-control custom-checkbox">
                                         <input type="checkbox" class="custom-control-input" id="shipto">
                                         <label class="custom-control-label" for="shipto">Ship to different
                                             address</label>
                                     </div>
                                 </div>--}}
                            </div>
                        </div>

                        {{--<div class="shipping-address">
                            <h2>Shipping Address</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>First Name</label>
                                    <input class="form-control" type="text" placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <label>Last Name"</label>
                                    <input class="form-control" type="text" placeholder="Last Name">
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control" type="text" placeholder="E-mail">
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile No</label>
                                    <input class="form-control" type="text" placeholder="Mobile No">
                                </div>
                                <div class="col-md-12">
                                    <label>Address</label>
                                    <input class="form-control" type="text" placeholder="Address">
                                </div>
                                <div class="col-md-6">
                                    <label>Country</label>
                                    <select class="custom-select">
                                        <option selected>United States</option>
                                        <option>Afghanistan</option>
                                        <option>Albania</option>
                                        <option>Algeria</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>City</label>
                                    <input class="form-control" type="text" placeholder="City">
                                </div>
                                <div class="col-md-6">
                                    <label>State</label>
                                    <input class="form-control" type="text" placeholder="State">
                                </div>
                                <div class="col-md-6">
                                    <label>ZIP Code</label>
                                    <input class="form-control" type="text" placeholder="ZIP Code">
                                </div>
                            </div>
                        </div>--}}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout-inner">
                        <div class="checkout-summary">
                            <h1>Cart Total</h1>
                            @foreach(session()->get('cart') as $item)
                                <p>{{$item['name']}}<span>{{$item['quantity']}} x ${{$item['price']}}</span></p>
                            @endforeach
                            <p class="sub-total">Sub Total<span>${{session()->get('summary')[0]['summary']}}</span></p>
                            <p class="ship-cost">Shipping Cost<span>${{session()->get('summary')[0]['shipCost']}}</span>
                            </p>
                            <p class="ship-cost">Discount<span>${{session()->get('summary')[0]['discount']}}</span></p>
                            <h2>Grand Total<span>${{session()->get('summary')[0]['total']}}</span></h2>
                        </div>

                        <div class="checkout-payment">
                            <div class="checkout-btn">
                                <button type="submit">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    <!-- Checkout End -->
@endsection

