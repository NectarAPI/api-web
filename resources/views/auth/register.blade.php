@extends('auth.header')

@section('title')
Register
@endsection('title')

@section('main-content')

<div class="authentication-theme auth-style_1 pt-4">
    <div class="row mb-2">
      <div class="col-12 logo-section text-center mb-2">
        <a href="{{ route('login') }}" class="logo">
          <img src="{{ asset('images/logo.svg') }}" alt="logo" />
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-5 col-md-7 col-sm-9 col-11 mx-auto">
        <div class="grid">
          <div class="grid-body pt-4">
            <div class="row">
              <div class="col-lg-7 col-md-8 col-sm-9 col-12 mx-auto form-wrapper">
                <div id="app">
                    <register-component></register-component>
                </div>
                <div class="signup-link">
                  <a href="{{ route('login') }}">Login</a>&nbsp;&nbsp;&nbsp;| <a href="{{ route('verification.forgot-password') }}">Forgot Password</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   
    @include('auth.footer')

  </div>

@endsection