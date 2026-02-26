<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'e-Kaku V3') }} - @yield('title', 'Digital Yellow Card')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans text-gray-900">
    <div id="app">
        @if (View::hasSection('navigation'))
            @yield('navigation')
        @elseif (auth()->check() && auth()->user()->role === 'atasan')
            @include('layouts.navigation-atasan')
        @elseif (auth()->check() && auth()->user()->role === 'admin')
            @include('layouts.navigation-admin')
        @elseif (auth()->check())
            @include('layouts.navigation-user')
        @else
            @include('layouts.navigation-guest')
        @endif

        <main class="min-h-screen">
            @if (session('success'))
                <div class="mx-auto mt-4 max-w-7xl rounded-md border border-green-300 bg-green-50 px-4 py-3 text-green-800" role="alert">
                    <strong class="font-semibold">Sukses:</strong> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mx-auto mt-4 max-w-7xl rounded-md border border-red-300 bg-red-50 px-4 py-3 text-red-800" role="alert">
                    <strong class="font-semibold">Error:</strong> {{ session('error') }}
                </div>
            @endif

            @if (session('info'))
                <div class="mx-auto mt-4 max-w-7xl rounded-md border border-blue-300 bg-blue-50 px-4 py-3 text-blue-800" role="alert">
                    <strong class="font-semibold">Info:</strong> {{ session('info') }}
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <footer class="border-t border-gray-200 bg-white py-6">
            <div class="mx-auto max-w-7xl px-4 text-center text-sm text-gray-600 sm:px-6 lg:px-8">
                <p>&copy; {{ date('Y') }} Dinas Tenaga Kerja Pandeglang. All rights reserved.</p>
                <p class="mt-1 text-xs text-gray-500">e-Kaku V3 - Digital Yellow Card System</p>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
