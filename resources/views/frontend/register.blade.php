@extends('layouts.home')
@section('title')
    <title> Register </title>
@endsection
@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Login & Register</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Login Start -->
    <div class="login">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="register-form">
                        <form action="{{route('register')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label>User Name</label>
                                    <input class="form-control" type="text" name="name" required value="{{old('name')}}">
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    @if(!$errors->get('email'))
                                        <input class="form-control" type="email" name="email" required value="{{old('email')}}">
                                    @else
                                        <input class="form-control" style="border: solid red" type="email" name="email" required>
                                        @foreach($errors->get('email') as $error)
                                            <p style="color: red; text-align: right;padding-right: 30px">{{$error}}</p>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile No</label>
                                    <input class="form-control" type="text" name="phone" value="{{old('phone')}}">
                                </div>
                                <div class="col-md-6">
                                    <label>Address</label>
                                    <input class="form-control" type="text" name="address" value="{{old('address')}}">
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password" id="password" required value="{{old('password')}}">
                                </div>
                                <div class="col-md-6">
                                    <label>Confirm Password</label><span id="message" style="text-align: right"></span>
                                    <input class="form-control" type="password" name="confirm_password"
                                           id="confirm_password" required value="{{old('confirm_password')}}">
                                </div>

                                <div class="col-md-6">
                                    <button class="btn" type="submit">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login End -->
@endsection
@section('script')
    <script>
        $('#confirm_password').on('keyup', function () {
            if ($('#password').val() == $('#confirm_password').val()) {
                $('#message').html('Matching').css('color', 'green');
            } else
                $('#message').html('Not Matching').css('color', 'red');
        });
    </script>
@endsection
