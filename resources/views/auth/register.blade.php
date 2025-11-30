<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h3 class="text-xl font-bold text-white mb-6 text-center">Supplier Registration</h3>
        <p class="text-xs text-gray-500 mb-6 text-center">Pendaftaran ini hanya untuk Supplier baru. Akun memerlukan
            persetujuan Admin.</p>


        <div>
            <label for="name" class="block font-medium text-sm text-gray-400">Nama Perusahaan / Kontak</label>
            <input id="name"
                class="block mt-1 w-full rounded-lg border-[#4A5568] bg-[#0B1120] text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="PT. Dirgantara Cipta" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-400">Email Address</label>
            <input id="email"
                class="block mt-1 w-full rounded-lg border-[#4A5568] bg-[#0B1120] text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="contact@supplier.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-400">Password</label>
            <input id="password"
                class="block mt-1 w-full rounded-lg border-[#4A5568] bg-[#0B1120] text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-400">Confirm Password</label>
            <input id="password_confirmation"
                class="block mt-1 w-full rounded-lg border-[#4A5568] bg-[#0B1120] text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-blue-500 hover:text-blue-400 rounded-md" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit"
                class="w-full py-3 px-4 mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-[#151B2D]">
                {{ __('Register Account') }}
            </button>
        </div>
    </form>
</x-guest-layout>