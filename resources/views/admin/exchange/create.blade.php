<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Transaksi Penukaran') }}
        </h2>
    </x-slot>

    <!-- Alpine.js harus dimuat SEBELUM digunakan -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-sanku-accent bg-opacity-20 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sanku-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Form Transaksi Baru</h3>
                            <p class="text-sm text-gray-600">Input transaksi penukaran sampah nasabah</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.exchange.store') }}" 
                          x-data="exchangeForm()" 
                          @submit.prevent="validateAndSubmit">
                        @csrf

                        <!-- Pilih Nasabah -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Pilih Nasabah <span class="text-red-500">*</span>
                            </label>
                            <select name="user_id" 
                                    x-model="selectedUser"
                                    class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" 
                                    required>
                                <option value="">-- Pilih Nasabah --</option>
                                @foreach($nasabah as $n)
                                    <option value="{{ $n->id }}" {{ old('user_id') == $n->id ? 'selected' : '' }}>
                                        {{ $n->name }} - {{ $n->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Items Section -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <label class="block text-sm font-semibold text-gray-700">
                                    Item Sampah <span class="text-red-500">*</span>
                                </label>
                                <button type="button" 
                                        @click="addItem"
                                        class="px-4 py-2 bg-sanku-accent text-white rounded-lg font-semibold hover:bg-sanku-primary transition text-sm flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Item
                                </button>
                            </div>

                            <div class="space-y-3">
                                <template x-for="(item, index) in items" :key="index">
                                    <div class="flex gap-3 items-start p-4 border-2 border-gray-200 rounded-xl hover:border-sanku-accent transition">
                                        <!-- Jenis Sampah -->
                                        <div class="flex-1">
                                            <label class="text-xs font-semibold text-gray-600 mb-1 block">Jenis Sampah</label>
                                            <select :name="'items[' + index + '][waste_type_id]'"
                                                    x-model="item.waste_type_id"
                                                    @change="updateItemPrice(index)"
                                                    class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50 text-sm"
                                                    required>
                                                <option value="">-- Pilih --</option>
                                                @foreach($wasteTypes as $type)
                                                    <option value="{{ $type->id }}" 
                                                            data-point="{{ $type->point_per_unit }}"
                                                            data-unit="{{ $type->unit }}">
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Kuantitas -->
                                        <div class="w-32">
                                            <label class="text-xs font-semibold text-gray-600 mb-1 block">Jumlah</label>
                                            <input type="number" 
                                                   :name="'items[' + index + '][quantity]'"
                                                   x-model="item.quantity"
                                                   @input="calculateSubtotal(index)"
                                                   step="0.01" 
                                                   min="0.01"
                                                   class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50 text-sm"
                                                   placeholder="0.00"
                                                   required>
                                        </div>

                                        <!-- Satuan -->
                                        <div class="w-20">
                                            <label class="text-xs font-semibold text-gray-600 mb-1 block">Satuan</label>
                                            <input type="text" 
                                                   x-model="item.unit"
                                                   class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm text-center"
                                                   readonly>
                                        </div>

                                        <!-- Harga per Unit -->
                                        <div class="w-32">
                                            <label class="text-xs font-semibold text-gray-600 mb-1 block">Harga/Unit</label>
                                            <input type="text" 
                                                   x-model="formatCurrency(item.point_per_unit)"
                                                   class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm text-right"
                                                   readonly>
                                        </div>

                                        <!-- Subtotal -->
                                        <div class="w-40">
                                            <label class="text-xs font-semibold text-gray-600 mb-1 block">Subtotal</label>
                                            <input type="text" 
                                                   x-model="formatCurrency(item.subtotal)"
                                                   class="w-full rounded-lg border-gray-300 bg-sanku-accent bg-opacity-10 text-sm text-right font-bold text-sanku-accent"
                                                   readonly>
                                        </div>

                                        <!-- Remove Button -->
                                        <div class="pt-6">
                                            <button type="button" 
                                                    @click="removeItem(index)"
                                                    class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition"
                                                    title="Hapus item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>

                                <!-- Empty State -->
                                <div x-show="items.length === 0" class="text-center py-8 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-sm">Belum ada item. Klik "Tambah Item" untuk mulai.</p>
                                </div>
                            </div>

                            @error('items')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Points Display -->
                        <div class="mb-6 p-6 bg-gradient-to-br from-sanku-accent to-sanku-primary bg-opacity-20 rounded-xl border-2 border-sanku-accent">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 mb-1">Total Poin Transaksi</p>
                                    <p class="text-xs text-gray-600">Total dari <span x-text="items.length"></span> item</p>
                                </div>
                                <p class="text-4xl font-bold text-sanku-accent" x-text="formatCurrency(totalPoints)"></p>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" 
                                      rows="3" 
                                      class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" 
                                      placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-3">
                            <button type="submit" 
                                    class="flex-1 py-3 bg-sanku-accent text-white rounded-lg font-bold hover:bg-sanku-primary transition flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Transaksi
                            </button>
                            <a href="{{ route('admin.exchange.index') }}" 
                               class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function exchangeForm() {
            return {
                selectedUser: '{{ old('user_id') }}',
                items: [],
                wasteTypes: @json($wasteTypes),
                
                init() {
                    // Add first item on load
                    this.addItem();
                },
                
                addItem() {
                    this.items.push({
                        waste_type_id: '',
                        quantity: '',
                        unit: '',
                        point_per_unit: 0,
                        subtotal: 0
                    });
                },
                
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    } else {
                        alert('Minimal harus ada 1 item!');
                    }
                },
                
                updateItemPrice(index) {
                    const item = this.items[index];
                    const select = document.querySelectorAll('select[name^="items"]')[index];
                    const selectedOption = select.options[select.selectedIndex];
                    
                    if (selectedOption.value) {
                        item.point_per_unit = parseFloat(selectedOption.dataset.point) || 0;
                        item.unit = selectedOption.dataset.unit || '';
                        this.calculateSubtotal(index);
                    } else {
                        item.point_per_unit = 0;
                        item.unit = '';
                        item.subtotal = 0;
                    }
                },
                
                calculateSubtotal(index) {
                    const item = this.items[index];
                    const quantity = parseFloat(item.quantity) || 0;
                    item.subtotal = item.point_per_unit * quantity;
                },
                
                get totalPoints() {
                    return this.items.reduce((sum, item) => sum + (item.subtotal || 0), 0);
                },
                
                formatCurrency(value) {
                    if (!value || value === 0) return 'Rp 0';
                    return 'Rp ' + Math.round(value).toLocaleString('id-ID');
                },
                
                validateAndSubmit(e) {
                    if (this.items.length === 0) {
                        alert('Tambahkan minimal 1 item sampah!');
                        return false;
                    }
                    
                    if (!this.selectedUser) {
                        alert('Pilih nasabah terlebih dahulu!');
                        return false;
                    }
                    
                    // Check if all items are filled
                    for (let i = 0; i < this.items.length; i++) {
                        if (!this.items[i].waste_type_id || !this.items[i].quantity || this.items[i].quantity <= 0) {
                            alert('Lengkapi semua item sampah!');
                            return false;
                        }
                    }
                    
                    // Submit form
                    e.target.submit();
                }
            }
        }
    </script>
</x-app-layout>