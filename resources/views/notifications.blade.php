@extends('header')

@section('title')
Notifications
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
            <li class="breadcrumb-item active" aria-current="page">Notifications</li>
          </ol>
        </nav>
      </div>
      <div class="content-viewport">
        <div class="row">
          <div class="col-12 pb-4 pt-2">
            <h4>Manage Notifications</h4>
          </div>
        </div>
        
        <div id="app">
          <notifications-component></notifications-component>
        </div>

      </div>
    </div>
    
    <script defer src="{{ asset('js/app.js') }}"></script>
    @include('footer')

  </div>

@endsection