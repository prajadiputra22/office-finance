@extends('layouts.app')

@section('title', 'Transaksi')

@section('header')
<div class="w-full max-w-screen-xl">
<header class="flex justify-between items-center mb-8 flex-wrap gap-4 animate-fadeIn">
<form method="GET" action="{{ route('transactions.index') }}" class="flex-1">
    <div class="relative flex-1 max-w-[600px] bg-white p-4 rounded-xl shadow">
        <input type="text" name="search" value="{{ request('search') }}"
        placeholder="Cari Transaksi..."
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
      <img src="{{ asset('assets/picture/logo.png') }}" 
        alt="Logo TigaJaya Finance"
        class="w-20 md:w-28 lg:w-28 h-auto object-contain"> 
    </div>
</header>
</div>
@endsection

@section('content')
<div x-data="transactionManager()">
    <div class="w-full max-w-screen-xl">
        <div class="flex gap-5 mb-8 flex-wrap animate-fadeIn">
        <button
        type="button"
        @click="showAddModal = true"
        class="flex items-center px-6 py-4 bg-white border-2 border-[#e1e5e9] rounded-xl font-semibold text-gray-700 hover:bg-[#0B3B9F] hover:border-[#0B3B9F] hover:text-white hover-translate shadow">
            <span class="mr-2 font-bold text-xl">+</span>
            Tambah Transaksi
        </button>
        
        <div class="flex gap-5 flex-1 flex-wrap">
            <div class="flex-1 p-6 bg-white border border-[#e1e5e9] rounded-xl shadow hover:shadow-lg transition animate-slideInLeft">
                <h3 class="text-blue-600 font-medium">Pemasukan</h3>
                <p class="text-[25px] font-bold text-[#1f2937]">
                    {{'Rp '. number_format($income ?? 0, 0,',', '.') }}</p>
            </div>
            <div class="flex-1 p-6 bg-white border border-[#e1e5e9] rounded-xl shadow hover:shadow-lg transition animate-slideInLeft">
                <h3 class="text-red-600 font-medium">Pengeluaran</h3>
                <p class="text-[25px] font-bold text-[#1f2937]">
                    {{'Rp '. number_format($expenditure ?? 0, 0,',', '.') }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow p-6 animate-fadeIn ">
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
             <div x-data="{
                selectedDate: '',
                get uniqueDates() {
                    const dates = @js($transactions->pluck('date')
                        ->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m/Y'))
                        ->unique()
                        ->values());
                    return dates;
                }
            }">
            <div x-data="{
                selectedMonth: '',
                get uniqueMonths() {
                    const months = @js($transactions->pluck('date')
                        ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m'))
                        ->unique()
                        ->values());
                    return months;
                }
            }">
              <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-x"
                  x-ref="tableContainer" @scroll="onTableScroll">
                  <table class="w-full text-center border border-[#e1e5e9] rounded-lg overflow-hidden text-sm min-w-[800px] whitespace-nowrap">
                    <thead class="bg-[#f8f9fa]">
                      <tr>
                        <th class="p-4 font-semibold text-[#333] text-center">
                          <input type="checkbox" @change="toggleSelectAll()" :checked="selectAllChecked"
                              :indeterminate="selectAllIndeterminate"
                              class="w-4 h-4 mt-2 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        </th>
                        <th class="p-4 font-semibold text-[#333] text-center relative">
                          <div class="inline-block">
                            <label for="filterMonth" class="text-sm font-large text-gray-600">Tanggal Transaksi</label>
                            <input 
                              type="month" 
                              id="filterMonth"
                              x-model="selectedMonth"
                              class="mt-1 border border-gray-300 rounded px-[5px] py-[5px] text-xs appearance-none cursor-pointer w-[27.5px] h-[30px]">
                          </div>
                        </th>
                        <th class="p-4 font-semibold text-[#333] text-left">Kategori</th>
                        <th class="p-4 font-semibold text-[#333] text-center">Status</th>
                        <th class="p-4 font-semibold text-[#333] text-center">Pembayaran</th>
                        <th class="p-4 font-semibold text-[#333] text-center">Jumlah</th>
                        <th class="p-4 font-semibold text-[#333] text-center">No. Faktur</th>
                        <th class="p-4 font-semibold text-[#333] text-center">Tgl. Faktur</th>
                        <th class="p-4 font-semibold text-[#333] text-center">Lampiran</th>
                        <th class="p-4 font-semibold text-[#333] text-left">Keterangan</th>
                      </tr>
                    </thead>
                    <tbody x-data="{ hasVisible: false }" 
                    x-init="$watch('selectedMonth', () => { hasVisible = false; })">
                    
                    @forelse ($transactions as $trx)
                        <tr class="border-b border-[#e1e5e9] hover:bg-[#f8f9fa]"
                            x-show="
                              selectedMonth === '' ||
                              selectedMonth === '{{ \Carbon\Carbon::parse($trx->date)->format('Y-m') }}'
                            "
                            x-init="$watch('selectedMonth', value => {
                                if (value === '' || value === '{{ \Carbon\Carbon::parse($trx->date)->format('Y-m') }}') {
                                    hasVisible = true;
                                }
                            })">
                            <td class="p-4 text-center">
                                <input type="checkbox" x-model="selectedTransactions" value="{{ $trx->id }}"
                                    @change="updateSelectAllState()"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            </td>
                            <td class="p-4 text-left">{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                            <td class="p-4 text-left">
                                {{ $trx->category->name ?? ($trx->category->category_name ?? 'Tidak ada kategori') }}
                            </td>
                            <td class="p-4 text-center">
                                <span
                                    class="{{ $trx->type == 'income' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-[#F20E0F]' }} px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $trx->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                {{ $trx->payment == 'cash' ? 'Cash' : ($trx->payment == 'transfer' ? 'Transfer' : 'Giro') }}
                            </td>
                            <td class="p-4 text-center">
                                <span class="font-semibold text-gray-800">
                                    {{'Rp '. number_format($trx->amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="p-4 text-center">{{ $trx->no_factur ?? '-' }}</td>
                            <td class="p-4 text-center">
                                {{ $trx->date_factur ? \Carbon\Carbon::parse($trx->date_factur)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="p-4 text-center">
                                @if ($trx->attachment)
                                    <a href="{{ asset('storage/' . $trx->attachment) }}" target="_blank"
                                        class="inline-flex items-center px-3 py-1 bg-[#0B3B9F] text-white text-xs rounded-md hover:bg-blue-700 transition">
                                        Download
                                    </a>
                                @else
                                    <span class="text-sm text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-left">{{ $trx->description ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="p-8 text-center text-gray-500 text-sm">
                                Tidak ada transaksi
                            </td>
                        </tr>
                    @endforelse
                    <tr x-show="!hasVisible && selectedMonth !== ''" x-cloak>
                      <td colspan="10" class="p-8 text-center text-gray-500 text-sm">
                          Belum ada transaksi pada bulan ini
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
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
          <label class="block text-xs font-medium mb-1">Pembayaran <span
              class="text-red-500">*</span></label>
          <select x-model="addForm.payment"
            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
            <option value="">Pilih Metode Pembayaran</option>
            <option value="cash">Cash</option>
            <option value="transfer">Transfer</option>
            <option value="giro">Giro</option>
          </select>
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
          <label class="block text-xs font-medium mb-1">Pembayaran <span
              class="text-red-500">*</span></label>
          <select x-model="editForm.payment"
            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0B3B9F] focus:border-[#0B3B9F]">
            <option value="">Pilih Metode Pembayaran</option>
            <option value="cash">Cash</option>
            <option value="transfer">Transfer</option>
            <option value="giro">Giro</option>
          </select>
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
  
   <script>
    function transactionManager() {
      return {
        showAddModal: false,
        showEditModal: false,
        scrollPercent: 0,
        selectedTransactions: [],
        selectAllChecked: false,
        selectAllIndeterminate: false,
        addForm: {
          type: '',
          category_id: '',
          payment: '',
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
          payment: '',
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
          this.$nextTick(() => {
            this.onTableScroll();
          });
        },
        openAddModal() { this.resetAddForm(); this.showAddModal = true; },
        closeAddModal() { this.showAddModal = false; this.addFormErrors = []; },
        closeEditModal() {
          this.showEditModal = false;
          this.editFormErrors = [];
          this.selectedTransactions = [];
          this.updateSelectAllState();
        },
        onTableScroll() {
          const el = this.$refs.tableContainer;
          if (!el) return;
          const max = el.scrollWidth - el.clientWidth;
          this.scrollPercent = max > 0 ? Math.round((el.scrollLeft / max) * 100) : 0;
        },
        onSliderInput() {
          const el = this.$refs.tableContainer;
          if (!el) return;
          const max = el.scrollWidth - el.clientWidth;
          const left = (this.scrollPercent / 100) * max;
          el.scrollTo({ left, behavior: 'smooth' });
        },
        scrollTable(direction) {
          const el = this.$refs.tableContainer;
          if (!el) return;
          const delta = direction === 'left' ? -el.clientWidth : el.clientWidth;
          el.scrollBy({ left: delta, behavior: 'smooth' });
          setTimeout(() => this.onTableScroll(), 250);
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
          if (selectedCount === 0) { this.selectAllChecked = false; this.selectAllIndeterminate = false; }
          else if (selectedCount === totalCheckboxes) { this.selectAllChecked = true; this.selectAllIndeterminate = false; }
          else { this.selectAllChecked = false; this.selectAllIndeterminate = true; }
        },
        async loadAddCategories() {
          if (!this.addForm.type) { this.addCategories = []; this.addForm.category_id = ''; return; }
          try {
            const response = await fetch(`/api/category/${this.addForm.type}`);
            this.addCategories = await response.json();
            this.addForm.category_id = '';
          } catch (error) { this.addCategories = []; }
        },
        async loadEditCategories() {
          if (!this.editForm.type) { this.editCategories = []; return; }
          try {
            const response = await fetch(`/api/category/${this.editForm.type}`);
            this.editCategories = await response.json();
          } catch (error) { this.editCategories = []; }
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
            type: '', category_id: '', payment: '', amount: 50000,
            date: new Date().toISOString().split('T')[0],
            description: '', date_factur: '', no_factur: '', attachment: null
          };
          this.addCategories = [];
          this.addFormErrors = [];
          this.updateAmountDisplays();
        },
        validateAddForm() {
          const errors = [];
          if (!this.addForm.type) errors.push('Tipe transaksi harus dipilih');
          if (!this.addForm.category_id) errors.push('Kategori harus dipilih');
          if (!this.addForm.payment) errors.push('Metode pembayaran harus dipilih');
          if (!this.addForm.amount || this.addForm.amount <= 0) errors.push('Jumlah harus diisi dan lebih dari 0');
          this.addFormErrors = errors;
          return errors.length === 0;
        },
        validateEditForm() {
          const errors = [];
          if (!this.editForm.type) errors.push('Tipe transaksi harus dipilih');
          if (!this.editForm.category_id) errors.push('Kategori harus dipilih');
          if (!this.editForm.amount || this.editForm.amount <= 0) errors.push('Jumlah harus diisi dan lebih dari 0');
          this.editFormErrors = errors;
          return errors.length === 0;
        },
        async submitAddForm() {
          if (!this.validateAddForm()) return;
          const formData = new FormData();
          formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
          formData.append('type', this.addForm.type);
          formData.append('category_id', this.addForm.category_id);
          formData.append('payment', this.addForm.payment);
          formData.append('amount', this.addForm.amount);
          formData.append('date', this.addForm.date);
          formData.append('description', this.addForm.description);
          formData.append('date_factur', this.addForm.date_factur);
          formData.append('no_factur', this.addForm.no_factur);
          if (this.addForm.attachment) formData.append('attachment', this.addForm.attachment);
          const response = await fetch('{{ route('transactions.store') }}', { method: 'POST', body: formData });
          if (response.ok) window.location.reload();
        },
        async submitEditForm() {
          if (!this.validateEditForm()) return;
          const formData = new FormData();
          formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
          formData.append('_method', 'PUT');
          formData.append('type', this.editForm.type);
          formData.append('category_id', this.editForm.category_id);
          formData.append('payment', this.editForm.payment);
          formData.append('amount', this.editForm.amount);
          formData.append('date', this.editForm.date);
          formData.append('description', this.editForm.description);
          formData.append('date_factur', this.editForm.date_factur);
          formData.append('no_factur', this.editForm.no_factur);
          if (this.editForm.attachment) formData.append('attachment', this.editForm.attachment);
          const response = await fetch(`/transactions/${this.editForm.id}`, { method: 'POST', body: formData });
          if (response.ok) window.location.reload();
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
              payment: transaction.payment,
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
                const response = await fetch('/transactions/bulk-delete', {
                  method: 'POST',
                  body: formData
                });
                if (response.ok) {
                  Swal.fire('Terhapus!', 'Transaksi berhasil dihapus.', 'success')
                    .then(() => window.location.reload());
                } else {
                  const errorText = await response.text();
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