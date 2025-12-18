<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transaksi Penukaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-sanku-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Transaksi {{ $transaction->transaction_code }}
                    </h3>

                    <form method="POST" action="{{ route('admin.exchange.update', $transaction->id) }}" id="exchangeForm">
                        @csrf
                        @method('PUT')

                        <!-- Pilih Nasabah -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Nasabah <span class="text-red-500">*</span></label>
                            <select name="user_id" id="user_id" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" required>
                                <option value="">-- Pilih Nasabah --</option>
                                @foreach($nasabah as $n)
                                    <option value="{{ $n->id }}" {{ old('user_id', $transaction->user_id) == $n->id ? 'selected' : '' }}>
                                        {{ $n->name }} ({{ $n->email }})
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
                                <label class="block text-sm font-semibold text-gray-700">Item Sampah <span class="text-red-500">*</span></label>
                                <button type="button" id="addItemBtn" class="px-4 py-2 bg-sanku-accent text-white rounded-lg font-semibold hover:bg-sanku-primary transition text-sm flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Item
                                </button>
                            </div>

                            <div id="itemsContainer" class="space-y-4">
                                <!-- Existing items will be loaded here -->
                            </div>

                            @error('items')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Points Display -->
                        <div class="mb-6 p-4 bg-sanku-accent bg-opacity-20 rounded-lg">
                            <p class="text-sm text-gray-700 mb-1">Total Poin:</p>
                            <p class="text-3xl font-bold text-sanku-accent" id="totalPoints">Rp 0</p>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes', $transaction->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 py-3 bg-sanku-accent text-white rounded-lg font-bold hover:bg-sanku-primary transition">
                                Update Transaksi
                            </button>
                            <a href="{{ route('admin.exchange.show', $transaction->id) }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const wasteTypes = @json($wasteTypes);
        const existingItems = @json($transaction->items);
        let itemIndex = 0;

        function createItemRow(existingData = null) {
            const row = document.createElement('div');
            row.className = 'flex gap-4 items-start p-4 border border-gray-200 rounded-lg';
            row.id = `item-${itemIndex}`;
            
            row.innerHTML = `
                <div class="flex-1 grid md:grid-cols-3 gap-4">
                    <div>
                        <select name="items[${itemIndex}][waste_type_id]" class="waste-type-select w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" required>
                            <option value="">-- Pilih Jenis Sampah --</option>
                            ${wasteTypes.map(type => `
                                <option value="${type.id}" data-point="${type.point_per_unit}" data-unit="${type.unit}" 
                                    ${existingData && existingData.waste_type_id == type.id ? 'selected' : ''}>
                                    ${type.name} (Rp ${Number(type.point_per_unit).toLocaleString('id-ID')}/${type.unit})
                                </option>
                            `).join('')}
                        </select>
                    </div>
                    <div>
                        <input type="number" name="items[${itemIndex}][quantity]" step="0.01" min="0.01" 
                            value="${existingData ? existingData.quantity : ''}" 
                            placeholder="Jumlah" class="quantity-input w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <input type="text" class="subtotal-display w-full rounded-lg border-gray-300 bg-gray-100" placeholder="Subtotal" readonly>
                    </div>
                </div>
                <button type="button" class="remove-item p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition" onclick="removeItem(${itemIndex})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            `;

            const wasteTypeSelect = row.querySelector('.waste-type-select');
            const quantityInput = row.querySelector('.quantity-input');
            const subtotalDisplay = row.querySelector('.subtotal-display');

            function calculateSubtotal() {
                const selectedOption = wasteTypeSelect.options[wasteTypeSelect.selectedIndex];
                const pointPerUnit = parseFloat(selectedOption.dataset.point) || 0;
                const quantity = parseFloat(quantityInput.value) || 0;
                const subtotal = pointPerUnit * quantity;
                
                subtotalDisplay.value = subtotal > 0 ? `Rp ${subtotal.toLocaleString('id-ID')}` : '';
                calculateTotal();
            }

            wasteTypeSelect.addEventListener('change', calculateSubtotal);
            quantityInput.addEventListener('input', calculateSubtotal);

            // Calculate initial subtotal for existing data
            if (existingData) {
                setTimeout(calculateSubtotal, 100);
            }

            itemIndex++;
            return row;
        }

        function removeItem(index) {
            const row = document.getElementById(`item-${index}`);
            if (row) {
                row.remove();
                calculateTotal();
            }
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.waste-type-select').forEach((select, idx) => {
                const selectedOption = select.options[select.selectedIndex];
                const pointPerUnit = parseFloat(selectedOption.dataset.point) || 0;
                const quantityInput = select.closest('.flex').querySelector('.quantity-input');
                const quantity = parseFloat(quantityInput.value) || 0;
                total += pointPerUnit * quantity;
            });

            document.getElementById('totalPoints').textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        document.getElementById('addItemBtn').addEventListener('click', function() {
            const container = document.getElementById('itemsContainer');
            container.appendChild(createItemRow());
        });

        // Load existing items on page load
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('itemsContainer');
            
            if (existingItems.length > 0) {
                existingItems.forEach(item => {
                    container.appendChild(createItemRow(item));
                });
            } else {
                container.appendChild(createItemRow());
            }
        });
    </script>
    @endpush
</x-app-layout>