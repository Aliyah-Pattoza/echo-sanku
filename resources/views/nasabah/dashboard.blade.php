<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('nasabah.dashboard.alerts', [
                'successMessage' => session('success'),
                'pendingWithdrawals' => $pendingWithdrawals
            ])

            <!-- Statistics Cards -->
            <div class="grid md:grid-cols-4 gap-6 mb-8">
                <x-dashboard.stat-card 
                    label="Saldo Tersedia"
                    value="Rp {{ number_format($stats['balance'], 0, ',', '.') }}"
                    color="sanku-primary"
                    icon="wallet"
                    action="{{ route('nasabah.withdrawal.create') }}"
                    actionText="Tarik Saldo →"
                />

                <x-dashboard.stat-card 
                    label="Total Penarikan"
                    value="Rp {{ number_format($stats['total_withdrawals'], 0, ',', '.') }}"
                    color="sanku-secondary"
                    icon="credit-card"
                    description="💸 Sejak bergabung"
                />

                <x-dashboard.stat-card 
                    label="Transaksi Bulan Ini"
                    value="{{ $stats['monthly_transactions'] }}"
                    color="sanku-primary"
                    icon="clock"
                    description="📊 {{ now()->format('F Y') }}"
                />

                <x-dashboard.stat-card 
                    label="Total Sampah"
                    value="{{ number_format($stats['total_waste_items'], 0, ',', '.') }}"
                    color="sanku-accent"
                    icon="trash"
                    description="♻️ Berkontribusi untuk bumi"
                />
            </div>

            <!-- Welcome Message -->
            @include('nasabah.dashboard.welcome-message')

            <!-- Recent Transactions -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Transaksi Terbaru
                        </h3>
                        <a href="{{ route('nasabah.exchange-history.index') }}" class="text-sm font-semibold text-sanku-accent hover:text-sanku-primary">
                            Lihat Semua →
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recentTransactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-sanku-cream">
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Tanggal</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Kode Transaksi</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Item</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Total Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $index => $transaction)
                                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-sanku-light' }}">
                                            <td class="p-3 text-gray-600">{{ $transaction->transaction_date->format('d M Y') }}</td>
                                            <td class="p-3 font-semibold text-sanku-dark">{{ $transaction->transaction_code }}</td>
                                            <td class="p-3 text-gray-600">
                                                {{ $transaction->items->count() }} jenis sampah
                                            </td>
                                            <td class="p-3 font-bold text-sanku-accent">Rp {{ number_format($transaction->total_points, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p>Belum ada transaksi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>