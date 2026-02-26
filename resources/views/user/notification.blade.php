@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="page-wrap">
    <div class="mb-6 rounded-xl bg-white p-6 card-shadow">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Notifikasi Saya</h1>
                <p class="mt-1 text-sm text-gray-600">Info validasi biodata, reminder status, dan pembaruan sistem.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                    {{ $unreadCount }} belum dibaca
                </span>
                @if ($unreadCount > 0)
                    <a href="{{ route('notifikasi.index', ['mark_read' => 1]) }}" class="rounded-md border border-disnaker-200 px-3 py-1.5 text-xs font-medium text-disnaker-600 hover:bg-disnaker-50">
                        Tandai semua dibaca
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl bg-white card-shadow">
        @forelse ($notes as $note)
            <div class="border-b border-gray-100 px-6 py-4 {{ $note->status_baca ? 'bg-white' : 'bg-blue-50' }}">
                <div class="flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $note->judul }}</p>
                        <p class="mt-1 text-sm text-gray-600">{{ $note->pesan }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ $note->created_at?->format('d M Y H:i') }}</p>
                    </div>
                    @if (! $note->status_baca)
                        <form method="POST" action="{{ route('notifikasi.read', $note) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-md border border-disnaker-200 px-3 py-1.5 text-xs font-medium text-disnaker-600 hover:bg-disnaker-50">
                                Tandai Dibaca
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center">
                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
                    <i class="fas fa-bell-slash text-gray-400"></i>
                </div>
                <p class="text-sm text-gray-500">Belum ada notifikasi.</p>
            </div>
        @endforelse
    </div>

    @if (method_exists($notes, 'links'))
        <div class="mt-4">{{ $notes->links() }}</div>
    @endif
</div>
@endsection
