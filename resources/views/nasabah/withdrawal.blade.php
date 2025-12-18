<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Penarikan Saldo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Filter Section -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <form method="GET" action="{{ route('nasabah.withdrawal.index') }}" class="flex gap-4">
                            <select name="status" class="rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-sanku-accent text-white rounded-lg font-semibold hover:bg-sanku-primary transition">
                                Filter
                            </button>
                        </form>
                        <a href="{{ route('nasabah.withdrawal.create') }}" class="px-6 py-3 bg-sanku-accent text-white rounded-lg font-bold flex items-center gap-2 hover:bg-sanku-primary transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tarik Saldo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Withdrawals List -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Riwayat Penarikan
                    </h3>
                </div>
                <div class="p-6">
                    @if($withdrawals->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-sanku-cream">
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Tanggal</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Kode</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Metode</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Tujuan</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Jumlah</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Status</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($withdrawals as $index => $withdrawal)
                                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-sanku-light' }}">
                                            <td class="p-3 text-gray-600">{{ $withdrawal->requested_at->format('d M Y') }}</td>
                                            <td class="p-3 font-semibold text-sanku-dark">{{ $withdrawal->request_code }}</td>
                                            <td class="p-3 text-gray-600">
                                                @if($withdrawal->method == 'cash')
                                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-semibold bg-gray-100 text-gray-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                        Cash
                                                    </span>
                                                @elseif($withdrawal->method == 'ewallet')
                                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-semibold bg-blue-100 text-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        {{ $withdrawal->bank_name }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-semibold bg-purple-100 text-purple-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                        </svg>
                                                        {{ $withdrawal->bank_name }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="p-3 text-gray-600">
                                                @if($withdrawal->method == 'cash')
                                                    <span class="text-gray-400 italic">Ambil di tempat</span>
                                                @elseif($withdrawal->method == 'ewallet')
                                                    <div class="text-sm">{{ $withdrawal->account_number }}</div>
                                                @else
                                                    <div class="text-sm">{{ $withdrawal->account_number }}</div>
                                                    <div class="text-xs text-gray-500">a/n {{ $withdrawal->account_name }}</div>
                                                @endif
                                            </td>
                                            <td class="p-3 font-bold text-sanku-primary">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                            <td class="p-3">
                                                @if($withdrawal->status == 'completed')
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Selesai
                                                    </span>
                                                @elseif($withdrawal->status == 'approved')
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Disetujui
                                                    </span>
                                                @elseif($withdrawal->status == 'pending')
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Menunggu
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        Ditolak
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="p-3">
                                                <a href="{{ route('nasabah.withdrawal.show', $withdrawal->id) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-sanku-accent hover:text-sanku-primary transition">
                                                    Detail
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $withdrawals->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="text-lg font-semibold mb-2">Belum ada riwayat penarikan</p>
                            <p class="text-sm text-gray-400">Klik tombol "Tarik Saldo" untuk membuat penarikan pertama Anda</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Info Boxes -->
            <div class="grid md:grid-cols-3 gap-4 mt-6">
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-white rounded-lg shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Cash</h4>
                            <p class="text-sm text-gray-600">Ambil tunai langsung di Bank Sampah RSUD LDP</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-white rounded-lg shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">E-Wallet</h4>
                            <p class="text-sm text-gray-600">Transfer ke ShopeePay, GoPay, OVO, atau DANA</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-white rounded-lg shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Bank Transfer</h4>
                            <p class="text-sm text-gray-600">Transfer ke BRI, BNI, Mandiri, atau BCA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>