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
              <a href="{{ route('meters')}}">Meters</a>
            </li>
          </ol>
        </nav>
      </div>
      <div class="content-viewport">
        <div class="row">
          <div class="col-12 pb-4 pt-2">
            <h4>Meters</h4>
            @isset($lastLoginDate)
              <p class="text-gray">Last login {{ $lastLoginDate }}</p>     
            @endisset
          </div>
        </div>
        <div id="app">
          <subscriber-meters-component></subscriber-meters-component>
        </div>
      </div>
    </div>

    @include('footer')
    
  </div>

@endsection