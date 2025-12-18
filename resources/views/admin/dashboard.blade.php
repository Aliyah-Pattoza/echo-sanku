<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid md:grid-cols-4 gap-6 mb-8">
                <!-- Total Nasabah -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Total Nasabah</p>
                                <h3 class="text-3xl font-bold text-sanku-primary">{{ $stats['total_nasabah'] }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-sanku-primary bg-opacity-20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">👥 Nasabah aktif</p>
                    </div>
                </div>

                <!-- Pending Withdrawals -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Pengajuan Pending</p>
                                <h3 class="text-3xl font-bold text-yellow-600">{{ $stats['pending_withdrawals'] }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('admin.transaction.index', ['status' => 'pending']) }}" class="text-sm font-semibold text-yellow-600 hover:text-yellow-700">
                            Proses Sekarang →
                        </a>
                    </div>
                </div>

                <!-- Monthly Transactions -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Transaksi Bulan Ini</p>
                                <h3 class="text-3xl font-bold text-sanku-accent">{{ $stats['monthly_transactions'] }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-sanku-accent bg-opacity-20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">📊 {{ \Carbon\Carbon::now('Asia/Makassar')->locale('id')->isoFormat('MMMM YYYY') }}</p>
                    </div>
                </div>

                <!-- Total Points Distributed -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Poin Terdistribusi</p>
                                <h3 class="text-2xl font-bold text-sanku-secondary">Rp {{ number_format($stats['total_points_distributed'], 0, ',', '.') }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-sanku-secondary bg-opacity-20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">💰 Bulan ini</p>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">Grafik Transaksi Harian</h3>
                </div>
                <div class="p-6">
                    <div class="h-64 flex items-end justify-between gap-2">
                        @foreach($dailyTransactions as $transaction)
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-sanku-accent rounded-t-lg transition-all hover:bg-sanku-primary" 
                                     style="height: {{ $dailyTransactions->max('count') > 0 ? ($transaction->count / $dailyTransactions->max('count')) * 200 : 0 }}px;"
                                     title="{{ $transaction->count }} transaksi">
                                </div>
                                <p class="text-xs text-gray-600 mt-2">{{ \Carbon\Carbon::parse($transaction->date)->setTimezone('Asia/Makassar')->locale('id')->isoFormat('D MMM') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Recent Transactions -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Transaksi Terbaru
                            </h3>
                            <a href="{{ route('admin.exchange.index') }}" class="text-sm font-semibold text-sanku-accent hover:text-sanku-primary">
                                Lihat Semua →
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($recentTransactions->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentTransactions as $transaction)
                                    <div class="border-b border-gray-100 pb-4 last:border-0">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="font-semibold text-sanku-dark">{{ $transaction->user->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $transaction->transaction_date->setTimezone('Asia/Makassar')->locale('id')->isoFormat('D MMM YYYY, HH:mm') }} WITA</p>
                                            </div>
                                            <p class="font-bold text-sanku-accent">Rp {{ number_format($transaction->total_points, 0, ',', '.') }}</p>
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $transaction->items->count() }} jenis sampah</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-4">Belum ada transaksi</p>
                        @endif
                    </div>
                </div>

                <!-- Pending Withdrawals -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Pengajuan Pending
                            </h3>
                            <a href="{{ route('admin.transaction.index') }}" class="text-sm font-semibold text-sanku-accent hover:text-sanku-primary">
                                Lihat Semua →
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($pendingWithdrawals->count() > 0)
                            <div class="space-y-4">
                                @foreach($pendingWithdrawals as $withdrawal)
                                    <div class="border-b border-gray-100 pb-4 last:border-0">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="font-semibold text-sanku-dark">{{ $withdrawal->user->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $withdrawal->requested_at->setTimezone('Asia/Makassar')->locale('id')->isoFormat('D MMM YYYY, HH:mm') }} WITA</p>
                                            </div>
                                            <p class="font-bold text-sanku-primary">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <p class="text-sm text-gray-600 capitalize">{{ ucfirst($withdrawal->method) }}</p>
                                            <a href="{{ route('admin.transaction.show', $withdrawal->id) }}" class="text-sm font-semibold text-yellow-600 hover:text-yellow-700">
                                                Proses →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-4">Tidak ada pengajuan pending</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>