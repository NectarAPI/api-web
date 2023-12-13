@extends('app')

@section('body')

<body>

    @yield('main-content')

    <script src="{{ asset('vendors/js/core.js') }}"></script>
    <script src="{{ asset('vendors/js/vendor.addons.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
  
  </body>

@endsection