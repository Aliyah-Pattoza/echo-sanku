<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = WithdrawalRequest::with(['user', 'processor']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by method
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }
        
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('request_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $withdrawals = $query->latest('requested_at')->paginate(15);
        
        return view('admin.transaction.index', compact('withdrawals'));
    }
    
    public function show($id)
    {
        $withdrawal = WithdrawalRequest::with(['user.profile', 'processor'])
            ->findOrFail($id);
        
        return view('admin.transaction.show', compact('withdrawal'));
    }
    
    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $withdrawal = WithdrawalRequest::findOrFail($id);
            
            if ($withdrawal->status !== 'pending') {
                return back()->with('error', 'Pengajuan ini sudah diproses');
            }
            
            $withdrawal->update([
                'status' => 'approved',
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);
            
            DB::commit();
            
            return back()->with('success', 'Pengajuan penarikan disetujui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function complete($id)
    {
        DB::beginTransaction();
        try {
            $withdrawal = WithdrawalRequest::findOrFail($id);
            
            if (!in_array($withdrawal->status, ['pending', 'approved'])) {
                return back()->with('error', 'Pengajuan ini sudah diproses');
            }
            
            $withdrawal->update([
                'status' => 'completed',
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);
            
            DB::commit();
            
            return back()->with('success', 'Penarikan selesai diproses');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);
        
        DB::beginTransaction();
        try {
            $withdrawal = WithdrawalRequest::findOrFail($id);
            
            if ($withdrawal->status !== 'pending') {
                return back()->with('error', 'Pengajuan ini sudah diproses');
            }
            
            // Return balance to user
            $withdrawal->user->addBalance($withdrawal->amount);
            
            $withdrawal->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);
            
            DB::commit();
            
            return back()->with('success', 'Pengajuan penarikan ditolak');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}