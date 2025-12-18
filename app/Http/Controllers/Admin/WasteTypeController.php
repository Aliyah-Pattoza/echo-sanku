<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WasteType;

class WasteTypeController extends Controller
{
    public function index()
    {
        $wasteTypes = WasteType::latest()->paginate(10);
        return view('admin.waste-type.index', compact('wasteTypes'));
    }
    
    public function create()
    {
        return view('admin.waste-type.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|in:pcs,kg',
            'point_per_unit' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);
        
        WasteType::create($request->all());
        
        return redirect()->route('admin.waste-type.index')
            ->with('success', 'Jenis sampah berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $wasteType = WasteType::findOrFail($id);
        return view('admin.waste-type.edit', compact('wasteType'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|in:pcs,kg',
            'point_per_unit' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $wasteType = WasteType::findOrFail($id);
        $wasteType->update($request->all());
        
        return redirect()->route('admin.waste-type.index')
            ->with('success', 'Jenis sampah berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $wasteType = WasteType::findOrFail($id);
        $wasteType->delete();
        
        return redirect()->route('admin.waste-type.index')
            ->with('success', 'Jenis sampah berhasil dihapus');
    }
}