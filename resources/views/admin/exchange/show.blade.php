<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi Penukaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-8">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-200">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $transaction->transaction_code }}</h3>
                            <p class="text-gray-600">{{ $transaction->transaction_date->setTimezone('Asia/Makassar')->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WITA</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.exchange.edit', $transaction->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.exchange.destroy', $transaction->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Saldo nasabah akan dikurangi.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Nasabah Info -->
                    <div class="mb-6 p-4 bg-sanku-light rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-3">Informasi Nasabah</h4>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Nama</p>
                                <p class="font-semibold text-gray-800">{{ $transaction->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-semibold text-gray-800">{{ $transaction->user->email }}</p>
                            </div>
                            @if($transaction->user->profile && $transaction->user->profile->phone)
                                <div>
                                    <p class="text-sm text-gray-600">Telepon</p>
                                    <p class="font-semibold text-gray-800">{{ $transaction->user->profile->phone }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm text-gray-600">Saldo Saat Ini</p>
                                <p class="font-semibold text-sanku-accent">Rp {{ number_format($transaction->user->balance, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Items Detail -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-800 mb-3">Detail Item Sampah</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-sanku-cream">
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Jenis Sampah</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Jumlah</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Harga/Unit</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaction->items as $index => $item)
                                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-sanku-light' }}">
                                            <td class="p-3 font-semibold text-gray-800">{{ $item->wasteType->name }}</td>
                                            <td class="p-3 text-gray-600">{{ $item->quantity }} {{ $item->wasteType->unit }}</td>
                                            <td class="p-3 text-gray-600">Rp {{ number_format($item->point_per_unit, 0, ',', '.') }}</td>
                                            <td class="p-3 font-bold text-sanku-accent">Rp {{ number_format($item->subtotal_points, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-sanku-accent bg-opacity-20">
                                        <td colspan="3" class="p-3 font-bold text-gray-800 text-right">Total Poin:</td>
                                        <td class="p-3 font-bold text-sanku-accent text-xl">Rp {{ number_format($transaction->total_points, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($transaction->notes)
                        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm font-semibold text-gray-800 mb-1">Catatan:</p>
                            <p class="text-gray-700">{{ $transaction->notes }}</p>
                        </div>
                    @endif

                    <!-- Admin Info -->
                    <div class="mb-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-600">Diproses oleh: <span class="font-semibold text-gray-800">{{ $transaction->admin->name ?? 'Admin' }}</span></p>
                        <p class="text-sm text-gray-600">Dibuat pada: {{ $transaction->created_at->setTimezone('Asia/Makassar')->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WITA</p>
                        @if($transaction->updated_at != $transaction->created_at)
                            <p class="text-sm text-gray-600">Terakhir diupdate: {{ $transaction->updated_at->setTimezone('Asia/Makassar')->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WITA</p>
                        @endif
                    </div>

                    <!-- Back Button -->
                    <div>
                        <a href="{{ route('admin.exchange.index') }}" class="inline-block px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                            ← Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>