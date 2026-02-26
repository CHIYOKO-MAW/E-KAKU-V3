@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-8">
  <h1 class="mb-6 text-2xl font-bold text-gray-900">Upload Dokumen</h1>

  <div class="rounded-lg bg-white p-6 shadow">
    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf

      <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">Jenis Dokumen</label>
        <select name="jenis_dokumen" class="w-full rounded-md border-gray-300" required>
          <option value="">-- Pilih --</option>
          <option value="ktp">KTP</option>
          <option value="ijazah">Ijazah</option>
          <option value="foto">Foto</option>
        </select>
        @error('jenis_dokumen') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">File (jpg/png/pdf, max 5MB)</label>
        <input type="file" name="file" class="w-full rounded-md border-gray-300" required>
        @error('file') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
      </div>

      <div class="flex gap-2">
        <button class="rounded-md bg-disnaker-500 px-4 py-2 text-white hover:bg-disnaker-600">Upload</button>
        <a href="{{ route('upload.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-100">Kembali</a>
      </div>
    </form>
  </div>
</div>
@endsection
