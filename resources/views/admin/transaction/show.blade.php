<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengajuan Penarikan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-8">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-200">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $withdrawal->request_code }}</h3>
                            <p class="text-gray-600">{{ $withdrawal->requested_at->setTimezone('Asia/Makassar')->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WITA</p>
                        </div>
                        <div>
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
                                    Pending
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
                    </div>

                    <!-- Nasabah Info -->
                    <div class="mb-6 p-4 bg-sanku-light rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-3">Informasi Nasabah</h4>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Nama</p>
                                <p class="font-semibold text-gray-800">{{ $withdrawal->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-semibold text-gray-800">{{ $withdrawal->user->email }}</p>
                            </div>
                            @if($withdrawal->user->profile && $withdrawal->user->profile->phone)
                                <div>
                                    <p class="text-sm text-gray-600">Telepon</p>
                                    <p class="font-semibold text-gray-800">{{ $withdrawal->user->profile->phone }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm text-gray-600">Saldo Saat Ini</p>
                                <p class="font-semibold text-sanku-accent">Rp {{ number_format($withdrawal->user->balance, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Withdrawal Details -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-800 mb-3">Detail Penarikan</h4>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Jumlah Penarikan</p>
                                <p class="text-3xl font-bold text-sanku-accent">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600 mb-1">Metode Penarikan</p>
                                <p class="text-xl font-semibold text-gray-800 capitalize">{{ ucfirst($withdrawal->method) }}</p>
                            </div>

                            @if($withdrawal->method != 'cash')
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Nomor Akun/Rekening</p>
                                    <p class="font-semibold text-gray-800">{{ $withdrawal->account_number }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Nama Pemilik</p>
                                    <p class="font-semibold text-gray-800">{{ $withdrawal->account_name }}</p>
                                </div>

                                @if($withdrawal->bank_name)
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Nama Bank</p>
                                        <p class="font-semibold text-gray-800">{{ $withdrawal->bank_name }}</p>
                                    </div>
                                @endif
                            @endif

                            @if($withdrawal->processed_at)
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Diproses Tanggal</p>
                                    <p class="font-semibold text-gray-800">{{ $withdrawal->processed_at->setTimezone('Asia/Makassar')->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WITA</p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Diproses Oleh</p>
                                    <p class="font-semibold text-gray-800">{{ $withdrawal->processor->name ?? 'Admin' }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Rejection Reason -->
                    @if($withdrawal->status == 'rejected' && $withdrawal->rejection_reason)
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm font-semibold text-red-800 mb-1">Alasan Penolakan:</p>
                            <p class="text-sm text-red-700">{{ $withdrawal->rejection_reason }}</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    @if($withdrawal->status == 'pending')
                        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="font-semibold text-gray-800 mb-4">Proses Pengajuan Ini:</p>
                            <div class="flex flex-wrap gap-3">
                                <form method="POST" action="{{ route('admin.transaction.approve', $withdrawal->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menyetujui pengajuan ini?');">
                                    @csrf
                                    <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-lg font-bold hover:bg-blue-600 transition flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Setujui
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.transaction.complete', $withdrawal->id) }}" class="inline" onsubmit="return confirm('Yakin penarikan sudah selesai diproses?');">
                                    @csrf
                                    <button type="submit" class="px-6 py-3 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600 transition flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Selesaikan
                                    </button>
                                </form>

                                <button type="button" onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="px-6 py-3 bg-red-500 text-white rounded-lg font-bold hover:bg-red-600 transition flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak
                                </button>
                            </div>
                        </div>
                    @elseif($withdrawal->status == 'approved')
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="font-semibold text-gray-800 mb-4">Pengajuan Sudah Disetujui. Selesaikan Transaksi:</p>
                            <form method="POST" action="{{ route('admin.transaction.complete', $withdrawal->id) }}" class="inline" onsubmit="return confirm('Yakin penarikan sudah selesai diproses?');">
                                @csrf
                                <button type="submit" class="px-6 py-3 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600 transition flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Tandai Selesai
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Back Button -->
                    <div>
                        <a href="{{ route('admin.transaction.index') }}" class="inline-block px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                            ← Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Tolak Pengajuan</h3>
            
            <form method="POST" action="{{ route('admin.transaction.reject', $withdrawal->id) }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="rejection_reason" rows="4" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" placeholder="Jelaskan alasan penolakan..." required></textarea>
                    <p class="text-sm text-gray-600 mt-1">Minimal 10 karakter</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 py-3 bg-red-500 text-white rounded-lg font-bold hover:bg-red-600 transition">
                        Tolak Pengajuan
                    </button>
                    <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>