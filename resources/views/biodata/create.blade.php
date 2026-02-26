@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-8">
    <h1 class="mb-6 text-2xl font-bold">Isi Biodata</h1>

    <form method="POST" action="{{ route('biodata.store') }}" class="space-y-4 rounded-lg bg-white p-6 shadow">
        @csrf
        @include('biodata.partials.form-fields')
        <button class="rounded-md bg-disnaker-500 px-4 py-2 text-white hover:bg-disnaker-600" type="submit">Simpan</button>
    </form>
</div>
@endsection
