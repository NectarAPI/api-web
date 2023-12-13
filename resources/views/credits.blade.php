@extends('header')

@section('title')
Credits
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
            <li class="breadcrumb-item active" aria-current="page">Credits</li>
          </ol>
        </nav>
      </div>
      <div class="content-viewport">
        <div class="row">
          <div class="col-12 pb-4 pt-2">
            <h4>Manage Credits</h4>
          </div>
        </div>
        
        <div id="app">
          <credits-component></credits-component>
        </div>

      </div>
    </div>
    
    <script defer src="{{ asset('js/app.js') }}"></script>
    @include('footer')

  </div>


@endsection