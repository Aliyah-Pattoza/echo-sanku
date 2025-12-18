<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ExchangeTransaction;
use App\Models\WithdrawalRequest;
use App\Models\WasteType;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_nasabah' => User::nasabah()->active()->count(),
            'pending_withdrawals' => WithdrawalRequest::pending()->count(),
            'monthly_transactions' => ExchangeTransaction::whereMonth('transaction_date', Carbon::now()->month)
                ->whereYear('transaction_date', Carbon::now()->year)
                ->count(),
            'total_points_distributed' => ExchangeTransaction::whereMonth('transaction_date', Carbon::now()->month)
                ->whereYear('transaction_date', Carbon::now()->year)
                ->sum('total_points'),
        ];
        
        // Recent transactions
        $recentTransactions = ExchangeTransaction::with(['user', 'items.wasteType'])
            ->latest('transaction_date')
            ->take(5)
            ->get();
        
        // Pending withdrawals
        $pendingWithdrawals = WithdrawalRequest::with('user')
            ->pending()
            ->latest('requested_at')
            ->take(5)
            ->get();
        
        // Chart data - Daily transactions this month
        $dailyTransactions = ExchangeTransaction::selectRaw('DATE(transaction_date) as date, COUNT(*) as count, SUM(total_points) as points')
            ->whereMonth('transaction_date', Carbon::now()->month)
            ->whereYear('transaction_date', Carbon::now()->year)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return view('admin.dashboard', compact('stats', 'recentTransactions', 'pendingWithdrawals', 'dailyTransactions'));
    }
}