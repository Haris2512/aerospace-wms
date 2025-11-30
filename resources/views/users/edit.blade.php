<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

                {{-- HEADER --}}
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-3xl text-white leading-tight">
                            {{ __('Edit User') }}
                        </h2>
                        <p class="text-gray-400 text-sm mt-2">Update user information and permissions.</p>
                    </div>
                </div>

                {{-- CARD FORM --}}
                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">

                    <div class="px-8 py-6 border-b border-[#2D3748] bg-[#151B2D] flex justify-between items-center">
                        <h3 class="text-xl font-black text-white">Edit: {{ $user->name }}</h3>
                    </div>

                    <div class="p-8">
                        <form method="POST" action="{{ route('users.update', $user) }}">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">

                                {{-- Nama Lengkap --}}
                                <div>
                                    <x-input-label for="name" :value="__('Full Name')"
                                        class="font-bold !text-gray-300" />
                                    <input id="name"
                                        class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                        type="text" name="name" value="{{ old('name', $user->name) }}" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                {{-- Email --}}
                                <div>
                                    <x-input-label for="email" :value="__('Email Address')"
                                        class="font-bold !text-gray-300" />
                                    <input id="email"
                                        class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                        type="email" name="email" value="{{ old('email', $user->email) }}" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                {{-- Role --}}
                                <div>
                                    <x-input-label for="role" :value="__('Role / Access Level')"
                                        class="font-bold !text-gray-300" />
                                    <select id="role" name="role"
                                        class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5">
                                        <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>
                                            Staff Gudang</option>
                                        <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Warehouse Manager</option>
                                        <option value="supplier" {{ old('role', $user->role) == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                            System Admin</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                </div>

                                <hr class="border-[#2D3748] my-6">

                                <div class="bg-[#1A202C] p-4 rounded-xl border border-[#2D3748]">
                                    <h4 class="text-sm font-bold text-blue-400 mb-4">Change Password (Optional)</h4>
                                    <p class="text-xs text-gray-500 mb-4">Leave blank if you don't want to change the
                                        password.</p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        {{-- Password --}}
                                        <div>
                                            <x-input-label for="password" :value="__('New Password')"
                                                class="font-bold !text-gray-300" />
                                            <input id="password"
                                                class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#0B1120] text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                                type="password" name="password" autocomplete="new-password" />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        {{-- Confirm Password --}}
                                        <div>
                                            <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                                                class="font-bold !text-gray-300" />
                                            <input id="password_confirmation"
                                                class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#0B1120] text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                                type="password" name="password_confirmation" />
                                            <x-input-error :messages="$errors->get('password_confirmation')"
                                                class="mt-2" />
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-[#2D3748]">
                                <a href="{{ route('users.index') }}"
                                    class="px-6 py-2.5 text-sm font-bold text-gray-300 bg-[#1F2937] border border-[#4A5568] rounded-lg hover:bg-[#374151] hover:text-white transition shadow-sm">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm rounded-lg shadow-lg shadow-amber-500/20 transition transform hover:-translate-y-0.5">
                                    Update User
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>