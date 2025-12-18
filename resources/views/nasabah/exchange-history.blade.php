<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Penukaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('nasabah.exchange-history.index') }}" class="grid md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Kode</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode transaksi..." class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 px-4 py-2 bg-sanku-accent text-white rounded-lg font-semibold hover:bg-sanku-primary transition">
                                Filter
                            </button>
                            <a href="{{ route('nasabah.exchange-history.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">Semua Transaksi</h3>
                </div>
                <div class="p-6">
                    @if($transactions->count() > 0)
                        <div class="space-y-4">
                            @foreach($transactions as $transaction)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-sanku-accent transition">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-bold text-sanku-dark">{{ $transaction->transaction_code }}</h4>
                                            <p class="text-sm text-gray-600">{{ $transaction->transaction_date->format('d F Y, H:i') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-sanku-accent">Rp {{ number_format($transaction->total_points, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-sm text-gray-700 font-semibold mb-2">Item:</p>
                                        <div class="space-y-1">
                                            @foreach($transaction->items as $item)
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-gray-600">{{ $item->wasteType->name }} ({{ $item->quantity }} {{ $item->wasteType->unit }})</span>
                                                    <span class="font-semibold text-sanku-primary">Rp {{ number_format($item->subtotal_points, 0, ',', '.') }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @if($transaction->notes)
                                        <p class="text-sm text-gray-600 mb-3">
                                            <span class="font-semibold">Catatan:</span> {{ $transaction->notes }}
                                        </p>
                                    @endif
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-500">Diproses oleh: {{ $transaction->admin->name ?? 'Admin' }}</p>
                                    </div>
                                </div>
                            @endforeach
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