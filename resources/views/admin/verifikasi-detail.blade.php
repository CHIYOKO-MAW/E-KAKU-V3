@extends('layouts.app')

@section('title', 'Detail Verifikasi')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
  <div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Detail Verifikasi</h1>
    <a href="{{ route('admin.verifikasi.index') }}" class="btn-secondary">Kembali</a>
  </div>

  <div class="rounded-xl bg-white p-6 card-shadow">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 text-sm">
      <div><span class="font-semibold">Nama:</span> {{ $biodata->user->name }}</div>
      <div><span class="font-semibold">NIK:</span> {{ $biodata->nik }}</div>
      <div><span class="font-semibold">Tempat Lahir:</span> {{ $biodata->tempat_lahir }}</div>
      <div><span class="font-semibold">Tanggal Lahir:</span> {{ optional($biodata->tanggal_lahir)->format('d M Y') ?? $biodata->tanggal_lahir }}</div>
      <div><span class="font-semibold">Pendidikan:</span> {{ $biodata->pendidikan }}</div>
      <div class="sm:col-span-2"><span class="font-semibold">Alamat:</span> {{ $biodata->alamat }}</div>
      <div class="sm:col-span-2"><span class="font-semibold">Keahlian:</span> {{ $biodata->keahlian ?: '-' }}</div>
    </div>

    <h2 class="mt-8 text-lg font-semibold text-gray-900">Dokumen Upload</h2>
    <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
      @forelse($biodata->user->uploads as $upload)
        <div class="rounded-lg border border-gray-200 p-4">
          <p class="font-medium text-gray-800">{{ strtoupper($upload->jenis_dokumen) }}</p>
          <a href="{{ route('upload.preview', $upload) }}" class="mt-2 inline-flex text-sm font-semibold text-disnaker-600 hover:underline" target="_blank">Lihat Dokumen</a>
        </div>
      @empty
        <p class="text-sm text-gray-500">Belum ada dokumen diunggah.</p>
      @endforelse
    </div>

    <div class="mt-8 rounded-lg border border-gray-200 p-4">
      <h3 class="text-sm font-semibold text-gray-900">Aksi Verifikasi</h3>
      <div class="mt-3 flex flex-wrap items-center gap-3">
        <form action="{{ route('admin.verifikasi.updateStatus', $biodata) }}" method="POST">
          @csrf
          <input type="hidden" name="status" value="verified">
          <button class="rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700" type="submit">Setujui</button>
        </form>

        <form action="{{ route('admin.verifikasi.updateStatus', $biodata) }}" method="POST" class="flex flex-wrap items-center gap-2">
          @csrf
          <input type="hidden" name="status" value="rejected">
          <input type="text" name="catatan" class="form-input" placeholder="Catatan penolakan (opsional)">
          <button class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700" type="submit">Tolak</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
