<!-- Alert Messages -->
@if($successMessage)
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ $successMessage }}</span>
    </div>
@endif

@if($pendingWithdrawals > 0)
    <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">
            Anda memiliki {{ $pendingWithdrawals }} pengajuan penarikan yang sedang diproses.
        </span>
    </div>
@endif
