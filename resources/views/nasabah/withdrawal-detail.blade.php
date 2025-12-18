<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Penarikan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $withdrawal->request_code }}</h3>
                            <p class="text-gray-600">{{ $withdrawal->requested_at->format('d F Y, H:i') }}</p>
                        </div>
                        @if($withdrawal->status == 'completed')
                            <span class="inline-flex items-center gap-1 px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Selesai
                            </span>
                        @elseif($withdrawal->status == 'approved')
                            <span class="inline-flex items-center gap-1 px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Disetujui
                            </span>
                        @elseif($withdrawal->status == 'pending')
                            <span class="inline-flex items-center gap-1 px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Menunggu
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Ditolak
                            </span>
                        @endif
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <!-- Jumlah Penarikan -->
                        <div class="mb-6 p-5 bg-sanku-accent bg-opacity-20 rounded-lg">
                            <p class="text-sm text-gray-700 mb-1">Jumlah Penarikan</p>
                            <p class="text-4xl font-bold text-sanku-accent">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</p>
                        </div>

                        <!-- Detail Informasi -->
                        <div class="space-y-4">
                            <div class="flex border-b border-gray-100 pb-3">
                                <span class="w-40 text-gray-600 font-semibold">Metode</span>
                                <span class="flex-1 text-gray-800">
                                    @if($withdrawal->method == 'cash')
                                        Cash (Tunai)
                                    @elseif($withdrawal->method == 'ewallet')
                                        E-Wallet - {{ $withdrawal->bank_name }}
                                    @else
                                        Bank Transfer - {{ $withdrawal->bank_name }}
                                    @endif
                                </span>
                            </div>

                            @if($withdrawal->method != 'cash')
                                @if($withdrawal->method == 'ewallet')
                                    <div class="flex border-b border-gray-100 pb-3">
                                        <span class="w-40 text-gray-600 font-semibold">Nomor Telepon</span>
                                        <span class="flex-1 text-gray-800 font-mono">{{ $withdrawal->account_number }}</span>
                                    </div>
                                    <div class="flex border-b border-gray-100 pb-3">
                                        <span class="w-40 text-gray-600 font-semibold">Nama Pemilik</span>
                                        <span class="flex-1 text-gray-800">{{ $withdrawal->account_name }}</span>
                                    </div>
                                @else
                                    <div class="flex border-b border-gray-100 pb-3">
                                        <span class="w-40 text-gray-600 font-semibold">Nomor Rekening</span>
                                        <span class="flex-1 text-gray-800 font-mono">{{ $withdrawal->account_number }}</span>
                                    </div>
                                    <div class="flex border-b border-gray-100 pb-3">
                                        <span class="w-40 text-gray-600 font-semibold">Nama Pemilik</span>
                                        <span class="flex-1 text-gray-800">{{ $withdrawal->account_name }}</span>
                                    </div>
                                @endif
                            @endif

                            @if($withdrawal->processed_at)
                                <div class="flex border-b border-gray-100 pb-3">
                                    <span class="w-40 text-gray-600 font-semibold">Diproses Tanggal</span>
                                    <span class="flex-1 text-gray-800">{{ $withdrawal->processed_at->format('d F Y, H:i') }}</span>
                                </div>
                                <div class="flex border-b border-gray-100 pb-3">
                                    <span class="w-40 text-gray-600 font-semibold">Diproses Oleh</span>
                                    <span class="flex-1 text-gray-800">{{ $withdrawal->processor->name ?? 'Admin' }}</span>
                                </div>
                            @endif
                        </div>

                        @if($withdrawal->status == 'rejected' && $withdrawal->rejection_reason)
                            <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-sm font-semibold text-red-800 mb-1">Alasan Penolakan:</p>
                                <p class="text-sm text-red-700">{{ $withdrawal->rejection_reason }}</p>
                            </div>
                        @endif

                        @if($withdrawal->method == 'cash' && in_array($withdrawal->status, ['approved', 'completed']))
                            <div class="mt-6 p-4 bg-sanku-accent bg-opacity-20 rounded-lg">
                                <p class="text-sm font-semibold text-sanku-dark mb-2">📍 Informasi Pengambilan Tunai</p>
                                <p class="text-sm text-gray-700 mb-3">Silakan datang ke Bank Sampah RSUD LDP untuk mengambil uang tunai Anda.</p>
                                <div class="text-sm text-gray-700">
                                    <p><strong>Lokasi:</strong> RSUD LDP, Surabaya</p>
                                    <p><strong>Jam Operasional:</strong> Senin - Jumat, 08.00 - 15.00</p>
                                    <p><strong>Yang dibawa:</strong> KTP & Screenshot bukti penarikan ini</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="px-8 pb-8">
                    <a href="{{ route('nasabah.withdrawal.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>