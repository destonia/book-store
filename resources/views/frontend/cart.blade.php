{{--
{{dd(session()->get('cart'),session()->get('summary'))}}
--}}
@extends('layouts.home')
@section('title')
    <title>Book Store</title>
@endsection
@section('search')
    <div class="search">
        <input type="text" placeholder="Search">
        <button><i class="fa fa-search"></i></button>
    </div>

@endsection
@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href={{route('home')}}>Home</a></li>
                <li class="breadcrumb-item active">Cart</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Cart Start -->
    <div class="cart-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-page-inner">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                @if(session()->has('cart'))
                                <thead class="thead-dark">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @foreach(session()->get('cart') as $item)
                                        <tr>
                                            <td>
                                                <div class="img">
                                                    <a href="#"><img src="{{asset('storage/'.$item['avatar'])}}"
                                                                     alt="Image"></a>
                                                    <p>{{$item['name']}}</p>
                                                </div>
                                            </td>
                                            <td>${{$item['price']}}</td>
                                            <td class="itemId" hidden>{{$item['id']}}</td>
                                            <td>
                                                <div class="qty">
                                                    <button class="btn-minus updateItem"><i class="fa fa-minus"></i>
                                                    </button>
                                                    <input type="text" class="itemQty" value="{{$item['quantity']}}">
                                                    <button class="btn-plus updateItem"><i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="itemTotalPrice">${{$item['totalPrice']}}</td>
                                            <td>
                                                <button onclick="" class="removeItem"><i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <h1>There is nothing in your Cart</h1>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @if(session()->has('cart'))
                    <div class="cart-page-inner">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="coupon">
                                    <input id="couponCode" type="text" placeholder="Coupon Code" value="{{session()->get('summary')[0]['couponCode']}}">
                                    <button id="couponApply" >Apply Code</button>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="cart-summary">
                                    <div class="cart-content">
                                        <h1>Cart Summary</h1>
                                        <p>Sub Total<span
                                                id="summary">@if(session()->has('summary'))${{session()->get('summary')[0]['summary']}}@endif</span></p>
                                        <p>Shipping Provider
                                            <span>
                                                <select class="custom-select" style="width: 330px" id="shipCost">
                                                    <option value="1" @if(session()->get('summary')[0]['shipCost'] == 1) selected @endif> Viettel Post 1$</option>
                                                    <option value="2" @if(session()->get('summary')[0]['shipCost'] == 2) selected @endif> Vn Express 2$</option>
                                                    <option value="3" @if(session()->get('summary')[0]['shipCost'] == 3) selected @endif> GHTK 3$</option>
                                                </select>
                                            </span></p>
                                        <p>Shipping fee
                                            <span style="color: red">
                                                @if(session()->has('summary'))+${{session()->get('summary')[0]['shipCost']}}@endif
                                            </span>
                                        </p>
                                        <p>Discount
                                            <span id="discount" style="color: green">
                                                @if(session()->has('summary'))-${{session()->get('summary')[0]['discount']}}@endif
                                            </span>
                                        </p>
                                        <h2>Grand Total
                                            <span id="total">
                                                @if(session()->has('summary'))${{session()->get('summary')[0]['total']}}@endif
                                            </span>
                                        </h2>
                                    </div>
                                    <div class="cart-btn">
                                        <button><a href="{{route('home')}}">Continue Shopping</a></button>
                                        <button>Checkout</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
@section('script')
    <script type="text/javascript">
        $('.removeItem').on('click', function () {
            $id = $(this).closest('tr').find('.itemId').text();
            $shipCost = $('#shipCost').val();
            $couponCode = $('#couponCode').val();
            $.ajax({
                type: 'get',
                url: '{{route('removeItem')}}',
                data: {
                    'id': $id,
                    'shipCost': $shipCost,
                    'couponCode': $couponCode
                },
                success: function (res) {
                    window.location.reload();
                },
            });
        });
        $('.updateItem').on('click', function () {
            let $this = $(this);
            $couponCode = $('#couponCode').val();
            $qty = $(this).closest('div').find('.itemQty').val();
            $id = $(this).closest('tr').find('.itemId').text();
            $shipCost = $('#shipCost').val();
            updateCart($qty,$id,$shipCost,$this,$couponCode);
        });
        $('.itemQty').on('change keyup', function () {
            let $this = $(this);
            $couponCode = $('#couponCode').val();
            $qty = $(this).closest('div').find('.itemQty').val();
            $id = $(this).closest('tr').find('.itemId').text();
            $shipCost = $('#shipCost').val();
            updateCart($qty, $id, $shipCost, $this,$couponCode);
        });
        $('#couponApply').on('click', function () {
            $couponCode = $('#couponCode').val();
            let $this = $(this);
            $shipCost = $('#shipCost').val();
            $qty = null;
            $id = null;
            updateCart($qty, $id, $shipCost, $this,$couponCode);
        });
        $('#shipCost').on('change', function () {
            $shipCost = $(this).val();
            let $this = $(this);
            $couponCode = $('#couponCode').val();
            $qty = null;
            $id = null;
            updateCart($qty, $id, $shipCost, $this,$couponCode);
        });


        function updateCart($qty,$id,$shipCost,$this,$couponCode){
            $.ajax({
                type: 'get',
                url: '{{route('updateCart')}}',
                data: {
                    'id': $id,
                    'qty': $qty,
                    'shipCost': $shipCost,
                    'couponCode':$couponCode
                },
                success: function (res) {
                    $this.closest('tr').find('.itemTotalPrice').text('$' + res.totalPrice);
                    $('#summary').text('$' + res.summary);
                    $('#total').text('$' + res.total);
                    $('#discount').text('-$' + res.discount);
                },
            });
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

@endsection

