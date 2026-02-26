@extends('layouts.app')

@section('title', 'Redirect Biodata')

@section('content')
<div class="page-wrap">
    <div class="rounded-xl bg-white p-6 text-center card-shadow">
        <h1 class="text-xl font-semibold text-gray-900">Halaman Dipindahkan</h1>
        <p class="mt-2 text-sm text-gray-600">Pengisian biodata sekarang berada di halaman Profil.</p>
        <a href="{{ route('profile.edit') }}#biodata" class="btn-primary mt-4">
            <i class="fas fa-arrow-right mr-2"></i>Buka Profil dan Isi Biodata
        </a>
    </div>
</div>
@endsection
