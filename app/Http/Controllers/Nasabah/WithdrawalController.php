<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $query = WithdrawalRequest::where('user_id', Auth::id())
            ->with('processor');
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $withdrawals = $query->latest('requested_at')->paginate(10);
        
        return view('nasabah.withdrawal', compact('withdrawals'));
    }
    
    public function create()
    {
        $user = Auth::user();
        
        // Daftar e-wallet
        $ewallets = [
            'ShopeePay' => 'ShopeePay',
            'GoPay' => 'GoPay',
            'OVO' => 'OVO',
            'DANA' => 'DANA'
        ];
        
        // Daftar bank
        $banks = [
            'BRI' => 'BRI',
            'BNI' => 'BNI',
            'Mandiri' => 'Mandiri',
            'BCA' => 'BCA'
        ];
        
        return view('nasabah.withdrawal-create', compact('user', 'ewallets', 'banks'));
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Validasi dasar
        $rules = [
            'amount' => 'required|numeric|min:10000|max:' . $user->balance,
            'method' => 'required|in:cash,ewallet,bank',
        ];
        
        $messages = [
            'amount.required' => 'Jumlah penarikan harus diisi',
            'amount.numeric' => 'Jumlah penarikan harus berupa angka',
            'amount.min' => 'Minimal penarikan adalah Rp 10.000',
            'amount.max' => 'Saldo tidak mencukupi',
            'method.required' => 'Metode penarikan harus dipilih',
        ];
        
        // Validasi tambahan berdasarkan metode
        if ($request->method == 'ewallet') {
            $rules['ewallet_type'] = 'required|in:ShopeePay,GoPay,OVO,DANA';
            $rules['phone_number'] = 'required|regex:/^08[0-9]{8,11}$/';
            $messages['ewallet_type.required'] = 'Jenis e-wallet harus dipilih';
            $messages['phone_number.required'] = 'Nomor telepon harus diisi';
            $messages['phone_number.regex'] = 'Nomor telepon harus diawali 08 dan terdiri dari 10-13 digit';
        }
        
        if ($request->method == 'bank') {
            $rules['bank_name'] = 'required|in:BRI,BNI,Mandiri,BCA';
            $rules['account_number'] = 'required|numeric|digits_between:10,20';
            $rules['account_name'] = 'required|string|max:100';
            $messages['bank_name.required'] = 'Nama bank harus dipilih';
            $messages['account_number.required'] = 'Nomor rekening harus diisi';
            $messages['account_number.numeric'] = 'Nomor rekening harus berupa angka';
            $messages['account_number.digits_between'] = 'Nomor rekening harus 10-20 digit';
            $messages['account_name.required'] = 'Nama pemilik rekening harus diisi';
        }
        
        $request->validate($rules, $messages);
        
        DB::beginTransaction();
        try {
            $withdrawalData = [
                'user_id' => $user->id,
                'amount' => $request->amount,
                'method' => $request->method,
                'status' => 'pending',
            ];
            
            // Data spesifik untuk e-wallet
            if ($request->method == 'ewallet') {
                $withdrawalData['account_number'] = $request->phone_number;
                $withdrawalData['account_name'] = $user->name;
                $withdrawalData['bank_name'] = $request->ewallet_type;
            }
            
            // Data spesifik untuk bank
            if ($request->method == 'bank') {
                $withdrawalData['account_number'] = $request->account_number;
                $withdrawalData['account_name'] = $request->account_name;
                $withdrawalData['bank_name'] = $request->bank_name;
            }
            
            // Untuk cash, tidak perlu data tambahan
            if ($request->method == 'cash') {
                $withdrawalData['account_number'] = null;
                $withdrawalData['account_name'] = $user->name;
                $withdrawalData['bank_name'] = null;
            }
            
            $withdrawal = WithdrawalRequest::create($withdrawalData);
            
            // Kurangi saldo user - update via query builder to avoid calling ->save() on a non-Eloquent user
            DB::table('users')->where('id', $user->id)->decrement('balance', $request->amount);
            
            DB::commit();
            
            return redirect()->route('nasabah.withdrawal.index')
                ->with('success', 'Pengajuan penarikan berhasil dibuat. Menunggu persetujuan admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
    
    public function show($id)
    {
        $withdrawal = WithdrawalRequest::where('user_id', Auth::id())
            ->with('processor')
            ->findOrFail($id);
        
        return view('nasabah.withdrawal-detail', compact('withdrawal'));
    }
}