@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="mb-3">Preview Dokumen</h2>

  <div class="card p-3">
    <p><strong>Nama File:</strong> {{ basename($upload->file_path) }}</p>
    <p><strong>Jenis:</strong> {{ $upload->jenis_dokumen }}</p>
    <p><strong>User:</strong> {{ $upload->user->name ?? '-' }}</p>

    @php
      $ext = pathinfo($upload->file_path, PATHINFO_EXTENSION);
      $url = Storage::url($upload->file_path);
    @endphp

    @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
      <img src="{{ $url }}" alt="preview" class="img-fluid" />
    @else
      <p><a href="{{ $url }}" target="_blank">Download / Lihat Dokumen</a></p>
    @endif

    <a href="{{ route('upload.index') }}" class="btn btn-secondary mt-3">Kembali</a>
  </div>
</div>
@endsection
