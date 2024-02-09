@extends('header')

@section('title')
Credentials
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
            <li class="breadcrumb-item active" aria-current="page">Credentials</li>
          </ol>
        </nav>
      </div>
      <div class="content-viewport">
        <div class="row">
          <div class="col-12 pb-4 pt-2">
            <h4>Manage Credentials</h4>
          </div>
        </div>
        
        <div id="app">
          <credentials-component></credentials-component>
        </div>

      </div>
    </div>
   
    @include('footer')
    
  </div>


@endsection