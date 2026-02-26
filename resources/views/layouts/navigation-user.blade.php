@php
    $currentUser = auth()->user();
    $unreadNotes = $currentUser->notificationsE()->where('status_baca', false)->count();
    $latestNotes = $currentUser->notificationsE()->latest()->take(5)->get();
@endphp

<nav class="sticky top-0 z-50 border-b border-gray-200 bg-white" x-data="{ mobileOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <a href="{{ route('dashboard.user') }}" class="flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-disnaker-500 text-white">
                    <i class="fas fa-id-card text-sm"></i>
                </span>
                <span class="font-bold text-gray-900">e-Kaku V3</span>
            </a>

            <div class="hidden items-center gap-6 sm:flex">
                <a href="{{ route('dashboard.user') }}" class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium {{ request()->routeIs('dashboard') || request()->routeIs('dashboard.user') ? 'border-disnaker-500 text-disnaker-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium {{ request()->routeIs('profile.*') ? 'border-disnaker-500 text-disnaker-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                    <i class="fas fa-user mr-2"></i> Profil
                </a>
                <a href="{{ route('status.index') }}" class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium {{ request()->routeIs('status.*') ? 'border-disnaker-500 text-disnaker-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                    <i class="fas fa-sync-alt mr-2"></i> Update Status
                </a>
                <a href="{{ route('kartu.show') }}" class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium {{ request()->routeIs('kartu.*') ? 'border-disnaker-500 text-disnaker-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                    <i class="fas fa-id-card mr-2"></i> Kartu Digital
                </a>
            </div>

            <div class="hidden items-center sm:flex">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative rounded-full p-2 text-gray-500 transition hover:bg-gray-100 hover:text-disnaker-600">
                        <i class="fas fa-bell text-lg"></i>
                        @if ($unreadNotes > 0)
                            <span class="absolute -right-0.5 -top-0.5 inline-flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-500 px-1 text-xs text-white">
                                {{ $unreadNotes > 9 ? '9+' : $unreadNotes }}
                            </span>
                        @endif
                    </button>

                    <div x-cloak x-show="open" @click.away="open = false" class="absolute right-0 z-50 mt-2 w-80 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg">
                        <div class="border-b border-gray-100 px-4 py-3">
                            <p class="font-semibold text-gray-900">Notifikasi</p>
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            @forelse ($latestNotes as $note)
                                <div class="border-b border-gray-100 px-4 py-3 {{ $note->status_baca ? 'bg-white' : 'bg-blue-50' }}">
                                    <p class="text-sm font-medium text-gray-900">{{ $note->judul }}</p>
                                    <p class="mt-1 text-xs text-gray-600">{{ $note->pesan }}</p>
                                    <p class="mt-1 text-xs text-gray-500">{{ $note->created_at?->diffForHumans() }}</p>
                                </div>
                            @empty
                                <p class="px-4 py-6 text-center text-sm text-gray-500">Belum ada notifikasi.</p>
                            @endforelse
                        </div>
                        <a href="{{ route('notifikasi.index', ['mark_read' => 1]) }}" class="block border-t border-gray-100 px-4 py-3 text-sm font-medium text-disnaker-600 hover:bg-gray-50">
                            Lihat semua notifikasi
                        </a>
                    </div>
                </div>

                <div class="ml-3 relative" x-data="{ open: false }">
                    <button @click="open = !open" class="rounded-full bg-disnaker-500 p-0.5 text-white ring-disnaker-500 transition focus:outline-none focus:ring-2 focus:ring-offset-2">
                        @if ($currentUser->profile_photo_url)
                            <img src="{{ $currentUser->profile_photo_url }}" alt="Avatar" class="h-8 w-8 rounded-full object-cover">
                        @else
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-disnaker-500 text-sm font-semibold">
                                {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                            </span>
                        @endif
                    </button>

                    <div x-cloak x-show="open" @click.away="open = false" class="absolute right-0 z-50 mt-2 w-56 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg">
                        <div class="border-b border-gray-100 px-4 py-3">
                            <p class="text-sm font-semibold text-gray-900">{{ $currentUser->name }}</p>
                            <p class="text-xs text-gray-500">{{ $currentUser->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-user mr-2"></i> Profil Saya
                        </a>
                        <a href="{{ route('profile.edit') }}#biodata" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-address-card mr-2"></i> Isi Biodata
                        </a>
                        <a href="{{ route('notifikasi.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-bell mr-2"></i> Notifikasi
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <button @click="mobileOpen = !mobileOpen" class="rounded-md p-2 text-gray-500 hover:bg-gray-100 sm:hidden">
                <i class="fas" :class="mobileOpen ? 'fa-times' : 'fa-bars'"></i>
            </button>
        </div>
    </div>

    <div x-cloak x-show="mobileOpen" class="sm:hidden border-t border-gray-200 bg-white">
        <div class="space-y-1 px-2 py-3">
            <a href="{{ route('dashboard.user') }}" class="block rounded-md px-3 py-2 text-sm {{ request()->routeIs('dashboard') || request()->routeIs('dashboard.user') ? 'bg-disnaker-50 text-disnaker-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Dashboard</a>
            <a href="{{ route('profile.edit') }}" class="block rounded-md px-3 py-2 text-sm {{ request()->routeIs('profile.*') ? 'bg-disnaker-50 text-disnaker-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Profil</a>
            <a href="{{ route('profile.edit') }}#biodata" class="block rounded-md px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Isi Biodata</a>
            <a href="{{ route('status.index') }}" class="block rounded-md px-3 py-2 text-sm {{ request()->routeIs('status.*') ? 'bg-disnaker-50 text-disnaker-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Update Status</a>
            <a href="{{ route('kartu.show') }}" class="block rounded-md px-3 py-2 text-sm {{ request()->routeIs('kartu.*') ? 'bg-disnaker-50 text-disnaker-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Kartu Digital</a>
            <a href="{{ route('notifikasi.index') }}" class="block rounded-md px-3 py-2 text-sm {{ request()->routeIs('notifikasi.*') ? 'bg-disnaker-50 text-disnaker-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Notifikasi</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-md px-3 py-2 text-left text-sm text-gray-700 hover:bg-gray-50">Keluar</button>
            </form>
        </div>
    </div>
</nav>
