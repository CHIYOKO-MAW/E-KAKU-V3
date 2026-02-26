@extends('layouts.app')

@section('title', 'Redirect Biodata')

@section('content')
<div class="page-wrap">
    <div class="rounded-xl bg-white p-6 text-center card-shadow">
        <h1 class="text-xl font-semibold text-gray-900">Biodata Menyatu dengan Profil</h1>
        <p class="mt-2 text-sm text-gray-600">Silakan isi atau perbarui biodata di halaman Profil.</p>
        <a href="{{ route('profile.edit') }}#biodata" class="btn-primary mt-4">
            <i class="fas fa-address-card mr-2"></i>Ke Form Biodata di Profil
        </a>
    </div>
</div>
@endsection
