<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Month Filter -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <form method="GET" action="{{ route('admin.report.index') }}" class="flex gap-4">
                            <input type="month" name="month" value="{{ $month }}" class="rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                            <button type="submit" class="px-6 py-2 bg-sanku-accent text-white rounded-lg font-semibold hover:bg-sanku-primary transition">
                                Filter
                            </button>
                        </form>
                        <a href="{{ route('admin.report.export', ['month' => $month]) }}" target="_blank" class="px-6 py-3 bg-sanku-secondary text-white rounded-lg font-bold hover:bg-sanku-dark transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export Laporan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="grid md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Total Transaksi</p>
                                <h3 class="text-3xl font-bold text-sanku-primary">{{ $summary['total_transactions'] }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-sanku-primary bg-opacity-20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">Penukaran sampah</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Total Poin</p>
                                <h3 class="text-2xl font-bold text-sanku-accent">Rp {{ number_format($summary['total_points_distributed'], 0, ',', '.') }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-sanku-accent bg-opacity-20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">Terdistribusi</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Total Penarikan</p>
                                <h3 class="text-2xl font-bold text-sanku-secondary">Rp {{ number_format($summary['total_withdrawals'], 0, ',', '.') }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-sanku-secondary bg-opacity-20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">Uang keluar</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Nasabah Aktif</p>
                                <h3 class="text-3xl font-bold text-sanku-primary">{{ $summary['total_nasabah_active'] }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-sanku-primary bg-opacity-20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">Bulan ini</p>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800">Grafik Transaksi Harian</h3>
                </div>
                <div class="p-6">
                    <div class="h-64 flex items-end justify-between gap-2">
                        @if($dailyTransactions->count() > 0)
                            @foreach($dailyTransactions as $transaction)
                                <div class="flex-1 flex flex-col items-center group relative">
                                    <div class="w-full bg-sanku-accent rounded-t-lg transition-all hover:bg-sanku-primary cursor-pointer" 
                                         style="height: {{ $dailyTransactions->max('count') > 0 ? ($transaction->count / $dailyTransactions->max('count')) * 200 : 0 }}px;">
                                    </div>
                                    <p class="text-xs text-gray-600 mt-2">{{ \Carbon\Carbon::parse($transaction->date)->format('d/m') }}</p>
                                    <!-- Tooltip -->
                                    <div class="hidden group-hover:block absolute bottom-full mb-2 px-3 py-2 bg-gray-800 text-white text-xs rounded-lg whitespace-nowrap">
                                        {{ $transaction->count }} transaksi<br>
                                        Rp {{ number_format($transaction->points, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="w-full text-center py-12 text-gray-500">
                                <p>Tidak ada data transaksi untuk periode ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Waste Type Statistics -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">Statistik per Jenis Sampah</h3>
                    </div>
                    <div class="p-6">
                        @if($wasteStats->count() > 0)
                            <div class="space-y-4">
                                @foreach($wasteStats as $stat)
                                    <div class="border-b border-gray-100 pb-4 last:border-0">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $stat->wasteType->name }}</p>
                                                <p class="text-sm text-gray-600">{{ number_format($stat->total_quantity, 2) }} {{ $stat->wasteType->unit }}</p>
                                            </div>
                                            <p class="font-bold text-sanku-accent">Rp {{ number_format($stat->total_points, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-sanku-accent h-2 rounded-full" style="width: {{ $wasteStats->max('total_points') > 0 ? ($stat->total_points / $wasteStats->max('total_points')) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-4">Tidak ada data</p>
                        @endif
                    </div>
                </div>

                <!-- Top Contributors -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">Top 10 Kontributor</h3>
                    </div>
                    <div class="p-6">
                        @if($topContributors->count() > 0)
                            <div class="space-y-4">
                                @foreach($topContributors as $index => $contributor)
                                    <div class="flex items-center gap-4 border-b border-gray-100 pb-4 last:border-0">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-sanku-accent flex items-center justify-center text-white font-bold">
                                                {{ $index + 1 }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-gray-800 truncate">{{ $contributor->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $contributor->transaction_count }} transaksi</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-sanku-accent">Rp {{ number_format($contributor->total_points, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-4">Tidak ada data</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>