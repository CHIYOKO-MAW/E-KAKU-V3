@component('mail::message')
# Halo {{ $user->name }}

@if($type === 'status_update')
Mohon perbarui status pekerjaan Anda di aplikasi E-KAKU. Data terakhir Anda sudah lebih dari 90 hari.
@else
Masa berlaku Kartu Kuning Anda sudah lebih dari 6 bulan sejak tanggal cetak. Mohon cek status atau lakukan perpanjangan bila perlu.
@endif

@component('mail::button', ['url' => route('dashboard')])
Buka E-KAKU
@endcomponent

Terima kasih,<br>
Dinas Tenaga Kerja Kabupaten Pandeglang
@endcomponent
