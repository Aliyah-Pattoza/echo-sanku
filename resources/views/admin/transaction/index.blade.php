<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Transaksi Penarikan') }}
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
                    <form method="GET" action="{{ route('admin.transaction.index') }}" class="flex flex-wrap gap-4">
                        <select name="status" class="rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <select name="method" class="rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                            <option value="">Semua Metode</option>
                            <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="ewallet" {{ request('method') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                            <option value="bank" {{ request('method') == 'bank' ? 'selected' : '' }}>Bank</option>
                        </select>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama..." class="rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                        <button type="submit" class="px-4 py-2 bg-sanku-accent text-white rounded-lg font-semibold hover:bg-sanku-primary transition">
                            Filter
                        </button>
                        @if(request()->hasAny(['status', 'method', 'search']))
                            <a href="{{ route('admin.transaction.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Withdrawals List -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">Daftar Pengajuan Penarikan</h3>
                </div>
                <div class="p-6">
                    @if($withdrawals->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-sanku-cream">
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Tanggal</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Kode</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Nasabah</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Metode</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Jumlah</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Status</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($withdrawals as $index => $withdrawal)
                                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-sanku-light' }}">
                                            <td class="p-3 text-gray-600">{{ $withdrawal->requested_at->setTimezone('Asia/Makassar')->locale('id')->isoFormat('D MMM YYYY') }}</td>
                                            <td class="p-3 font-semibold text-sanku-dark">{{ $withdrawal->request_code }}</td>
                                            <td class="p-3 text-gray-700">{{ $withdrawal->user->name }}</td>
                                            <td class="p-3 text-gray-600 capitalize">{{ ucfirst($withdrawal->method) }}</td>
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
                                                        Pending
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
                                                <a href="{{ route('admin.transaction.show', $withdrawal->id) }}" class="text-sanku-accent hover:text-sanku-primary font-semibold text-sm">
                                                    Detail →
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
                        <p>Tidak ada pengajuan penarikan ditemukan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>