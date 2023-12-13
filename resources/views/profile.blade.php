@extends('header')

@section('title')
Profile
@endsection('title')

@section('page-body')

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
      <div class="viewport-header">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb has-arrow">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
          </ol>
        </nav>
      </div>
      <div class="content-viewport">
        <div class="row">
          <div class="col-12 pb-4 pt-2">
            <h4>Manage Profile</h4>
          </div>
        </div>

        <div id="app">

          <user-profile-form-component auth-user-ref="{{ Auth::user()->ref }}"></user-profile-form-component>

        </div>

      </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    
    @include('footer')

  </div>

@endsection