<nav>
    <a href="{{ url('/') }}">Home</a>

    @auth
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span>{{ Auth::user()->name }}</span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @endauth

    @guest
        <a href="{{ route('login') }}">Login</a>
    @endguest
</nav>
