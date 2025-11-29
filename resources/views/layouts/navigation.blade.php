<nav class="fixed top-0 left-0 h-full w-64 bg-[#151B2D] border-r border-[#2D3748] z-30 flex flex-col shadow-2xl">
    
    {{-- LOGO DAN JUDUL (AEROSPACE WMS) --}}
    <div class="p-6 border-b border-[#2D3748] text-white">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            <span class="text-xl font-black tracking-tight">AERO<span class="text-blue-500">WMS</span></span>
        </a>
    </div>

    {{-- MENU UTAMA VERTICAL --}}
    <div class="flex flex-col space-y-2 p-4 flex-1 overflow-y-auto">
        
        {{-- Tombol Dashboard --}}
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-sm font-medium hover:bg-[#1A202C] px-3 py-2 rounded-lg transition-colors duration-200 block">
            <svg class="w-5 h-5 mr-3 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7m-7 7v10a1 1 0 001 1h10a1 1 0 001-1v-4m-12-3h.01M5 13h.01"></path></svg>
            {{ __('Dashboard') }}
        </x-nav-link>

        <div class="pt-4 border-t border-[#2D3748] mb-2">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest px-3 mb-2">Management</p>
        </div>

        {{-- MASTER DATA (Hanya Admin & Manager) --}}
        @if(in_array(Auth::user()->role, ['admin', 'manager']))
            <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="text-sm font-medium hover:bg-[#1A202C] px-3 py-2 rounded-lg transition-colors duration-200 block">
                <svg class="w-5 h-5 mr-3 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2h2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v2M7 9h10"></path></svg>
                {{ __('Categories') }}
            </x-nav-link>

            <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="text-sm font-medium hover:bg-[#1A202C] px-3 py-2 rounded-lg transition-colors duration-200 block">
                <svg class="w-5 h-5 mr-3 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                {{ __('Components') }}
            </x-nav-link>
        @endif

        {{-- TRANSAKSI (Admin, Manager, Staff) --}}
        @if(in_array(Auth::user()->role, ['admin', 'manager', 'staff']))
            <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="text-sm font-medium hover:bg-[#1A202C] px-3 py-2 rounded-lg transition-colors duration-200 block">
                <svg class="w-5 h-5 mr-3 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h14a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3v4m10-4v4M3 15h18M7 10h10a2 2 0 012 2v7a2 2 0 01-2 2H7a2 2 0 01-2-2v-7a2 2 0 012-2z"></path></svg>
                {{ __('Transactions') }}
            </x-nav-link>
        @endif

        {{-- RESTOCK (Manager & Supplier) --}}
        @if(in_array(Auth::user()->role, ['manager', 'supplier']))
            <x-nav-link :href="route('restock.index')" :active="request()->routeIs('restock.*')" class="text-sm font-medium hover:bg-[#1A202C] px-3 py-2 rounded-lg transition-colors duration-200 block">
                <svg class="w-5 h-5 mr-3 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8-4v4M5 9h14l-1 12H6L5 9z"></path></svg>
                {{ __('Restock PO') }}
            </x-nav-link>
        @endif
        
    </div>
    
    {{-- USER PROFILE / LOGOUT  --}}
    <div class="mt-auto p-4 border-t border-[#2D3748] bg-[#1A202C]">
        <div class="flex items-center justify-between">
            <div class="flex-shrink-0">
                <div class="font-medium text-sm text-white">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-500 uppercase">{{ Auth::user()->role }}</div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-red-500 p-2 rounded-full hover:bg-[#151B2D] transition" title="Log Out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-3m14-4V7a3 3 0 00-3-3H6a3 3 0 00-3 3v4"></path></svg>
                </button>
            </form>
        </div>
    </div>
    

</nav>