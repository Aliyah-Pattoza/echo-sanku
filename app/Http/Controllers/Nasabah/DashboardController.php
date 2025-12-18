<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExchangeTransaction;
use App\Models\WithdrawalRequest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get statistics
        $stats = [
            'balance' => $user->balance,
            'total_withdrawals' => WithdrawalRequest::where('user_id', $user->id)
                ->where('status', 'completed')
                ->sum('amount'),
            'monthly_transactions' => ExchangeTransaction::where('user_id', $user->id)
                ->whereMonth('transaction_date', Carbon::now()->month)
                ->whereYear('transaction_date', Carbon::now()->year)
                ->count(),
            'total_waste_items' => ExchangeTransaction::where('user_id', $user->id)
                ->withSum('items', 'quantity')
                ->get()
                ->sum('items_sum_quantity'),
        ];
        
        // Recent transactions
        $recentTransactions = ExchangeTransaction::where('user_id', $user->id)
            ->with(['items.wasteType'])
            ->latest('transaction_date')
            ->take(5)
            ->get();
        
        // Pending withdrawals
        $pendingWithdrawals = WithdrawalRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        
        return view('nasabah.dashboard', compact('stats', 'recentTransactions', 'pendingWithdrawals'));
    }
}