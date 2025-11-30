<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">
        
        <x-slot name="header">
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Alert Messages --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-[#064E3B] border border-[#059669] text-green-100 rounded-lg flex items-center shadow-lg">
                        <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-bold mr-1">Success!</span> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-[#7F1D1D] border border-[#B91C1C] text-red-100 rounded-lg flex items-center shadow-lg">
                        <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold mr-1">Error!</span> {{ session('error') }}
                    </div>
                @endif

                {{-- CARD UTAMA --}}
                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                    
                    {{-- HEADER --}}
                    <div class="p-6 border-b border-[#2D3748] flex flex-col md:flex-row justify-between items-center bg-[#151B2D] gap-4">
                        <div>
                            <h3 class="text-2xl font-black text-white tracking-tight">User Management</h3>
                            <p class="text-sm font-medium text-gray-400 mt-1">Manage system access and roles.</p>
                        </div>
                        
                        <a href="{{ route('users.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Add New User
                        </a>
                    </div>

                    {{-- TABEL --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#2D3748]">
                            <thead class="bg-[#1A202C]">
                                <tr>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase border-r border-[#2D3748]">Name</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase border-r border-[#2D3748]">Email</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase border-r border-[#2D3748]">Role</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase border-r border-[#2D3748]">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[#151B2D] divide-y divide-[#2D3748]">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-[#1F2937] transition duration-150">
                                        
                                        {{-- Nama --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div class="text-sm font-bold text-white">{{ $user->name }}</div>
                                            @if(Auth::id() === $user->id)
                                                <span class="text-[10px] text-green-400 font-mono">(You)</span>
                                            @endif
                                        </td>

                                        {{-- Email --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-400 border-r border-[#2D3748]">
                                            {{ $user->email }}
                                        </td>

                                        {{-- Role --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            @php
                                                $roles = [
                                                    'admin' => 'bg-red-900/30 text-red-400 border-red-800',
                                                    'manager' => 'bg-purple-900/30 text-purple-400 border-purple-800',
                                                    'staff' => 'bg-blue-900/30 text-blue-400 border-blue-800',
                                                    'supplier' => 'bg-yellow-900/30 text-yellow-400 border-yellow-800',
                                                ];
                                                $class = $roles[$user->role] ?? 'bg-gray-700 text-gray-300';
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full border {{ $class }}">
                                                {{ strtoupper($user->role) }}
                                            </span>
                                        </td>

                                        {{-- Status --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            @if($user->status == 'approved')
                                                <span class="px-2 py-1 text-xs font-bold text-green-400">● Active</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-bold text-yellow-400">● Pending</span>
                                            @endif
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('users.edit', $user) }}" class="p-2 bg-[#1A202C] border border-[#374151] rounded-lg text-amber-500 hover:text-amber-400 hover:border-amber-500/50 transition shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </a>
                                                
                                                @if(Auth::id() !== $user->id)
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this user?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 bg-[#1A202C] border border-[#374151] rounded-lg text-red-500 hover:text-red-400 hover:border-red-500/50 transition shadow-sm">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">No users found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer Pagination --}}
                    <div class="px-6 py-4 bg-[#1A202C] border-t border-[#2D3748]">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>