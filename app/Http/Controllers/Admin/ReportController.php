<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExchangeTransaction;
use App\Models\WithdrawalRequest;
use App\Models\ExchangeItem;
use App\Models\WasteType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $startDate = Carbon::parse($month . '-01')->startOfMonth();
        $endDate = Carbon::parse($month . '-01')->endOfMonth();
        
        // Summary statistics
        $summary = [
            'total_transactions' => ExchangeTransaction::whereBetween('transaction_date', [$startDate, $endDate])->count(),
            'total_points_distributed' => ExchangeTransaction::whereBetween('transaction_date', [$startDate, $endDate])->sum('total_points'),
            'total_withdrawals' => WithdrawalRequest::whereBetween('requested_at', [$startDate, $endDate])
                ->whereIn('status', ['approved', 'completed'])
                ->sum('amount'),
            'total_nasabah_active' => ExchangeTransaction::whereBetween('transaction_date', [$startDate, $endDate])
                ->distinct('user_id')
                ->count('user_id'),
        ];
        
        // Waste type statistics
        $wasteStats = ExchangeItem::select('waste_type_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(subtotal_points) as total_points'))
            ->whereHas('transaction', function($q) use ($startDate, $endDate) {
                $q->whereBetween('transaction_date', [$startDate, $endDate]);
            })
            ->with('wasteType')
            ->groupBy('waste_type_id')
            ->get();
        
        // Daily transaction chart
        $dailyTransactions = ExchangeTransaction::selectRaw('DATE(transaction_date) as date, COUNT(*) as count, SUM(total_points) as points')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Top contributors
        $topContributors = ExchangeTransaction::select('user_id', DB::raw('COUNT(*) as transaction_count'), DB::raw('SUM(total_points) as total_points'))
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->with('user')
            ->groupBy('user_id')
            ->orderByDesc('total_points')
            ->take(10)
            ->get();
        
        return view('admin.report.index', compact('summary', 'wasteStats', 'dailyTransactions', 'topContributors', 'month'));
    }
    
    public function export(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $startDate = Carbon::parse($month . '-01')->startOfMonth();
        $endDate = Carbon::parse($month . '-01')->endOfMonth();
        
        $transactions = ExchangeTransaction::with(['user', 'items.wasteType'])
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->orderBy('transaction_date')
            ->get();
        
        $withdrawals = WithdrawalRequest::with('user')
            ->whereBetween('requested_at', [$startDate, $endDate])
            ->orderBy('requested_at')
            ->get();
        
        return view('admin.report.export', compact('transactions', 'withdrawals', 'month'));
    }
}