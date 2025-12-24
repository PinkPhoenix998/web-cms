<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Field: Nama Sekolah -->
        <div>
            <x-input-label for="school_name" :value="__('Nama Sekolah')" />
            <x-text-input id="school_name" class="block mt-1 w-full" type="text" name="school_name" :value="old('school_name')" required autofocus autocomplete="organization" />
            <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
        </div>

        <!-- Field: Slug URL (INPUT BARU) -->
        <div class="mt-4">
            <x-input-label for="slug" :value="__('URL Sekolah (contoh: sd-budi-luhur)')" />
            <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug')" required placeholder="gunakan huruf kecil dan tanda hubung (-)" />
            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
        </div>

        <!-- Field: Nama Admin -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Nama Lengkap Admin')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudah terdaftar?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Daftar Sekolah') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>