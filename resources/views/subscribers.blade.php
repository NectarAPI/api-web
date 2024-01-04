@extends('header')

@section('title')
Meters
@endsection('title')

@section('page-body')

<div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
      <div class="viewport-header">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb has-arrow">
            <li class="breadcrumb-item">
              <a href="{{ route('meters')}}">Subscribers</a>
            </li>
          </ol>
        </nav>
      </div>
      <div class="content-viewport">
        <div class="row">
          <div class="col-12 pb-4 pt-2">
            <h4>Subscribers</h4>
            @isset($lastLoginDate)
              <p class="text-gray">Last login {{ $lastLoginDate }}</p>     
            @endisset
          </div>
        </div>
        <div id="app">
          <subscribers-component></subscribers-component>
        </div>
      </div>
    </div>

    @include('footer')
    
  </div>

@endsection