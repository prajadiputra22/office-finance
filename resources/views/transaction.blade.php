@extends('layouts.app')

@section('title', 'Tigajaya Finance')

@section('content')
    <main class="flex-1 pt-4" x-data="{ openAddTransaksi: false, sliderValue: 50000 }">
        <!-- Added missing search bar -->
        <div class="relative flex-1 bg-white max-w-[600px] rounded-xl  mb-8">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="text" placeholder="Cari riwayat transaksi"
                class="w-full pl-12 pr-4 py-2 border-2 rounded-lg bg-[#f8f9fa] focus:border-[#0B3B9F] focus:bg-white outline-none text-sm">
        </div>

        <div class="flex gap-5 mb-8 flex-wrap animate-fadeIn">
            <button type="button" @click="openAddTransaksi = true"
                class="flex items-center px-6 bg-white border-2 border-[#e1e5e9] rounded-xl font-semibold text-gray-700 hover:bg-[#0B3B9F] hover:text-white hover-translate shadow">
                <span class="mr-2 font-bold text-xl">+</span>
                Tambah Transaksi
            </button>

            <div class="flex gap-5 flex-1 flex-wrap">
                <div
                    class="flex-1 px-6 py-4 bg-white border border-[#e1e5e9] rounded-xl shadow hover:shadow-lg transition animate-slideInLeft">
                    <h3 class="text-[#0B3B9F] font-medium mb-2">Pemasukan</h3>
                    <p class="text-[25px] font-bold text-[#1f2937]">
                        {{ 'IDR ' . number_format($income ?? 0, 0, ',', '.') }}</p>
                </div>
                <div
                    class="flex-1 px-6 py-4 bg-white border border-[#e1e5e9] rounded-xl shadow hover:shadow-lg transition animate-slideInLeft">
                    <h3 class="text-[#F20E0F] font-medium mb-2">Pengeluaran</h3>
                    <p class="text-[25px] font-bold text-[#1f2937]">
                        {{ 'IDR ' . number_format($expenditure ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="bg-white rounded-xl shadow p-6 animate-fadeIn">
            <h2 class="text-lg font-bold mb-5 text-[#333]">Riwayat Transaksi</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border border-[#e1e5e9] rounded-lg overflow-hidden text-sm">
                    <thead class="bg-[#f8f9fa]">
                        <tr>
                            <th class="p-4 font-semibold text-[#333]">Tanggal</th>
                            <th class="p-4 font-semibold text-[#333]">Kategori</th>
                            <th class="p-4 font-semibold text-[#333]">Status</th>
                            <th class="p-4 font-semibold text-[#333]">Jumlah</th>
                            <th class="p-4 font-semibold text-[#333]">Keterangan</th>
                            <th class="p-4 font-semibold text-[#333]">Lampiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $trx)
                            <tr class="border-b border-[#e1e5e9] hover:bg-[#f8f9fa]">
                                <td class="p-4">{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                                <td class="p-4">{{ $trx->category->name ?? $trx->category->category_name ?? 'Tidak ada kategori' }}</td>
                                <td class="p-4">
                                    <span
                                        class="{{ $trx->type == 'income' ? 'bg-blue-100 text-[#0B3B9F]' : 'bg-red-100 text-[#F20E0F]' }} px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $trx->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="font-semibold text-gray-800">
                                        {{ 'IDR ' . number_format($trx->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @if ($trx->description)
                                        <span class="text-sm text-gray-600">{{ $trx->description }}</span>
                                    @else
                                        <span class="text-sm text-gray-400 italic">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">
                                    Belum ada transaksi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($transactions, 'links'))
                <div class="mt-6">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>

        <!-- Form Transaksi -->
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-show="openAddTransaksi"
            x-transition.opacity style="display: none;">
            <div class="bg-white p-4 rounded-xl w-full max-w-sm shadow-lg max-h-[90vh] overflow-y-auto" @click.outside="openAddTransaksi = false">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-base font-semibold">Tambah Transaksi</h2>
                    <button type="button" class="text-gray-500 hover:text-gray-800" @click="openAddTransaksi = false">
                        ✕
                    </button>
                </div>
                
                <!-- Validation -->
                <div id="validation-errors" class="hidden mb-3 p-2 bg-red-100 border border-red-300 rounded-md">
                    <ul id="error-list" class="text-xs text-red-600 list-disc list-inside"></ul>
                </div>
                
                <form action="{{ route('transactions.store') }}" method="POST" class="space-y-3" id="transaction-form" onsubmit="return validateForm()">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium mb-1">Tipe <span class="text-red-500">*</span></label>
                            <select name="type" id="transaction-type" onchange="loadCategories(this.value)"
                                class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#84cc16] focus:border-[#84cc16]">
                                <option value="">Pilih Tipe</option>
                                <option value="income">Pemasukan</option>
                                <option value="expenditure">Pengeluaran</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1">Kategori <span class="text-red-500">*</span></label>
                            <select name="category_id" id="category-select"
                                class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#84cc16] focus:border-[#84cc16]">
                                <option value="">Pilih Tipe Dulu</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">
                            Jumlah: <span class="font-bold text-[#84cc16] text-xs" x-text="'IDR ' + sliderValue.toLocaleString('id-ID')"></span>
                        </label>
                        <div class="space-y-2">
                            <input type="range" 
                                x-model="sliderValue"
                                min="10000" 
                                max="10000000" 
                                step="10000"
                                @input="updateAmountFromSlider()"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                            
                            <input type="text" 
                                id="amount-input"
                                name="amount_display" 
                                placeholder="Contoh: 1.000.000"
                                oninput="formatAmountInput(this)"
                                class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#84cc16] focus:border-[#84cc16]">
                            <input type="hidden" name="amount" id="amount-hidden">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">Tanggal</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}"
                            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#84cc16] focus:border-[#84cc16]">
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">Keterangan</label>
                        <textarea name="description" rows="2" placeholder="Keterangan (opsional)"
                            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#84cc16] focus:border-[#84cc16] resize-none"></textarea>
                    </div>

                    <!-- Button -->
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="openAddTransaksi = false"
                            class="px-3 py-1.5 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition text-xs">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-3 py-1.5 bg-[#84cc16] text-white rounded-md hover:bg-[#65a30d] transition text-xs">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function validateForm() {
            const errors = [];
            const type = document.getElementById('transaction-type').value;
            const category = document.getElementById('category-select').value;
            const amount = document.getElementById('amount-hidden').value;
            
            if (!type) {
                errors.push('Tipe transaksi harus dipilih');
            }
            
            if (!category) {
                errors.push('Kategori harus dipilih');
            }
            
            if (!amount || amount <= 0) {
                errors.push('Jumlah harus diisi dan lebih dari 0');
            }
            
            if (errors.length > 0) {
                showValidationErrors(errors);
                return false;
            }
            
            hideValidationErrors();
            return true;
        }
        
        function showValidationErrors(errors) {
            const errorContainer = document.getElementById('validation-errors');
            const errorList = document.getElementById('error-list');
            
            errorList.innerHTML = '';
            errors.forEach(error => {
                const li = document.createElement('li');
                li.textContent = error;
                errorList.appendChild(li);
            });
            
            errorContainer.classList.remove('hidden');
        }
        
        function hideValidationErrors() {
            document.getElementById('validation-errors').classList.add('hidden');
        }
        
        function formatAmountInput(input) {
            let value = input.value.replace(/\D/g, '');
            
            if (value) {
                const formatted = parseInt(value).toLocaleString('id-ID');
                input.value = formatted;
                
                document.getElementById('amount-hidden').value = value;
            
            } else {
                document.getElementById('amount-hidden').value = '';
            }
            
            hideValidationErrors();
        }
        
        function updateAmountInput() {
            const slider = document.querySelector('input[type="range"]');
            const amountInput = document.getElementById('amount-input');
            const hiddenInput = document.getElementById('amount-hidden');
            
            const value = slider.value;
            amountInput.value = parseInt(value).toLocaleString('id-ID');
            hiddenInput.value = value;
        }

        function updateAmountFromSlider() {
            const sliderValue = document.querySelector('input[type="range"]').value;
            const amountInput = document.getElementById('amount-input');
            const hiddenInput = document.getElementById('amount-hidden');
            
            amountInput.value = parseInt(sliderValue).toLocaleString('id-ID');
            hiddenInput.value = sliderValue;
        }

        function loadCategories(type) {
            const categorySelect = document.getElementById('category-select');
            
            categorySelect.innerHTML = '<option value="">Loading...</option>';
            
            if (!type) {
                categorySelect.innerHTML = '<option value="">Pilih Tipe Dulu</option>';
                return;
            }
            
            fetch(`/api/category/${type}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(categories => {
                    categorySelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';
                    
                    if (categories.length === 0) {
                        categorySelect.innerHTML += `<option value="" disabled>Tidak ada kategori ${type === 'income' ? 'pemasukan' : 'pengeluaran'}</option>`;
                    } else {
                        categories.forEach(category => {
                            categorySelect.innerHTML += `<option value="${category.id}">${category.category_name}</option>`;
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading categories:', error);
                    categorySelect.innerHTML = '<option value="">Gagal memuat kategori</option>';
                });
            
            hideValidationErrors();
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('transactionForm', () => ({
                openAddTransaksi: false,
                sliderValue: 50000,
                init() {
                    this.$watch('openAddTransaksi', (value) => {
                        if (!value) {
                            document.getElementById('transaction-type').value = '';
                            document.getElementById('category-select').innerHTML = '<option value="">Pilih Tipe Dulu</option>';
                            document.getElementById('amount-input').value = '';
                            document.getElementById('amount-hidden').value = '';
                            this.sliderValue = 50000;
                            hideValidationErrors();
                        } else {
                            updateAmountFromSlider();
                        }
                    });
                    
                    this.$watch('sliderValue', (value) => {
                        const amountInput = document.getElementById('amount-input');
                        const hiddenInput = document.getElementById('amount-hidden');
                        if (amountInput && hiddenInput) {
                            amountInput.value = parseInt(value).toLocaleString('id-ID');
                            hiddenInput.value = value;
                        }
                    });
                }
            }));
        });
    </script>
@endsection
