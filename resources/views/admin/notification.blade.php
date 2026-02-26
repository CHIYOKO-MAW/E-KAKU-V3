@extends('layouts.app')

@section('title', 'Notifikasi Admin')

@section('content')
<div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-6 rounded-xl bg-white p-6 card-shadow">
        <h1 class="text-2xl font-bold text-gray-900">Kirim Notifikasi</h1>
        <p class="mt-1 text-sm text-gray-600">Kirim pemberitahuan manual ke satu atau banyak pengguna.</p>
    </div>

    <div class="rounded-xl bg-white p-6 card-shadow">
        <form method="POST" action="{{ route('notifikasi.send') }}" class="space-y-4">
            @csrf
            <div>
                <label class="form-label" for="judul">Judul</label>
                <input id="judul" name="judul" class="form-input" required value="{{ old('judul') }}">
            </div>
            <div>
                <label class="form-label" for="pesan">Pesan</label>
                <textarea id="pesan" name="pesan" class="form-input" rows="4" required>{{ old('pesan') }}</textarea>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="form-label" for="user_id">User ID Tunggal (opsional)</label>
                    <input id="user_id" name="user_id" type="number" min="1" class="form-input" value="{{ old('user_id') }}" placeholder="Contoh: 12">
                </div>
                <div>
                    <label class="form-label" for="user_ids">User ID Massal (opsional)</label>
                    <input id="user_ids" name="user_ids" class="form-input" value="{{ old('user_ids') }}" placeholder="Contoh: 3,10,22">
                </div>
            </div>
            <p class="text-xs text-gray-500">Isi minimal salah satu: User ID Tunggal atau User ID Massal.</p>
            <button type="submit" class="btn-primary">
                <i class="fas fa-paper-plane mr-2"></i>Kirim Notifikasi
            </button>
        </form>
    </div>
</div>
@endsection
