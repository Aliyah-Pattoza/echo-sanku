<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jenis Sampah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Edit Jenis Sampah</h3>

                    <form method="POST" action="{{ route('admin.waste-type.update', $wasteType->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Jenis Sampah <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $wasteType->name) }}" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" placeholder="Contoh: Botol Plastik Besar" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Satuan <span class="text-red-500">*</span></label>
                            <select name="unit" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" required>
                                <option value="">-- Pilih Satuan --</option>
                                <option value="pcs" {{ old('unit', $wasteType->unit) == 'pcs' ? 'selected' : '' }}>Pcs (Pieces/Buah)</option>
                                <option value="kg" {{ old('unit', $wasteType->unit) == 'kg' ? 'selected' : '' }}>Kg (Kilogram)</option>
                            </select>
                            @error('unit')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Poin per Satuan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                <input type="number" name="point_per_unit" value="{{ old('point_per_unit', $wasteType->point_per_unit) }}" min="0" step="0.01" class="w-full pl-12 rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" placeholder="0" required>
                            </div>
                            @error('point_per_unit')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" placeholder="Deskripsi singkat tentang jenis sampah ini...">{{ old('description', $wasteType->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $wasteType->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-sanku-accent focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-semibold text-gray-700">Aktif</span>
                            </label>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 py-3 bg-sanku-accent text-white rounded-lg font-bold hover:bg-sanku-primary transition">
                                Update
                            </button>
                            <a href="{{ route('admin.waste-type.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>