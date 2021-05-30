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
                    <div class="cart-page-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="coupon">
                                    <input type="text" placeholder="Coupon Code">
                                    <button>Apply Code</button>
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
                                        <h2>Grand Total<span
                                                id="total">@if(session()->has('summary'))${{session()->get('summary')[0]['total']}}@endif</span></h2>
                                    </div>
                                    <div class="cart-btn">
                                        <button>Update Cart</button>
                                        <button>Checkout</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            $shipCost = $('#shipCost').attr('data-value');
            $.ajax({
                type: 'get',
                url: '{{route('removeItem')}}',
                data: {
                    'id': $id,
                    'shipCost': $shipCost
                },
                success: function (res) {
                    window.location.reload();
                },
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
        $('.updateItem').on('click', function () {
            $qty = $(this).closest('div').find('.itemQty').val();
            $id = $(this).closest('tr').find('.itemId').text();
            $shipCost = $('#shipCost').val();
            let $this = $(this);
            $.ajax({
                type: 'get',
                url: '{{route('updateCart')}}',
                data: {
                    'id': $id,
                    'qty': $qty,
                    'shipCost': $shipCost
                },
                success: function (res) {
                    $this.closest('tr').find('.itemTotalPrice').text('$' + res.totalPrice);
                    $('#summary').text('$' + res.summary);
                    $('#total').text('$' + res.total);
                },
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
        $('.itemQty').on('change keyup', function () {
            $qty = $(this).closest('div').find('.itemQty').val();
            $id = $(this).closest('tr').find('.itemId').text();
            $shipCost = $('#shipCost').attr('data-value');
            let $this = $(this);
            $.ajax({
                type: 'get',
                url: '{{route('updateCart')}}',
                data: {
                    'id': $id,
                    'qty': $qty,
                    'shipCost': $shipCost
                },
                success: function (res) {
                    $this.closest('tr').find('.itemTotalPrice').text('$' + res.totalPrice);
                    $('#summary').text('$' + res.summary);
                    $('#total').text('$' + res.total);
                },
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
        $('#shipCost').on('change', function () {
            $shipCost = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{route('updateShipCost')}}',
                data: {
                    'shipCost': $shipCost,
                },
                success: function (res) {
                    $('#summary').text('$' + res.summary);
                    $('#total').text('$' + res.total);
                },
                error: function(req, textStatus, errorThrown) {
                    //this is going to happen when you send something different from a 200 OK HTTP
                    alert('Ooops, something happened: ' + textStatus + ' ' +errorThrown);
                },
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

@endsection

