@extends('layouts.app')

@section('title', 'Pengguna Perlu Perhatian')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-6 rounded-xl bg-white p-6 card-shadow">
        <h1 class="text-2xl font-bold text-gray-900">Pengguna Perlu Perhatian</h1>
        <p class="mt-1 text-sm text-gray-600">Prioritas tindak lanjut untuk user dengan isu biodata/verifikasi/update status.</p>
    </div>

    <div class="overflow-hidden rounded-xl bg-white card-shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Status Biodata</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Update Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Alasan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($needsAttention as $item)
                        @php
                            $reason = [];
                            if (!$item->biodata) { $reason[] = 'Belum isi biodata'; }
                            elseif (($item->biodata->status_verifikasi ?? 'pending') !== 'verified') { $reason[] = 'Belum verified'; }
                            if ($item->statusPekerjaan && $item->statusPekerjaan->tanggal_update && $item->statusPekerjaan->tanggal_update->lt(now()->subDays(90))) { $reason[] = 'Tidak update status > 90 hari'; }
                        @endphp
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->name }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $item->email }}</td>
                            <td class="px-4 py-3">
                                @php($sv = $item->biodata->status_verifikasi ?? 'pending')
                                <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $sv === 'verified' ? 'bg-green-100 text-green-700' : ($sv === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">{{ strtoupper($sv) }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ optional($item->statusPekerjaan?->tanggal_update)->format('d M Y') ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ implode(', ', $reason ?: ['Monitoring']) }}</td>
                            <td class="px-4 py-3">
                                @if($item->biodata)
                                    <a href="{{ route('admin.verifikasi.show', $item->biodata) }}" class="btn-secondary">Detail</a>
                                @else
                                    <a href="{{ route('admin.pengguna.show', $item) }}" class="btn-secondary">Profil</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Tidak ada pengguna yang perlu perhatian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-100 px-4 py-3">{{ $needsAttention->links() }}</div>
    </div>
</div>
@endsection
