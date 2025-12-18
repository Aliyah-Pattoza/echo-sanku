<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Jenis Sampah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Header with Add Button -->
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-800">Daftar Jenis Sampah</h3>
                <a href="{{ route('admin.waste-type.create') }}" class="px-6 py-3 bg-sanku-accent text-white rounded-lg font-bold hover:bg-sanku-primary transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Jenis Sampah
                </a>
            </div>

            <!-- Waste Types List -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-6">
                    @if($wasteTypes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-sanku-cream">
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Nama Jenis Sampah</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Satuan</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Poin per Satuan</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Deskripsi</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Status</th>
                                        <th class="p-3 text-left font-semibold text-sanku-dark">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wasteTypes as $index => $type)
                                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-sanku-light' }}">
                                            <td class="p-3 font-semibold text-gray-800">{{ $type->name }}</td>
                                            <td class="p-3 text-gray-600">{{ strtoupper($type->unit) }}</td>
                                            <td class="p-3 font-bold text-sanku-accent">Rp {{ number_format($type->point_per_unit, 0, ',', '.') }}</td>
                                            <td class="p-3 text-gray-600 text-sm">{{ Str::limit($type->description, 50) }}</td>
                                            <td class="p-3">
                                                @if($type->is_active)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                                                        Nonaktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="p-3">
                                                <div class="flex gap-2">
                                                    <a href="{{ route('admin.waste-type.edit', $type->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.waste-type.destroy', $type->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus jenis sampah ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $wasteTypes->links() }}
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <p>Belum ada jenis sampah</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>
