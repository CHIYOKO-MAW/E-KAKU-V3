<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Masukkan email akun Anda. Kami akan mengirimkan tautan reset password.
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex justify-end">
            <x-primary-button>
                Kirim Link Reset
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
