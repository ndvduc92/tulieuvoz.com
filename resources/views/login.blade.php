@extends('layout')
@section('content')
<div class="container signup-form" style="margin-top:100px">
@if (\Session::has('success'))
    <div class="alert alert-success">
       <p>{{ \Session::get('success') }}</p>
    </div>
@endif
@if (\Session::has('danger'))
    <div class="alert alert-danger">
       <p>{{ \Session::get('danger') }}</p>
    </div>
@endif
        <form action="/login" method="POST" id="logForm">
            {{ csrf_field() }}
            <p class="lead">Please login to your account.</p>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
                    <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email Address" required="required">
                </div>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password" required="required">
                </div>
                @if ($errors->has('password'))
                    <span class="error">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
            </div>
        </form>
        <div class="text-center">Don't have an account? <a href="/register">Register here</a>.</div>
    </div>
@endsection
