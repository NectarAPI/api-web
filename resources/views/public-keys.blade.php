@extends('header')

@section('title')
Public Keys
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
            <li class="breadcrumb-item active" aria-current="page">Public Keys</li>
          </ol>
        </nav>
      </div>
      <div class="content-viewport">
        <div class="row">
          <div class="col-12 pb-4 pt-2">
            <h4>Manage Public Keys</h4>
          </div>
        </div>

        <div id="app">
          <public-keys-component></public-keys-component>
        </div>
        
      </div>
    </div>
    
    @include('footer')
    
  </div>

@endsection