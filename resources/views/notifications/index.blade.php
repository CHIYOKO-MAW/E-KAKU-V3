@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-8">
  <h1 class="mb-6 text-2xl font-bold text-gray-900">Notifikasi</h1>

  @php
    $notes = auth()->user()->notificationsE()->latest()->get();
  @endphp

  <div class="space-y-3">
    @forelse($notes as $note)
      <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
        <div class="flex items-start justify-between gap-4">
          <div>
            <p class="font-semibold text-gray-900">{{ $note->judul }}</p>
            <p class="mt-1 text-sm text-gray-600">{{ $note->pesan }}</p>
          </div>
          <div class="text-right">
            @if(!$note->status_baca)
              <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700">Baru</span>
            @else
              <span class="text-xs text-gray-500">Sudah dibaca</span>
            @endif
            <div class="mt-1 text-xs text-gray-500">{{ $note->created_at->diffForHumans() }}</div>
          </div>
        </div>
      </div>
    @empty
      <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 text-blue-800">Belum ada notifikasi.</div>
    @endforelse
  </div>
</div>
@endsection
