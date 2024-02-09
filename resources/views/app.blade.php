<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nectar API | @yield('title') </title>

    <link rel="stylesheet" href="{{ asset('vendors/iconfonts/mdi/css/materialdesignicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.addons.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/shared/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

    @vite('resources/js/app.js')

    <style>
      .modal-backdrop {
        opacity: 0.5 !important;
      }

      .modal-footer {
        position: relative;
        width: 100%;
      }
    </style>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FJ8NS8937Y"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-FJ8NS8937Y');
    </script>

  </head>

  @yield('body')
  
</html>