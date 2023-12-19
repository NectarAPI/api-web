@extends('header')

@section('title')
Configurations
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
            <li class="breadcrumb-item active" aria-current="page">Configurations</li>
          </ol>
        </nav>
      </div>

      <div id="app">

        <base-configurations-component nectar-public-key="{{ config('config-service.nectar_public_key')}}"></base-configurations-component>

      </div>      

    </div>
    
    @include('footer')
    
  </div>

@endsection