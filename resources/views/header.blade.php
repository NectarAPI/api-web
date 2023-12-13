@extends('app')

@section('body')

<body class="header-fixed">

    <nav class="t-header">
        <div class="t-header-brand-wrapper">
          <a href="{{ route('dashboard') }}">
            <img class="logo" src="{{ asset('images/logo.svg') }}" alt="">
            <img class="logo-mini" src="{{ asset('images/logo_mini.svg') }}" alt="">
          </a>
        </div>
        <div class="t-header-content-wrapper">
          <div class="t-header-content">
            <button class="t-header-toggler t-header-mobile-toggler d-block d-lg-none">
              <i class="mdi mdi-menu"></i>
            </button>
            {{-- <form action="#" class="t-header-search-box">
              <div class="input-group">
                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search" autocomplete="off">
                <button class="btn btn-primary" type="submit"><i class="mdi mdi-arrow-right-thick"></i></button>
              </div>
            </form> --}}
            <ul class="nav ml-auto">
              <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="notificationDropdown" data-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-bell-outline mdi-1x"></i>
                </a>
                <div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="notificationDropdown">
                  <div class="dropdown-header">
                    <h6 class="dropdown-title">Notifications</h6>
                    <p class="dropdown-title-text">You have {{ count($notifications)}} unread notifications</p>
                  </div>
                  <div class="dropdown-body">
                    <div class="dropdown-body">
                  
                      @foreach ( $notifications as $notification)    
                        <div class="dropdown-list">
                          <div class="icon-wrapper rounded-circle bg-inverse-warning text-warning">
                            <i class="mdi mdi-security"></i>
                          </div>
                          <div class="content-wrapper">
                            <small class="name">{{ $notification['subject'] }}</small>
                            <small style="display: block" class="content-text">{{ substr($notification['text'], 69) }}</small>
                          </div>
                        </div>
                      @endforeach

                    </div>
                  </div>
                  <div class="dropdown-footer">
                    <a href="{{ route('notifications') }}">View All</a>
                  </div>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="notificationDropdown" data-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-settings mdi-1x"></i>
                </a>
                <div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="notificationDropdown">
                  <div class="dropdown-body">
                    <div class="dropdown-list">
                      <div class="icon-wrapper rounded-circle bg-inverse-warning text-warning">
                        <i class="mdi mdi-account-settings"></i>
                      </div>
                      <div class="content-wrapper">
                        <small class="name"><a href="{{ route('profile') }}">Profile</a></small>
                      </div>
                    </div>
                    <div class="dropdown-list">
                      <div class="icon-wrapper rounded-circle bg-inverse-warning text-warning">
                        <i class="mdi mdi-logout"></i>
                      </div>
                      <div class="content-wrapper">
                        <small class="name"><a href="{{ route('logout') }}">Logout</a></small>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="page-body">

        @include('sidebar')
      
        @yield('page-body')

      </div>

      <script src="{{ asset('vendors/js/core.js') }}"></script>
      <script src="{{ asset('js/template.js') }}"></script>

</body>

@endsection