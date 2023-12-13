@extends('header')

@section('title')
Utilities
@endsection('title')

@section('page-body')

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
      <div class="viewport-header">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb has-arrow">
            <li class="breadcrumb-item">
              <a href="{{ route('utilities')}}">Utilities</a>
            </li>
          </ol>
        </nav>
      </div>
      <div class="content-viewport">
        <div class="row">
          <div class="col-12 pb-4 pt-2">
            <h4>Utilities</h4>
            @isset($lastLoginDate)
              <p class="text-gray">Last login {{ $lastLoginDate }}</p>     
            @endisset
          </div>
        </div>
        <div id="app">
          <utilities-component></utilities-component>
        </div>
      </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    @include('footer')
    
  </div>

@endsection