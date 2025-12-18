<nav x-data="{ open: false }" class="bg-sanku-primary border-b border-sanku-dark shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-3 group hover:scale-105 transition-transform duration-300">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow overflow-hidden">
                            <img src="{{ asset('images/ldp.png') }}" alt="Echo Sanku Logo" class="w-8 h-8 sm:w-10 sm:h-10 object-contain">
                        </div>
                        <div class="text-white hidden sm:block">
                            <h1 class="text-lg sm:text-xl font-bold leading-tight">ECHO SANKU</h1>
                            <p class="text-xs opacity-90">{{ auth()->user()->isAdmin() ? 'Dashboard Admin' : 'Dashboard Nasabah' }}</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 lg:space-x-8 sm:-my-px sm:ml-6 lg:ml-10 sm:flex">
                    @if(auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.exchange.index')" :active="request()->routeIs('admin.exchange.*')">
                            {{ __('Penukaran') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.transaction.index')" :active="request()->routeIs('admin.transaction.*')">
                            {{ __('Transaksi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.report.index')" :active="request()->routeIs('admin.report.*')">
                            {{ __('Laporan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.waste-type.index')" :active="request()->routeIs('admin.waste-type.*')">
                            {{ __('Jenis Sampah') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('nasabah.dashboard')" :active="request()->routeIs('nasabah.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('nasabah.exchange-history.index')" :active="request()->routeIs('nasabah.exchange-history.*')">
                            {{ __('Riwayat') }}
                        </x-nav-link>
                        <x-nav-link :href="route('nasabah.withdrawal.index')" :active="request()->routeIs('nasabah.withdrawal.*')">
                            {{ __('Penarikan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('nasabah.profile.edit')" :active="request()->routeIs('nasabah.profile.*')">
                            {{ __('Akun') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 border-2 border-transparent hover:border-sanku-accent text-sm leading-4 font-medium rounded-lg text-white bg-sanku-dark hover:bg-opacity-80 focus:outline-none focus:border-sanku-accent transition-all duration-200 ease-in-out shadow-md hover:shadow-lg">
                            <!-- Profile Photo -->
                            <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-sanku-accent shadow-sm">
                                @if(auth()->user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                                         alt="Profile Photo" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-sanku-accent to-sanku-secondary flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Name -->
                            <div class="text-left hidden lg:block">
                                <div class="font-semibold">{{ Str::limit(Auth::user()->name, 15) }}</div>
                                <div class="text-xs text-sanku-accent">{{ auth()->user()->isAdmin() ? 'Admin' : 'Nasabah' }}</div>
                            </div>
                            
                            <!-- Dropdown Icon -->
                            <svg class="fill-current h-4 w-4 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        
                        @if(!auth()->user()->isAdmin())
                            <x-dropdown-link :href="route('nasabah.profile.edit')">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('Profil Saya') }}
                                </div>
                            </x-dropdown-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <div class="flex items-center gap-2 text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Keluar') }}
                                </div>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-sanku-accent hover:bg-sanku-dark focus:outline-none focus:bg-sanku-dark focus:text-sanku-accent transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-sanku-dark">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('Dashboard') }}
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.exchange.index')" :active="request()->routeIs('admin.exchange.*')">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        {{ __('Penukaran') }}
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.transaction.index')" :active="request()->routeIs('admin.transaction.*')">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ __('Transaksi') }}
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.report.index')" :active="request()->routeIs('admin.report.*')">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('Laporan') }}
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.waste-type.index')" :active="request()->routeIs('admin.waste-type.*')">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        {{ __('Jenis Sampah') }}
                    </div>
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('nasabah.dashboard')" :active="request()->routeIs('nasabah.dashboard')">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('Dashboard') }}
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('nasabah.exchange-history.index')" :active="request()->routeIs('nasabah.exchange-history.*')">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('Riwayat Penukaran') }}
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('nasabah.withdrawal.index')" :active="request()->routeIs('nasabah.withdrawal.*')">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{ __('Penarikan') }}
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('nasabah.profile.edit')" :active="request()->routeIs('nasabah.profile.*')">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('Akun') }}
                    </div>
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-sanku-primary">
            <div class="px-4 flex items-center gap-3 mb-3">
                <!-- Profile Photo -->
                <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-sanku-accent shadow-lg">
                    @if(auth()->user()->profile_photo_path)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                             alt="Profile Photo" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-sanku-accent to-sanku-secondary flex items-center justify-center">
                            <span class="text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                </div>
                <div>
                    <div class="font-semibold text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-sanku-accent">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <div class="flex items-center gap-3 text-red-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            {{ __('Keluar') }}
                        </div>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>