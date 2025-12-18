<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExchangeTransaction;
use App\Models\ExchangeItem;
use Illuminate\Support\Facades\Auth;
use App\Models\WasteType;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ExchangeController extends Controller
{
    public function index(Request $request)
    {
        $query = ExchangeTransaction::with(['user', 'items.wasteType', 'admin']);
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }
        
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('transaction_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $transactions = $query->latest('transaction_date')->paginate(15);
        
        return view('admin.exchange.index', compact('transactions'));
    }
    
    public function create()
    {
        $nasabah = User::nasabah()->active()->orderBy('name')->get();
        $wasteTypes = WasteType::active()->get();
        
        return view('admin.exchange.create', compact('nasabah', 'wasteTypes'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.waste_type_id' => 'required|exists:waste_types,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            // Calculate total points
            $totalPoints = 0;
            $items = [];
            
            foreach ($request->items as $item) {
                $wasteType = WasteType::findOrFail($item['waste_type_id']);
                $subtotal = $item['quantity'] * $wasteType->point_per_unit;
                $totalPoints += $subtotal;
                
                $items[] = [
                    'waste_type_id' => $item['waste_type_id'],
                    'quantity' => $item['quantity'],
                    'point_per_unit' => $wasteType->point_per_unit,
                    'subtotal_points' => $subtotal,
                ];
            }
            
            // Create transaction
            $transaction = ExchangeTransaction::create([
                'user_id' => $request->user_id,
                'admin_id' => Auth::id(),
                'total_points' => $totalPoints,
                'notes' => $request->notes,
            ]);
            
            // Create items
            foreach ($items as $item) {
                $transaction->items()->create($item);
            }
            
            // Add balance to user
            $user = User::findOrFail($request->user_id);
            $user->addBalance($totalPoints);
            
            DB::commit();
            
            return redirect()->route('admin.exchange.show', $transaction->id)
                ->with('success', 'Transaksi penukaran berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
    
    public function show($id)
    {
        $transaction = ExchangeTransaction::with(['user.profile', 'items.wasteType', 'admin'])
            ->findOrFail($id);
        
        return view('admin.exchange.show', compact('transaction'));
    }
    
    public function edit($id)
    {
        $transaction = ExchangeTransaction::with('items')->findOrFail($id);
        $nasabah = User::nasabah()->active()->orderBy('name')->get();
        $wasteTypes = WasteType::active()->get();
        
        return view('admin.exchange.edit', compact('transaction', 'nasabah', 'wasteTypes'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.waste_type_id' => 'required|exists:waste_types,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            $transaction = ExchangeTransaction::findOrFail($id);
            $oldTotalPoints = $transaction->total_points;
            $oldUserId = $transaction->user_id;
            
            // Calculate new total points
            $totalPoints = 0;
            $items = [];
            
            foreach ($request->items as $item) {
                $wasteType = WasteType::findOrFail($item['waste_type_id']);
                $subtotal = $item['quantity'] * $wasteType->point_per_unit;
                $totalPoints += $subtotal;
                
                $items[] = [
                    'waste_type_id' => $item['waste_type_id'],
                    'quantity' => $item['quantity'],
                    'point_per_unit' => $wasteType->point_per_unit,
                    'subtotal_points' => $subtotal,
                ];
            }
            
            // Update transaction
            $transaction->update([
                'user_id' => $request->user_id,
                'total_points' => $totalPoints,
                'notes' => $request->notes,
            ]);
            
            // Delete old items and create new ones
            $transaction->items()->delete();
            foreach ($items as $item) {
                $transaction->items()->create($item);
            }
            
            // Adjust balances
            if ($oldUserId != $request->user_id) {
                // Different user - deduct from old, add to new
                User::findOrFail($oldUserId)->deductBalance($oldTotalPoints);
                User::findOrFail($request->user_id)->addBalance($totalPoints);
            } else {
                // Same user - adjust difference
                $difference = $totalPoints - $oldTotalPoints;
                if ($difference > 0) {
                    User::findOrFail($request->user_id)->addBalance($difference);
                } elseif ($difference < 0) {
                    User::findOrFail($request->user_id)->deductBalance(abs($difference));
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.exchange.show', $transaction->id)
                ->with('success', 'Transaksi berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
    
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $transaction = ExchangeTransaction::findOrFail($id);
            
            // Deduct balance from user
            $transaction->user->deductBalance($transaction->total_points);
            
            // Delete transaction (items will be cascade deleted)
            $transaction->delete();
            
            DB::commit();
            
            return redirect()->route('admin.exchange.index')
                ->with('success', 'Transaksi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}