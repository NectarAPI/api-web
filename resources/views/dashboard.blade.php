@extends('header')

@section('title')
Dashboard
@endsection('title')

@section('page-body')

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
      <div class="viewport-header">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb has-arrow">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard')}}">Dashboard</a>
            </li>
          </ol>
        </nav>
      </div>
      <div class="content-viewport">
        <div class="row">
          <div class="col-12 pb-4 pt-2">
            <h4>Dashboard</h4>
            @isset($lastLoginDate)
              <p class="text-gray">Last login {{ $lastLoginDate }}</p>     
            @endisset
          </div>
        </div>
        <div id="app">
          <dashboard-component></dashboard-component>
        </div>
      </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    @include('footer')
    
  </div>

@endsection