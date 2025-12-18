<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Penukaran') }}
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

            <!-- Filter & Add Button -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <form method="GET" action="{{ route('admin.exchange.index') }}" class="flex flex-wrap gap-4 flex-1">
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama..." class="rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                            <button type="submit" class="px-4 py-2 bg-sanku-accent text-white rounded-lg font-semibold hover:bg-sanku-primary transition">
                                Filter
                            </button>
                            @if(request()->hasAny(['start_date', 'end_date', 'search']))
                                <a href="{{ route('admin.exchange.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                                    Reset
                                </a>
                            @endif
                        </form>
                        <a href="{{ route('admin.exchange.create') }}" class="px-6 py-3 bg-sanku-accent text-white rounded-lg font-bold flex items-center gap-2 hover:bg-sanku-primary transition whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Input Transaksi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">Daftar Transaksi Penukaran</h3>
                </div>
                <div class="p-6">
                    @if($transactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-sanku-cream">
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Tanggal</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Kode Transaksi</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Nasabah</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Item</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Total Poin</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Admin</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $index => $transaction)
                                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-sanku-light' }}">
                                            <td class="p-3 text-gray-600">{{ $transaction->transaction_date->setTimezone('Asia/Makassar')->locale('id')->isoFormat('D MMM YYYY') }}</td>
                                            <td class="p-3 font-semibold text-sanku-dark">{{ $transaction->transaction_code }}</td>
                                            <td class="p-3 text-gray-700">{{ $transaction->user->name }}</td>
                                            <td class="p-3 text-gray-600">{{ $transaction->items->count() }} jenis</td>
                                            <td class="p-3 font-bold text-sanku-accent">Rp {{ number_format($transaction->total_points, 0, ',', '.') }}</td>
                                            <td class="p-3 text-gray-600">{{ $transaction->admin->name ?? '-' }}</td>
                                            <td class="p-3">
                                                <div class="flex gap-2">
                                                    <a href="{{ route('admin.exchange.show', $transaction->id) }}" class="text-blue-600 hover:text-blue-800" title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('admin.exchange.edit', $transaction->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.exchange.destroy', $transaction->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $transactions->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p>Tidak ada transaksi ditemukan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>