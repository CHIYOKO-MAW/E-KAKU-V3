<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Silakan verifikasi email Anda sebelum menggunakan semua fitur e-Kaku V3.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-3 py-2 text-sm font-medium text-green-700">
            Link verifikasi baru telah dikirim ke email Anda.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                Kirim Ulang Verifikasi
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>
