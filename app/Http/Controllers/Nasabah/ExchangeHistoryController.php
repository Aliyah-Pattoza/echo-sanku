<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExchangeTransaction;

class ExchangeHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ExchangeTransaction::where('user_id', Auth::id())
            ->with(['items.wasteType', 'admin']);
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }
        
        // Search by transaction code
        if ($request->filled('search')) {
            $query->where('transaction_code', 'like', '%' . $request->search . '%');
        }
        
        $transactions = $query->latest('transaction_date')->paginate(10);
        
        return view('nasabah.exchange-history', compact('transactions'));
    }
    
    public function show($id)
    {
        $transaction = ExchangeTransaction::where('user_id', Auth::id())
            ->with(['items.wasteType', 'admin'])
            ->findOrFail($id);
        
        return view('nasabah.exchange-detail', compact('transaction'));
    }
}