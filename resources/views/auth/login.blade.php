<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h3 class="text-xl font-bold text-white mb-6 text-center">System Login</h3>

        <div>
            <label for="email" class="block font-medium text-sm text-gray-400">Email Address</label>
            <input id="email"
                class="block mt-1 w-full rounded-lg border-[#4A5568] bg-[#0B1120] text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="officer@aerospace.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-400">Password</label>
            <input id="password"
                class="block mt-1 w-full rounded-lg border-[#4A5568] bg-[#0B1120] text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4 flex justify-between items-center">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-[#4A5568] bg-[#0B1120] text-blue-600 shadow-sm focus:ring-blue-500"
                    name="remember">
                <span class="ms-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-blue-500 hover:text-blue-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit"
                class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-[#151B2D]">
                {{ __('Access Dashboard') }}
            </button>
        </div>

        <div class="mt-6 text-center border-t border-[#2D3748] pt-4">
            <p class="text-sm text-gray-500">New Supplier?</p>
            <a href="{{ route('register') }}"
                class="text-sm font-bold text-blue-500 hover:text-blue-400 hover:underline">
                Register Account
            </a>
        </div>
    </form>
</x-guest-layout>