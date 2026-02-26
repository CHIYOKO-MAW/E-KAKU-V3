<nav class="navbar navbar-expand-lg" style="background:#004B8D;">
  <div class="container-fluid">
    <a class="navbar-brand text-white d-flex align-items-center" href="{{ route('landing') }}">
      <img src="{{ asset('logo.png') }}" alt="logo" style="height:34px; margin-right:8px;">
      <span class="fw-bold">E-KAKU V3</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsMain">
      <ul class="navbar-nav ms-auto">
        @guest
          @if(Route::has('login'))
            <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}">Login</a></li>
          @endif
          @if(Route::has('register'))
            <li class="nav-item"><a class="nav-link text-white" href="{{ route('register') }}">Daftar</a></li>
          @endif
        @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">{{ auth()->user()->name }}</a>
            <ul class="dropdown-menu dropdown-menu-end">
              @if(Route::has('profile.edit'))
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
              @endif
              <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                  @csrf
                  <button class="dropdown-item">Logout</button>
                </form>
              </li>
            </ul>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
