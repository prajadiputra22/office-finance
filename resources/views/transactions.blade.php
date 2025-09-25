@extends('layouts.app')

@section('title', 'Transaksi')

@section('header')
<header class="flex justify-between items-center mb-8 flex-wrap gap-4 animate-fadeIn">
<form method="GET" action="{{ route('transactions.index') }}" class="flex-1">
    <div class="relative flex-1 max-w-[600px] bg-white p-4 rounded-xl shadow">
        <input type="text" name="search" value="{{ request('search') }}"
        placeholder="Cari berdasarkan No. Faktur atau Keterangan"
        class="w-full pl-5 pr-4 py-2 border-2 border-[#e1e5e9] rounded-lg bg-[#f8f9fa] focus:border-[#0B3B9F] focus:bg-white outline-none text-sm">
        <div class="absolute right-5 top-1/2 -translate-y-1/2 flex items-center gap-2">
            @if (request('search'))
                <a href="{{ route('transactions.index') }}" class=" py-1 text-[#F20E0F] text-xl transition">
                    ✕
                </a>
        <div class="h-6 border-l border-gray-300"></div>
            @endif
            <button type="submit" class="py-2 pr-2 text-[#0B3B9F] flex items-center justify-center">
                <svg class="w-5 h-5 text-[#0B3B9F]" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="M21 21l-4.35-4.35"></path>
                </svg>
            </button>
        </div>
    </div>
</form>
    <div class="ml-5 flex-shrink-0 self-start">
        <h1 class="text-2xl font-bold text-[#F20E0F]"> TigaJaya <span class="text-[#0B3B9F]">Finance</span></h1>
    </div>
</header>
@endsection

@section('content')
<div x-data="transactionManager()"> 
    <div class="flex gap-5 mb-8 flex-wrap animate-fadeIn">
        <button
        type="button"
        @click="showAddModal = true"
        class="flex items-center px-6 py-4 bg-white border-2 border-[#e1e5e9] rounded-xl font-semibold text-gray-700 hover:bg-[#0B3B9F] hover:border-[#0B3B9F] hover:text-white hover-translate shadow">
            <span class="mr-2 font-bold text-xl">+</span>
            Tambahkan Transaksi
        </button>
        
        <div class="flex gap-5 flex-1 flex-wrap">
            <div class="flex-1 p-6 bg-white border border-[#e1e5e9] rounded-xl shadow hover:shadow-lg transition animate-slideInLeft">
                <h3 class="text-blue-600 font-medium">Pemasukan</h3>
                <p class="text-[25px] font-bold text-[#1f2937]">
                    {{'IDR'. number_format($income ?? 0, 0,',', '.') }}</p>
            </div>
            <div class="flex-1 p-6 bg-white border border-[#e1e5e9] rounded-xl shadow hover:shadow-lg transition animate-slideInLeft">
                <h3 class="text-red-600 font-medium">Pengeluaran</h3>
                <p class="text-[25px] font-bold text-[#1f2937]">
                    {{'IDR'. number_format($expenditure ?? 0, 0,',', '.') }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow p-6 animate-fadeIn">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-lg font-bold text-[#333]">
                    Riwayat Transaksi
                    @if (request('search'))
                        <span class="text-sm font-normal text-gray-600">
                            - Hasil pencarian: "{{ request('search') }}"
                        </span>
                    @endif
                </h2>
                <div class="flex gap-3">
                    <button @click="editSelected()" :disabled="selectedTransactions.length !== 1"
                        class="flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:bg-gray-300 disabled:cursor-not-allowed transition text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit
                    </button>
                    <button @click="deleteSelected()" :disabled="selectedTransactions.length === 0"
                        class="flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 disabled:bg-gray-300 disabled:cursor-not-allowed transition text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Hapus
                    </button>
                </div>
            </div>
            <div
                class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 hover:scrollbar-thumb-gray-400">
                <table class="w-full text-center border border-[#e1e5e9] rounded-lg overflow-hidden text-sm min-w-[800px]">
                    <thead class="bg-[#f8f9fa]">
                        <tr>
                            <th class="p-4 font-semibold text-[#333] text-center w-12">
                                <input type="checkbox" @change="toggleSelectAll()" :checked="selectAllChecked"
                                    :indeterminate="selectAllIndeterminate"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            </th>
                            <th class="p-4 font-semibold text-[#333] text-center">Tanggal Transaksi</th>
                            <th class="p-4 font-semibold text-[#333] text-center">Kategori</th>
                            <th class="p-4 font-semibold text-[#333] text-center">Status</th>
                            <th class="p-4 font-semibold text-[#333] text-center">Jumlah</th>
                            <th class="p-4 font-semibold text-[#333] text-center">No. Faktur</th>
                            <th class="p-4 font-semibold text-[#333] text-center">Tgl. Faktur</th>
                            <th class="p-4 font-semibold text-[#333] text-center">Lampiran</th>
                            <th class="p-4 font-semibold text-[#333] text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $trx)
                            <tr class="border-b border-[#e1e5e9] hover:bg-[#f8f9fa]">
                                <td class="p-4 text-center">
                                    <input type="checkbox" x-model="selectedTransactions" value="{{ $trx->id }}"
                                        @change="updateSelectAllState()"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                </td>
                                <td class="p-4 text-center">{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                                <td class="p-4 text-center">
                                    {{ $trx->category->name ?? ($trx->category->category_name ?? 'Tidak ada kategori') }}
                                </td>
                                <td class="p-4 text-center">
                                    <span
                                        class="{{ $trx->type == 'income' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-[#F20E0F]' }} px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $trx->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="font-semibold text-gray-800">
                                        {{ number_format($trx->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    @if ($trx->no_factur)
                                        <span class="text-sm text-gray-800">{{ $trx->no_factur }}</span>
                                    @else
                                        <span class="text-sm text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if ($trx->date_factur)
                                        <span
                                            class="text-sm text-gray-800">{{ \Carbon\Carbon::parse($trx->date_factur)->format('d/m/Y') }}</span>
                                    @else
                                        <span class="text-sm text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if ($trx->attachment)
                                        <a href="{{ asset('storage/' . $trx->attachment) }}" target="_blank"
                                            class="inline-flex items-center px-3 py-1 bg-[#0B3B9F] text-white text-xs rounded-md hover:bg-blue-700 transition">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            Download
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if ($trx->description)
                                        <span class="text-sm text-gray-600">{{ $trx->description }}</span>
                                    @else
                                        <span class="text-sm text-gray-400 italic">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-8 text-center text-gray-500 text-sm">
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

        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-show="showAddModal"
            x-transition.opacity style="display: none;">
            <div class="bg-white p-4 rounded-xl w-full max-w-sm shadow-lg max-h-[90vh] overflow-y-auto"
                @click.outside="closeAddModal()">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-base font-semibold">Tambah Transaksi</h2>
                    <button type="button" class="text-gray-500 hover:text-gray-800" @click="closeAddModal()">
                        ✕
                    </button>
                </div>

                <div x-show="addFormErrors.length > 0" class="mb-3 p-2 bg-red-100 border border-red-300 rounded-md">
                    <ul class="text-xs text-red-600 list-disc list-inside">
                        <template x-for="error in addFormErrors">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <form @submit.prevent="submitAddForm()" class="space-y-3" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium mb-1">Tipe <span class="text-red-500">*</span></label>
                            <select x-model="addForm.type" @change="loadAddCategories()"
                                class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                                <option value="">Pilih Tipe</option>
                                <option value="income">Pemasukan</option>
                                <option value="expenditure">Pengeluaran</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1">Kategori <span
                                    class="text-red-500">*</span></label>
                            <select x-model="addForm.category_id"
                                class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                                <option value="">Pilih Tipe Dulu</option>
                                <template x-for="category in addCategories">
                                    <option :value="category.id" x-text="category.category_name"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">
                            Jumlah: <span class="font-bold text-[#0B3B9F] text-xs"
                                x-text="'IDR ' + addForm.amount.toLocaleString('id-ID')"></span>
                        </label>
                        <div class="space-y-2">
                            <input type="range" x-model="addForm.amount" min="10000" max="10000000" step="10000"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">

                            <input type="text" x-model="addFormAmountDisplay" @input="formatAddAmount()"
                                placeholder="Contoh: 1.000.000"
                                class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">Tanggal</label>
                        <input type="date" x-model="addForm.date"
                            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">No. Faktur</label>
                        <input type="text" x-model="addForm.no_factur" placeholder="Masukkan nomor faktur"
                            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">Tanggal Faktur</label>
                        <input type="date" x-model="addForm.date_factur"
                            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">Lampiran (Attachment)</label>
                        <input type="file" @change="addForm.attachment = $event.target.files[0]"
                            class="w-full text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                        <p class="text-[10px] text-gray-500 mt-1">Format: JPG, PNG, PDF (max 2MB)</p>
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">Keterangan</label>
                        <textarea x-model="addForm.description" rows="2" placeholder="Keterangan (opsional)"
                            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F] resize-none"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="closeAddModal()"
                            class="px-3 py-1.5 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition text-xs">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-3 py-1.5 bg-blue-500 text-white rounded-md hover:bg-blue-900 transition text-xs">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-show="showEditModal"
            x-transition.opacity style="display: none;">
            <div class="bg-white p-4 rounded-xl w-full max-w-sm shadow-lg max-h-[90vh] overflow-y-auto"
                @click.outside="closeEditModal()">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-base font-semibold">Edit Transaksi</h2>
                    <button type="button" class="text-gray-500 hover:text-gray-800" @click="closeEditModal()">
                        ✕
                    </button>
                </div>

                <div x-show="editFormErrors.length > 0" class="mb-3 p-2 bg-red-100 border border-red-300 rounded-md">
                    <ul class="text-xs text-red-600 list-disc list-inside">
                        <template x-for="error in editFormErrors">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <form @submit.prevent="submitEditForm()" class="space-y-3" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium mb-1">Tipe <span class="text-red-500">*</span></label>
                            <select x-model="editForm.type" @change="loadEditCategories()"
                                class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                                <option value="">Pilih Tipe</option>
                                <option value="income">Pemasukan</option>
                                <option value="expenditure">Pengeluaran</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1">Kategori <span
                                    class="text-red-500">*</span></label>
                            <select x-model="editForm.category_id"
                                class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                                <option value="">Loading...</option>
                                <template x-for="category in editCategories">
                                    <option :value="category.id" x-text="category.category_name"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">
                            Jumlah: <span class="font-bold text-[#0B3B9F] text-xs"
                                x-text="'IDR ' + editForm.amount.toLocaleString('id-ID')"></span>
                        </label>
                        <div class="space-y-2">
                            <input type="range" x-model="editForm.amount" min="10000" max="10000000"
                                step="10000"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">

                            <input type="text" x-model="editFormAmountDisplay" @input="formatEditAmount()"
                                placeholder="Contoh: 1.000.000"
                                class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">Tanggal</label>
                        <input type="date" x-model="editForm.date"
                            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">No. Faktur</label>
                        <input type="text" x-model="editForm.no_factur" placeholder="Masukkan nomor faktur"
                            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">Tanggal Faktur</label>
                        <input type="date" x-model="editForm.date_factur"
                            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">Lampiran (Attachment)</label>
                        <input type="file" @change="editForm.attachment = $event.target.files[0]"
                            class="w-full text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
                        <p class="text-[10px] text-gray-500 mt-1">Format: JPG, PNG, PDF (max 2MB)</p>
                        <div x-show="editForm.current_attachment" class="mt-1">
                            <p class="text-xs text-gray-600 mt-1">
                                File saat ini:
                                <a :href="'/storage/' + editForm.current_attachment" target="_blank"
                                    class="text-blue-600 hover:underline"
                                    x-text="editForm.current_attachment ? editForm.current_attachment.split('/').pop() : ''">
                                </a>
                            </p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1">Keterangan</label>
                        <textarea x-model="editForm.description" rows="2" placeholder="Keterangan (opsional)"
                            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F] resize-none"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="closeEditModal()"
                            class="px-3 py-1.5 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition text-xs">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-3 py-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 transition text-xs">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function transactionManager() {
            return {
                showAddModal: false,
                showEditModal: false,
                selectedTransactions: [],
                selectAllChecked: false,
                selectAllIndeterminate: false,

                addForm: {
                    type: '',
                    category_id: '',
                    amount: 50000,
                    date: new Date().toISOString().split('T')[0],
                    description: '',
                    date_factur: '',
                    no_factur: '',
                    attachment: null
                },

                editForm: {
                    id: '',
                    type: '',
                    category_id: '',
                    amount: 50000,
                    date: '',
                    description: '',
                    date_factur: '',
                    no_factur: '',
                    attachment: null,
                    current_attachment: ''
                },

                addCategories: [],
                editCategories: [],

                addFormAmountDisplay: '',
                editFormAmountDisplay: '',

                addFormErrors: [],
                editFormErrors: [],

                init() {
                    this.updateAmountDisplays();

                    this.$watch('addForm.amount', () => {
                        this.addFormAmountDisplay = parseInt(this.addForm.amount).toLocaleString('id-ID');
                    });

                    this.$watch('editForm.amount', () => {
                        this.editFormAmountDisplay = parseInt(this.editForm.amount).toLocaleString('id-ID');
                    });
                },

                openAddModal() {
                    this.resetAddForm();
                    this.showAddModal = true;
                },

                closeAddModal() {
                    this.showAddModal = false;
                    this.addFormErrors = [];
                },

                closeEditModal() {
                    this.showEditModal = false;
                    this.editFormErrors = [];
                    this.selectedTransactions = [];
                    this.updateSelectAllState();
                },

                toggleSelectAll() {
                    const checkboxes = document.querySelectorAll('input[x-model="selectedTransactions"]');
                    if (this.selectAllChecked) {
                        this.selectedTransactions = [];
                    } else {
                        this.selectedTransactions = Array.from(checkboxes).map(cb => cb.value);
                    }
                    this.updateSelectAllState();
                },

                updateSelectAllState() {
                    const totalCheckboxes = document.querySelectorAll('input[x-model="selectedTransactions"]').length;
                    const selectedCount = this.selectedTransactions.length;

                    if (selectedCount === 0) {
                        this.selectAllChecked = false;
                        this.selectAllIndeterminate = false;
                    } else if (selectedCount === totalCheckboxes) {
                        this.selectAllChecked = true;
                        this.selectAllIndeterminate = false;
                    } else {
                        this.selectAllChecked = false;
                        this.selectAllIndeterminate = true;
                    }
                },

                async loadAddCategories() {
                    if (!this.addForm.type) {
                        this.addCategories = [];
                        this.addForm.category_id = '';
                        return;
                    }

                    console.log('[v0] Loading categories for type:', this.addForm.type);

                    try {
                        const response = await fetch(`/api/category/${this.addForm.type}`);
                        this.addCategories = await response.json();

                        this.addForm.category_id = '';

                        console.log('[v0] Categories loaded:', this.addCategories);
                    } catch (error) {
                        console.error('[v0] Error loading categories:', error);
                        this.addCategories = [];
                    }
                },

                async loadEditCategories() {
                    if (!this.editForm.type) {
                        this.editCategories = [];
                        return;
                    }

                    try {
                        const response = await fetch(`/api/category/${this.editForm.type}`);
                        this.editCategories = await response.json();
                    } catch (error) {
                        console.error('[v0] Error loading categories:', error);
                        this.editCategories = [];
                    }
                },

                formatAddAmount() {
                    let value = this.addFormAmountDisplay.replace(/\D/g, '');
                    if (value) {
                        this.addForm.amount = parseInt(value);
                        this.addFormAmountDisplay = parseInt(value).toLocaleString('id-ID');
                    }
                },

                formatEditAmount() {
                    let value = this.editFormAmountDisplay.replace(/\D/g, '');
                    if (value) {
                        this.editForm.amount = parseInt(value);
                        this.editFormAmountDisplay = parseInt(value).toLocaleString('id-ID');
                    }
                },

                updateAmountDisplays() {
                    this.addFormAmountDisplay = parseInt(this.addForm.amount).toLocaleString('id-ID');
                    this.editFormAmountDisplay = parseInt(this.editForm.amount).toLocaleString('id-ID');
                },

                resetAddForm() {
                    this.addForm = {
                        type: '',
                        category_id: '',
                        amount: 50000,
                        date: new Date().toISOString().split('T')[0],
                        description: '',
                        date_factur: '',
                        no_factur: '',
                        attachment: null
                    };
                    this.addCategories = [];
                    this.addFormErrors = [];
                    this.updateAmountDisplays();
                },

                validateAddForm() {
                    const errors = [];

                    if (!this.addForm.type) errors.push('Tipe transaksi harus dipilih');
                    if (!this.addForm.category_id) errors.push('Kategori harus dipilih');
                    if (!this.addForm.amount || this.addForm.amount <= 0) errors.push(
                        'Jumlah harus diisi dan lebih dari 0');

                    this.addFormErrors = errors;
                    return errors.length === 0;
                },

                validateEditForm() {
                    const errors = [];

                    if (!this.editForm.type) errors.push('Tipe transaksi harus dipilih');
                    if (!this.editForm.category_id) errors.push('Kategori harus dipilih');
                    if (!this.editForm.amount || this.editForm.amount <= 0) errors.push(
                        'Jumlah harus diisi dan lebih dari 0');

                    this.editFormErrors = errors;
                    return errors.length === 0;
                },

                async submitAddForm() {
                    if (!this.validateAddForm()) return;

                    console.log('[v0] Form data before submission:', {
                        type: this.addForm.type,
                        category_id: this.addForm.category_id,
                        amount: this.addForm.amount
                    });

                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    formData.append('type', this.addForm.type);
                    formData.append('category_id', this.addForm.category_id);
                    formData.append('amount', this.addForm.amount);
                    formData.append('date', this.addForm.date);
                    formData.append('description', this.addForm.description);
                    formData.append('date_factur', this.addForm.date_factur);
                    formData.append('no_factur', this.addForm.no_factur);

                    if (this.addForm.attachment) {
                        formData.append('attachment', this.addForm.attachment);
                    }

                    console.log('[v0] FormData contents:');
                    for (let [key, value] of formData.entries()) {
                        console.log(`[v0] ${key}: ${value}`);
                    }

                    try {
                        const response = await fetch('{{ route('transactions.store') }}', {
                            method: 'POST',
                            body: formData
                        });

                        if (response.ok) {
                            console.log('[v0] Transaction saved successfully');
                            window.location.reload();
                        } else {
                            const responseText = await response.text();
                            console.error('[v0] Server response:', responseText);
                            throw new Error('Server error: ' + response.status);
                        }
                    } catch (error) {
                        console.error('[v0] Error submitting form:', error);
                        this.addFormErrors = ['Terjadi kesalahan saat menyimpan data: ' + error.message];
                    }
                },

                async submitEditForm() {
                    if (!this.validateEditForm()) return;

                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    formData.append('_method', 'PUT');
                    formData.append('type', this.editForm.type);
                    formData.append('category_id', this.editForm.category_id);
                    formData.append('amount', this.editForm.amount);
                    formData.append('date', this.editForm.date);
                    formData.append('description', this.editForm.description);
                    formData.append('date_factur', this.editForm.date_factur);
                    formData.append('no_factur', this.editForm.no_factur);

                    if (this.editForm.attachment) {
                        formData.append('attachment', this.editForm.attachment);
                    }

                    try {
                        const response = await fetch(`/transactions/${this.editForm.id}`, {
                            method: 'POST',
                            body: formData
                        });

                        if (response.ok) {
                            window.location.reload();
                        } else {
                            throw new Error('Server error');
                        }
                    } catch (error) {
                        console.error('[v0] Error submitting form:', error);
                        this.editFormErrors = ['Terjadi kesalahan saat mengupdate data'];
                    }
                },

                async editSelected() {
                    if (this.selectedTransactions.length !== 1) {
                        alert('Pilih tepat satu transaksi untuk diedit!');
                        return;
                    }

                    try {
                        const response = await fetch(`/transactions/${this.selectedTransactions[0]}`);
                        const transaction = await response.json();

                        this.editForm = {
                            id: transaction.id,
                            type: transaction.type,
                            category_id: transaction.category_id,
                            amount: transaction.amount,
                            date: transaction.date,
                            description: transaction.description || '',
                            date_factur: transaction.date_factur || '',
                            no_factur: transaction.no_factur || '',
                            attachment: null,
                            current_attachment: transaction.attachment || ''
                        };

                        await this.loadEditCategories();
                        this.updateAmountDisplays();
                        this.showEditModal = true;

                    } catch (error) {
                        console.error('[v0] Error loading transaction:', error);
                        alert('Gagal memuat data transaksi');
                    }
                },

                async deleteSelected() {
                    if (this.selectedTransactions.length === 0) {
                        alert('Pilih minimal satu transaksi untuk dihapus!');
                        return;
                    }

                    const confirmMessage = this.selectedTransactions.length === 1 ?
                        'Apakah Anda yakin ingin menghapus transaksi ini?' :
                        `Apakah Anda yakin ingin menghapus ${this.selectedTransactions.length} transaksi yang dipilih?`;

                   Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: confirmMessage,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            try {
                                const formData = new FormData();
                                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                                this.selectedTransactions.forEach(id => {
                                    formData.append('transaction_ids[]', id);
                                });
                                console.log('[v0] Sending delete request for IDs:', this.selectedTransactions);
                                const response = await fetch('/transactions/bulk-delete', {
                                    method: 'POST',
                                    body: formData
                                });
                                
                                console.log('[v0] Delete response status:', response.status);
                                if (response.ok) {
                                    Swal.fire('Terhapus!', 'Transaksi berhasil dihapus.', 'success')
                                    .then(() => window.location.reload());
                                } else {
                                    const errorText = await response.text();
                                    console.error('[v0] Delete failed with response:', errorText);
                                    Swal.fire('Gagal!', 'Terjadi kesalahan pada server.', 'error');
                                }
                            } catch (error) {
                                console.error('[v0] Error deleting transactions:', error);
                                Swal.fire('Error!', 'Gagal menghapus transaksi.', 'error');
                            }
                        }
                    });
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection