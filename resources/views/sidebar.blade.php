<div class="sidebar">
    <div class="user-profile">
      <div class="display-avatar">
        @if($user->imageURL != '')
          <img class="profile-img img-lg rounded-circle" src='{{ url($user->imageURL) }}' alt="profile image" />
        @else
          <img class="profile-img img-lg rounded-circle" src="{{ asset('images/profile/avatar.png') }}" alt="profile image">
        @endif
      </div>
      <div class="info-wrapper">
        <p class="user-name">{{ $user->firstName }} {{ $user->lastName }}</p>
        <small class="text-muted">{{ $user->ref }}</small>
        <div id="app-1">
          <buy-credits-component>
          </buy-credits-component>
        </div>
      </div>
    </div>
    <ul class="navigation-menu">
      <li class="nav-category-divider">LINKS</li>
      <li>
        <a href="{{ route('dashboard') }}">
          <span class="link-title">Dashboard</span>
          <i class="mdi mdi-monitor-dashboard link-icon"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('requests') }}">
          <span class="link-title">Requests</span>
          <i class="mdi mdi-ray-start-arrow link-icon"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('credentials') }}">
          <span class="link-title">Credentials</span>
          <i class="mdi mdi-settings-box link-icon"></i>
        </a>
      </li>      <li>
        <a href="{{ route('utilities') }}">
          <span class="link-title">Utilities</span>
          <i class="mdi mdi-domain link-icon"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('meters') }}">
          <span class="link-title">Meters</span>
          <i class="mdi mdi-gauge link-icon"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('subscribers') }}">
          <span class="link-title">Subscribers</span>
          <i class="mdi mdi-account-multiple link-icon"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('public-keys') }}">
          <span class="link-title">Public Keys</span>
          <i class="mdi mdi-key-variant link-icon"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('configurations') }}">
          <span class="link-title">Configurations</span>
          <i class="mdi mdi-adjust link-icon"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('credits') }}">
          <span class="link-title">Credits</span>
          <i class="mdi mdi-credit-card link-icon"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('notifications') }}">
          <span class="link-title">Notifications</span>
          <i class="mdi mdi-notification-clear-all link-icon"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('simulators') }}">
          <span class="link-title">Simulators</span>
          <i class="mdi mdi-blur link-icon"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('profile') }}">
          <span class="link-title">Profile</span>
          <i class="mdi mdi-account link-icon"></i>
        </a>
      </li>
      <li class="nav-category-divider">DOCS</li>
      <li>
        <a href="{{ route('docs') }}">
          <span class="link-title">Documentation</span>
          <i class="mdi mdi-asterisk link-icon"></i>
        </a>
      </li>
      <li>
        <a href="https://nectar.software/blog/?p=93">
          <span class="link-title">Tutorial</span>
          <i class="mdi mdi-asterisk link-icon"></i>
        </a>
      </li>
    </ul>
  </div>