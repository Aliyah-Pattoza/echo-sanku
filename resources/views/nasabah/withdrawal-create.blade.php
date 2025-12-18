<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tarik Saldo') }}
        </h2>
    </x-slot>

    <!-- Alpine.js harus dimuat SEBELUM digunakan -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- CSS untuk x-cloak -->
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Form Penarikan Saldo</h3>

                    <!-- Saldo Info -->
                    <div class="mb-6 p-4 bg-sanku-accent bg-opacity-20 rounded-lg">
                        <p class="text-sm text-gray-700 mb-1">Saldo Tersedia:</p>
                        <p class="text-3xl font-bold text-sanku-accent">Rp {{ number_format($user->balance, 0, ',', '.') }}</p>
                    </div>

                    <form method="POST" action="{{ route('nasabah.withdrawal.store') }}" id="withdrawalForm" x-data="{ method: '{{ old('method', 'cash') }}' }">
                        @csrf

                        <!-- Metode Penarikan -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Metode Penarikan</label>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <input x-model="method" type="radio" name="method" value="cash" id="method_cash" class="peer hidden" {{ old('method', 'cash') == 'cash' ? 'checked' : '' }}>
                                    <label for="method_cash" class="block p-4 rounded-lg border-2 border-gray-200 cursor-pointer peer-checked:border-sanku-accent peer-checked:bg-sanku-accent peer-checked:bg-opacity-10 hover:border-sanku-accent transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-sanku-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <p class="text-center text-sm font-semibold text-gray-800">Cash</p>
                                    </label>
                                </div>

                                <div>
                                    <input x-model="method" type="radio" name="method" value="ewallet" id="method_ewallet" class="peer hidden" {{ old('method') == 'ewallet' ? 'checked' : '' }}>
                                    <label for="method_ewallet" class="block p-4 rounded-lg border-2 border-gray-200 cursor-pointer peer-checked:border-sanku-accent peer-checked:bg-sanku-accent peer-checked:bg-opacity-10 hover:border-sanku-accent transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-sanku-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-center text-sm font-semibold text-gray-800">E-Wallet</p>
                                    </label>
                                </div>

                                <div>
                                    <input x-model="method" type="radio" name="method" value="bank" id="method_bank" class="peer hidden" {{ old('method') == 'bank' ? 'checked' : '' }}>
                                    <label for="method_bank" class="block p-4 rounded-lg border-2 border-gray-200 cursor-pointer peer-checked:border-sanku-accent peer-checked:bg-sanku-accent peer-checked:bg-opacity-10 hover:border-sanku-accent transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-sanku-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        <p class="text-center text-sm font-semibold text-gray-800">Bank</p>
                                    </label>
                                </div>
                            </div>
                            @error('method')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cash Info -->
                        <div x-show="method === 'cash'" x-cloak x-transition class="mb-6 p-4 bg-sanku-accent bg-opacity-20 rounded-lg">
                            <p class="text-sm font-semibold text-sanku-dark mb-2">📍 Pengambilan Tunai</p>
                            <p class="text-sm text-gray-700">Datang ke Bank Sampah RSUD LDP dengan membawa bukti penarikan ini. Tunjukkan ke admin untuk konfirmasi.</p>
                        </div>

                        <!-- E-Wallet Fields -->
                        <div x-show="method === 'ewallet'" x-cloak x-transition class="mb-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis E-Wallet *</label>
                                    <select name="ewallet_type" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                                        <option value="">Pilih E-Wallet</option>
                                        @foreach($ewallets as $key => $value)
                                            <option value="{{ $key }}" {{ old('ewallet_type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('ewallet_type')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon *</label>
                                    <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Contoh: 081234567890" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                                    <p class="text-sm text-gray-600 mt-1">Nomor telepon yang terdaftar di akun e-wallet Anda</p>
                                    @error('phone_number')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Bank Fields -->
                        <div x-show="method === 'bank'" x-cloak x-transition class="mb-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Bank *</label>
                                    <select name="bank_name" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                                        <option value="">Pilih Bank</option>
                                        @foreach($banks as $key => $value)
                                            <option value="{{ $key }}" {{ old('bank_name') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('bank_name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Rekening *</label>
                                    <input type="text" name="account_number" value="{{ old('account_number') }}" placeholder="Contoh: 1234567890" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                                    @error('account_number')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pemilik Rekening *</label>
                                    <input type="text" name="account_name" value="{{ old('account_name') }}" placeholder="Nama sesuai rekening bank" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                                    @error('account_name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Jumlah Penarikan -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Penarikan *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                <input type="number" name="amount" value="{{ old('amount') }}" placeholder="Minimal Rp 10.000" min="10000" max="{{ $user->balance }}" class="w-full pl-12 rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Minimal penarikan: Rp 10.000 | Maksimal: Rp {{ number_format($user->balance, 0, ',', '.') }}</p>
                            @error('amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 py-3 bg-sanku-accent text-white rounded-lg font-bold hover:bg-sanku-primary transition">
                                Ajukan Penarikan
                            </button>
                            <a href="{{ route('nasabah.withdrawal.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Boxes -->
            <div class="grid md:grid-cols-3 gap-4 mt-6">
                <div class="bg-sanku-accent bg-opacity-20 p-4 rounded-xl">
                    <div class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sanku-accent flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-sanku-dark text-sm mb-1">Verifikasi</h4>
                            <p class="text-xs text-gray-700">Penarikan akan diverifikasi oleh admin dalam 1-2 hari kerja</p>
                        </div>
                    </div>
                </div>

                <div class="bg-sanku-primary bg-opacity-20 p-4 rounded-xl">
                    <div class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sanku-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-sanku-dark text-sm mb-1">Proses</h4>
                            <p class="text-xs text-gray-700">Transfer dilakukan setelah penarikan disetujui admin</p>
                        </div>
                    </div>
                </div>

                <div class="bg-sanku-secondary bg-opacity-20 p-4 rounded-xl">
                    <div class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sanku-secondary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-sanku-dark text-sm mb-1">Aman</h4>
                            <p class="text-xs text-gray-700">Data rekening Anda tersimpan dengan aman dan terenkripsi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>