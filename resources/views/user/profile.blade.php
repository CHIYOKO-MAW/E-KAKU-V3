@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
@php
    $progressFields = [
        'nik' => $biodata?->nik,
        'tempat_lahir' => $biodata?->tempat_lahir,
        'tanggal_lahir' => $biodata?->tanggal_lahir,
        'alamat' => $biodata?->alamat,
        'pendidikan' => $biodata?->pendidikan,
        'keahlian' => $biodata?->keahlian,
    ];
    $completedFields = collect($progressFields)->filter(fn ($value) => filled($value))->count();
    $totalFields = count($progressFields);
    $completionPercentage = $totalFields > 0 ? (int) round(($completedFields / $totalFields) * 100) : 0;
    $validUntil = $user->kartuKuning?->tanggal_cetak
        ? \Carbon\Carbon::parse($user->kartuKuning->tanggal_cetak)->addYears(5)
        : null;

@endphp
<div class="page-wrap">
    <div class="rounded-xl bg-white p-6 card-shadow">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-disnaker-100">
                    <i class="fas fa-user text-2xl text-disnaker-600"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                </div>
            </div>
            <a href="{{ route('dashboard.user') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <div class="rounded-xl bg-white p-6 card-shadow">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Informasi Akun</h2>
                <form method="POST" action="{{ route('profile.update') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input id="name" name="name" type="text" class="form-input" required value="{{ old('name', $user->name) }}">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" class="form-input" required value="{{ old('email', $user->email) }}">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Simpan Informasi Akun
                        </button>
                    </div>
                </form>
            </div>

            <div id="biodata" class="rounded-xl bg-white p-6 card-shadow">
                <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Form Biodata Pencari Kerja</h2>
                        <p class="mt-1 text-sm text-gray-600">Acuan pengisian disesuaikan dengan format E-Kaku v2 yang dipakai Disnaker.</p>
                    </div>
                    @if ($biodata?->status_verifikasi === 'verified')
                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Terverifikasi</span>
                    @elseif ($biodata?->status_verifikasi === 'rejected')
                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Ditolak</span>
                    @elseif ($biodata)
                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">Menunggu Validasi Admin</span>
                    @else
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">Belum Diisi</span>
                    @endif
                </div>

                <form method="POST" action="{{ $biodata ? route('biodata.update') : route('biodata.store') }}" class="space-y-6">
                    @csrf
                    @if ($biodata)
                        @method('PUT')
                    @endif

                    <div class="rounded-lg border border-gray-200 p-4">
                        <h3 class="mb-4 text-base font-semibold text-disnaker-700">Informasi Pribadi</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="nik" class="form-label">NIK</label>
                                <input id="nik" name="nik" type="text" class="form-input" required value="{{ old('nik', $biodata->nik ?? '') }}">
                                @error('nik') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-input bg-gray-100" value="{{ $user->name }}" disabled>
                            </div>
                            <div>
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input id="tempat_lahir" name="tempat_lahir" type="text" class="form-input" required value="{{ old('tempat_lahir', $biodata->tempat_lahir ?? '') }}">
                                @error('tempat_lahir') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input id="tanggal_lahir" name="tanggal_lahir" type="date" class="form-input" required value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ?? '') }}">
                                @error('tanggal_lahir') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-input" required>{{ old('alamat', $biodata->alamat ?? '') }}</textarea>
                                @error('alamat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="form-input">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="laki_laki" @selected(old('jenis_kelamin', $biodata->jenis_kelamin ?? '') === 'laki_laki')>Laki-laki</option>
                                    <option value="perempuan" @selected(old('jenis_kelamin', $biodata->jenis_kelamin ?? '') === 'perempuan')>Perempuan</option>
                                </select>
                                @error('jenis_kelamin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="agama" class="form-label">Agama</label>
                                <input id="agama" name="agama" type="text" class="form-input" value="{{ old('agama', $biodata->agama ?? '') }}" placeholder="Contoh: Islam">
                                @error('agama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="rt_rw" class="form-label">RT/RW</label>
                                <input id="rt_rw" name="rt_rw" type="text" class="form-input" value="{{ old('rt_rw', $biodata->rt_rw ?? '') }}" placeholder="Contoh: 002/005">
                                @error('rt_rw') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="kode_pos" class="form-label">Kode Pos</label>
                                <input id="kode_pos" name="kode_pos" type="text" class="form-input" value="{{ old('kode_pos', $biodata->kode_pos ?? '') }}" placeholder="Contoh: 42211">
                                @error('kode_pos') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input id="kecamatan" name="kecamatan" type="text" class="form-input" value="{{ old('kecamatan', $biodata->kecamatan ?? '') }}" placeholder="Contoh: Pandeglang">
                                @error('kecamatan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="desa_kelurahan" class="form-label">Desa/Kelurahan</label>
                                <input id="desa_kelurahan" name="desa_kelurahan" type="text" class="form-input" value="{{ old('desa_kelurahan', $biodata->desa_kelurahan ?? '') }}" placeholder="Contoh: Pandeglang">
                                @error('desa_kelurahan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                                <select id="status_perkawinan" name="status_perkawinan" class="form-input">
                                    <option value="">Pilih Status Perkawinan</option>
                                    <option value="belum_menikah" @selected(old('status_perkawinan', $biodata->status_perkawinan ?? '') === 'belum_menikah')>Belum Menikah</option>
                                    <option value="menikah" @selected(old('status_perkawinan', $biodata->status_perkawinan ?? '') === 'menikah')>Menikah</option>
                                    <option value="cerai_hidup" @selected(old('status_perkawinan', $biodata->status_perkawinan ?? '') === 'cerai_hidup')>Cerai Hidup</option>
                                    <option value="cerai_mati" @selected(old('status_perkawinan', $biodata->status_perkawinan ?? '') === 'cerai_mati')>Cerai Mati</option>
                                </select>
                                @error('status_perkawinan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                <input id="tinggi_badan" name="tinggi_badan" type="number" class="form-input" min="50" max="250" value="{{ old('tinggi_badan', $biodata->tinggi_badan ?? '') }}">
                                @error('tinggi_badan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                <input id="berat_badan" name="berat_badan" type="number" class="form-input" min="20" max="300" value="{{ old('berat_badan', $biodata->berat_badan ?? '') }}">
                                @error('berat_badan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <input type="hidden" name="disabilitas" value="0">
                                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox" name="disabilitas" value="1" class="rounded border-gray-300 text-disnaker-600 focus:ring-disnaker-500"
                                        @checked((bool) old('disabilitas', $biodata->disabilitas ?? false))>
                                    Penyandang disabilitas
                                </label>
                                @error('disabilitas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border border-gray-200 p-4">
                        <h3 class="mb-4 text-base font-semibold text-disnaker-700">Pendidikan dan Pengalaman</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                                <input id="pendidikan" name="pendidikan" type="text" class="form-input" required value="{{ old('pendidikan', $biodata->pendidikan ?? '') }}">
                                @error('pendidikan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                                <input id="tahun_lulus" name="tahun_lulus" type="text" class="form-input" value="{{ old('tahun_lulus', $biodata->tahun_lulus ?? '') }}" placeholder="Contoh: 2020">
                                @error('tahun_lulus') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="institusi_pendidikan" class="form-label">Nama Institusi Pendidikan</label>
                                <input id="institusi_pendidikan" name="institusi_pendidikan" type="text" class="form-input" value="{{ old('institusi_pendidikan', $biodata->institusi_pendidikan ?? '') }}">
                                @error('institusi_pendidikan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <input id="jurusan" name="jurusan" type="text" class="form-input" value="{{ old('jurusan', $biodata->jurusan ?? '') }}">
                                @error('jurusan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="keahlian" class="form-label">Keterampilan / Keahlian</label>
                                <textarea id="keahlian" name="keahlian" class="form-input" placeholder="Contoh: Microsoft Office, Administrasi, Bahasa Inggris">{{ old('keahlian', $biodata->keahlian ?? '') }}</textarea>
                                @error('keahlian') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="pengalaman" class="form-label">Pengalaman Kerja</label>
                                <textarea id="pengalaman" name="pengalaman" class="form-input" placeholder="Ringkasan pengalaman kerja Anda">{{ old('pengalaman', $biodata->pengalaman ?? '') }}</textarea>
                                @error('pengalaman') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="tujuan_lamaran" class="form-label">Tempat/Tujuan Melamar</label>
                                <input id="tujuan_lamaran" name="tujuan_lamaran" type="text" class="form-input" value="{{ old('tujuan_lamaran', $biodata->tujuan_lamaran ?? '') }}" placeholder="Contoh: PT Maju Bersama">
                                @error('tujuan_lamaran') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border border-gray-200 p-4">
                        <h3 class="mb-2 text-base font-semibold text-disnaker-700">Berkas</h3>
                        <p class="text-sm text-gray-600">
                            Upload dokumen tetap melalui modul upload saat ini.
                            <a href="{{ route('upload.index') }}" class="font-medium text-disnaker-600 hover:text-disnaker-700">Buka Upload Dokumen</a>
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>{{ $biodata ? 'Perbarui Biodata' : 'Simpan Biodata' }}
                        </button>
                    </div>
                </form>

                @if ($biodata && $biodata->status_verifikasi !== 'verified')
                    <form method="POST" action="{{ route('biodata.submit') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn-secondary">
                            <i class="fas fa-paper-plane mr-2"></i>Ajukan Validasi Admin
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-xl bg-white p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-900">Progress Biodata</h3>
                <div class="mt-3 flex items-center justify-between text-sm">
                    <span class="text-gray-600">Kelengkapan</span>
                    <span class="font-semibold text-gray-900">{{ $completionPercentage }}%</span>
                </div>
                <div class="mt-2 h-2 w-full rounded-full bg-gray-200">
                    <div class="h-2 rounded-full bg-disnaker-500 transition-all duration-300" style="width: {{ $completionPercentage }}%"></div>
                </div>
                <div class="mt-4 space-y-2 text-sm">
                    @foreach ($progressFields as $label => $value)
                        <div class="flex items-center {{ filled($value) ? 'text-green-600' : 'text-gray-400' }}">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>{{ ucwords(str_replace('_', ' ', $label)) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-900">Mini Kartu Digital</h3>
                @if ($biodata?->status_verifikasi === 'verified')
                    <div class="mt-3 rounded-lg border border-green-200 bg-green-50 p-4">
                        <p class="text-sm text-gray-600">Nomor AK-1</p>
                        <p class="font-semibold text-gray-900">{{ $user->kartuKuning->nomor_ak1 ?? '-' }}</p>
                        <p class="mt-2 text-xs text-gray-500">Berlaku hingga {{ $validUntil->format('d M Y') }}</p>
                    </div>
                    <a href="{{ route('kartu.show') }}" class="btn-primary mt-4">
                        <i class="fas fa-eye mr-2"></i>Preview Kartu
                    </a>
                @else
                    <div class="mt-3 rounded-lg border border-yellow-200 bg-yellow-50 p-4">
                        <p class="text-sm font-medium text-yellow-800">Kartu masih terkunci</p>
                        <p class="mt-1 text-xs text-yellow-700">Kartu aktif setelah biodata diverifikasi admin.</p>
                    </div>
                    @if ($biodata)
                        <form method="POST" action="{{ route('biodata.submit') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="btn-secondary">
                                <i class="fas fa-paper-plane mr-2"></i>Ajukan Validasi Admin
                            </button>
                        </form>
                    @endif
                @endif
            </div>

            <div class="rounded-xl bg-white p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-900">Status Verifikasi</h3>
                <p class="mt-3 text-sm text-gray-600">Preview dan cetak kartu kuning hanya aktif setelah biodata terverifikasi admin.</p>
                <div class="mt-4">
                    @if ($biodata?->status_verifikasi === 'verified')
                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Terverifikasi Admin</span>
                    @elseif ($biodata?->status_verifikasi === 'rejected')
                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Ditolak, mohon perbaiki biodata</span>
                    @elseif ($biodata)
                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">Menunggu validasi admin</span>
                    @else
                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">Biodata belum diisi</span>
                    @endif
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-900">Aksi Cepat</h3>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('profile.edit') }}#biodata" class="block rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-address-card mr-2 text-disnaker-600"></i>Isi / Update Biodata
                    </a>
                    <a href="{{ route('status.index') }}" class="block rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-sync-alt mr-2 text-disnaker-600"></i>Update Status Pekerjaan
                    </a>
                    <a href="{{ route('kartu.show') }}" class="block rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-id-card mr-2 text-disnaker-600"></i>Lihat Kartu Kuning
                    </a>
                    <a href="{{ route('notifikasi.index') }}" class="block rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-bell mr-2 text-disnaker-600"></i>Lihat Notifikasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
