@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl px-4 py-8">
  <div class="rounded-lg bg-white p-6 shadow">
    <h1 class="text-2xl font-bold text-gray-900">Detail Biodata - {{ $biodata->user->name }}</h1>

    <div class="mt-6 grid grid-cols-1 gap-3 text-sm text-gray-700 md:grid-cols-2">
      <div><span class="font-semibold">NIK:</span> {{ $biodata->nik }}</div>
      <div><span class="font-semibold">Tempat Lahir:</span> {{ $biodata->tempat_lahir }}</div>
      <div><span class="font-semibold">Tanggal Lahir:</span> {{ $biodata->tanggal_lahir }}</div>
      <div><span class="font-semibold">Pendidikan:</span> {{ $biodata->pendidikan }}</div>
      <div class="md:col-span-2"><span class="font-semibold">Alamat:</span> {{ $biodata->alamat }}</div>
    </div>

    <h2 class="mt-6 text-lg font-semibold text-gray-900">Dokumen Upload</h2>
    <div class="mt-3 grid gap-3 sm:grid-cols-2">
      @forelse($biodata->user->uploads as $upload)
        <div class="rounded-md border border-gray-200 p-3">
          <p class="font-medium text-gray-800">{{ strtoupper($upload->jenis_dokumen) }}</p>
          <a href="{{ route('upload.preview', $upload->id) }}" target="_blank" class="text-sm text-disnaker-600 hover:underline">Lihat Dokumen</a>
        </div>
      @empty
        <p class="text-sm text-gray-500">Belum ada dokumen.</p>
      @endforelse
    </div>

    <div class="mt-6 flex gap-2">
      <form action="{{ route('verifikasi.updateStatus', $biodata->id) }}" method="POST">
        @csrf
        <input type="hidden" name="status" value="verified">
        <button class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700">Setujui</button>
      </form>
      <form action="{{ route('verifikasi.updateStatus', $biodata->id) }}" method="POST">
        @csrf
        <input type="hidden" name="status" value="rejected">
        <button class="rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700">Tolak</button>
      </form>
    </div>
  </div>
</div>
@endsection
