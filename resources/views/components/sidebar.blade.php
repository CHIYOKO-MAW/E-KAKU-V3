@php $role = auth()->check() ? auth()->user()->role : null; @endphp

<div class="p-3">
  <ul class="nav flex-column">
    <li class="nav-item mb-1">
      <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('landing') }}"><i class="fa fa-home me-2"></i>Beranda</a>
    </li>

    @auth
      <li class="nav-item mb-1">
        @if($role === 'atasan')
          <a class="nav-link {{ request()->routeIs('atasan.*') ? 'active' : '' }}" href="{{ route('atasan.dashboard') }}"><i class="fa fa-chart-line me-2"></i>Dashboard Atasan</a>
        @elseif($role === 'admin')
          <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard Admin</a>
        @else
          <a class="nav-link {{ request()->routeIs('dashboard.user') ? 'active' : '' }}" href="{{ route('dashboard.user') }}"><i class="fa fa-user me-2"></i>Dashboard Saya</a>
        @endif
      </li>

      <li class="nav-item mb-1">
        <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}"><i class="fa fa-id-card me-2"></i>Profil & Biodata</a>
      </li>

      <li class="nav-item mb-1">
        <a class="nav-link {{ request()->is('upload*') ? 'active' : '' }}" href="{{ route('upload.index') }}"><i class="fa fa-upload me-2"></i>Dokumen</a>
      </li>

      @if($role === 'admin')
        <li class="nav-item mb-1">
          <a class="nav-link {{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}" href="{{ route('admin.verifikasi.index') }}"><i class="fa fa-user-check me-2"></i>Verifikasi</a>
        </li>
      @endif
    @endauth
  </ul>
</div>
