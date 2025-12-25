@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div x-data="{ openAddCategory: false, filterDropdown: false }">
    {{-- Modal peringatan global untuk pesan error delete --}}
    @if(session('error_delete'))
    <div x-data="{ showErrorModal: true }" x-show="showErrorModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6 text-center transform transition-all">
            <div class="mb-4 text-red-500">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Peringatan</h3>
            <p class="text-gray-600 mb-6">{{ session('error_delete') }}</p>
            <button @click="showErrorModal = false" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                OK
            </button>
        </div>
    </div>
    @endif

    <h2 id="saldo-title" class="lg:hidden text-xl md:text-2xl font-bold text-gray-800 mb-5">
        Masukkan Kategori
    </h2>
    <section class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 sm:gap-4 mb-6 sm:mb-8">
        <div class="flex gap-4">
            @auth
                @if(auth()->user()->role === 'admin')
            <button type="button" @click="openAddCategory = true"
                class="w-full sm:w-auto flex items-center justify-center sm:justify-start px-4 sm:px-6 py-3 sm:py-4 bg-white border-2 border-[#e1e5e9] rounded-xl font-semibold text-gray-700 text-sm sm:text-base hover:bg-[#0B3B9F] hover:border-[#0B3B9F] hover:text-white shadow transition">
                <span class="mr-2 font-bold text-xl">+</span>
                Tambah Kategori
            </button>
                @endif
            @endauth
        </div>
        <div class="w-full sm:w-auto">
        <div class="flex gap-2 relative w-full">
        <div class="relative w-full sm:w-auto" x-data="{ filterDropdown: false }">
            <button @click="filterDropdown = !filterDropdown" 
                class="w-full sm:w-auto flex items-center justify-center sm:justify-start px-6 py-3 bg-white border-2 border-[#e1e5e9] text-xs sm:text-sm rounded-xl font-semibold text-gray-700 hover:bg-gray-50 shadow cursor-pointer transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
                Filter
                @if(request('type'))
                    <span class="ml-2 px-2 py-1 bg-[#0B3B9F] text-white text-xs rounded-full">1</span>
                @endif
            </button>

            {{-- Dropdown Menu --}}
            <div x-show="filterDropdown" 
                @click.outside="filterDropdown = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute sm:left-auto sm:right-0 mt-1 w-full sm:w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-10"
                style="display: none;">
                
                <div class="py-1">
                    <div class="px-3 py-2 text-sm font-semibold text-gray-700 border-b border-gray-200">
                        Status
                    </div>
                    
                    <a href="{{ route('category.index') }}" 
                        class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md mt-1 {{ !request('type') ? 'bg-gray-100 font-semibold' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        Semua Kategori
                    </a>
                    
                    <a href="{{ route('category.index', ['type' => 'income']) }}" 
                        class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request('type') === 'income' ? 'bg-blue-50 font-semibold text-blue-600' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                        Pemasukan
                    </a>
                    
                    <a href="{{ route('category.index', ['type' => 'expenditure']) }}" 
                        class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request('type') === 'expenditure' ? 'bg-red-50 font-semibold text-red-600' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                        Pengeluaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
    </section>

    {{-- Badge Filter Aktif --}}
    @if(request('type'))
    <section class="mb-4">
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-600">Status:</span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                {{ request('type') === 'income' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                {{ request('type') === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                <a href="{{ route('category.index') }}" class="ml-2 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </span>
        </div>
    </section>
    @endif

    <section>
        <div class="hidden md:block bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900 w-16">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900 w-1/4">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900 w-1/2">Kategori</th>

                        @auth
                            @if(auth()->user()->role === 'admin')
                        <th class="px-6 py-4 text-center font-semibold text-gray-900 w-1/4 relative">Action</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($categories as $index => $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-600 font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                @if ($category->type === 'income')
                                    <span class="text-blue-600 font-semibold">Pemasukan</span>
                                @else
                                    <span class="text-red-600 font-semibold">Pengeluaran</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-900">{{ $category->category_name }}</td>

                            @auth
                                @if(auth()->user()->role === 'admin')
                            <td class="px-6 py-4 text-center">
                               
                                <div x-data="{ open: false }" class="inline-block">
                                    <button @click="open = true" type="button" 
                                        class="text-gray-400 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>

                                    <div x-show="open" x-cloak
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                        role="dialog" aria-modal="true" aria-labelledby="modalTitle" aria-describedby="modalDesc">
                                        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                                            <h2 id="modalTitle" class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus</h2>
                                            <p id="modalDesc" class="text-gray-600 mb-6">
                                                Apakah Anda yakin ingin menghapus kategori 
                                                <span class="font-semibold">{{ $category->category_name }}</span>?
                                            </p>
                                            <div class="flex justify-end gap-3">
                                                <button @click="open = false" 
                                                    class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 text-gray-700 text-sm">
                                                    Batal
                                                </button>
                                                <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                                    @submit="open = false">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-600 rounded-md hover:bg-red-700 text-white text-sm">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                                @endif
                            @endauth
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                @if (request('type') === 'income')
                                    Belum ada kategori pemasukan yang ditambahkan
                                @elseif(request('type') === 'expenditure')
                                    Belum ada kategori pengeluaran yang ditambahkan
                                @else
                                    Belum ada kategori yang ditambahkan
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="md:hidden space-y-3">
            @forelse ($categories as $index => $category)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 mb-2">No. {{ $index + 1 }}</p>
                            <h3 class="text-base font-semibold text-gray-900">{{ $category->category_name }}</h3>
                        </div>
                        @auth
                            @if(auth()->user()->role === 'admin')
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = true" type="button" 
                                class="text-gray-400 hover:text-red-500 transition-colors p-1 mt-8">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>

                            <div x-show="open" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                role="dialog" aria-modal="true">
                                <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-sm p-6 mx-4">
                                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus</h2>
                                    <p class="text-gray-600 mb-6">
                                        Apakah Anda yakin ingin menghapus kategori 
                                        <span class="font-semibold">{{ $category->category_name }}</span>?
                                    </p>
                                    <div class="flex justify-end gap-3">
                                        <button @click="open = false" 
                                            class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 text-gray-700 text-sm font-medium">
                                            Batal
                                        </button>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                            @submit="open = false" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 rounded-md hover:bg-red-700 text-white text-sm font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endauth
                    </div>
                    <div class="pt-3">
                        <span class="inline-block text-xs font-medium px-3 py-1 rounded-full 
                            @if ($category->type === 'income')
                                bg-blue-50 text-blue-700
                            @else
                                bg-red-50 text-red-700
                            @endif">
                            @if ($category->type === 'income')
                                Pemasukan
                            @else
                                Pengeluaran
                            @endif
                        </span>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                    <p class="text-gray-500 text-sm">
                        @if (request('type') === 'income')
                            Belum ada kategori pemasukan yang ditambahkan
                        @elseif(request('type') === 'expenditure')
                            Belum ada kategori pengeluaran yang ditambahkan
                        @else
                            Belum ada kategori yang ditambahkan
                        @endif
                    </p>
                </div>
            @endforelse
        </div>
    </section>

    @auth
        @if(auth()->user()->role === 'admin')
    <!-- Updated form to use AJAX submission to keep modal open on error -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        x-show="openAddCategory" x-transition.opacity style="display: none;">
        <div class="bg-white rounded-lg w-full max-w-md shadow-xl" @click.outside="openAddCategory = false">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Kategori</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600 text-xl"
                    @click="openAddCategory = false">✕</button>
            </div>
            <form id="addCategoryForm" class="p-4">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <input type="text" name="category_name" id="category_name"
                        class="w-full px-3 py-2 bg-gray-100 border-0 rounded-md focus:bg-white focus:ring-2 focus:ring-[#0B3B9F] focus:outline-none transition-colors"
                        placeholder="Masukkan nama kategori">
                    <p id="category_name_error" class="text-red-500 text-sm mt-1 hidden"></p>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="type" id="type"
                        class="w-full px-3 py-2 bg-gray-100 border-0 rounded-md focus:bg-white focus:ring-2 focus:ring-[#0B3B9F] focus:outline-none transition-colors">
                        <option value="">Pilih status</option>
                        <option value="income">Pemasukan</option>
                        <option value="expenditure">Pengeluaran</option>
                    </select>
                    <p id="type_error" class="text-red-500 text-sm mt-1 hidden"></p>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="openAddCategory = false"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-[#0B3B9F] text-white rounded-md hover:bg-[#0B3B9F] transition-colors font-medium">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('addCategoryForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            document.getElementById('category_name_error').classList.add('hidden');
            document.getElementById('type_error').classList.add('hidden');
            document.getElementById('category_name').classList.remove('ring-2', 'ring-red-500');
            document.getElementById('type').classList.remove('ring-2', 'ring-red-500');

            const categoryName = document.getElementById('category_name').value.trim();
            const type = document.getElementById('type').value.trim();

            let hasError = false;

            if (!categoryName) {
                document.getElementById('category_name').classList.add('ring-2', 'ring-red-500');
                document.getElementById('category_name_error').textContent = 'Harap mengisi kategori.';
                document.getElementById('category_name_error').classList.remove('hidden');
                hasError = true;
            }

            if (!type) {
                document.getElementById('type').classList.add('ring-2', 'ring-red-500');
                document.getElementById('type_error').textContent = 'Harap mengisi status.';
                document.getElementById('type_error').classList.remove('hidden');
                hasError = true;
            }

            if (hasError) {
                return;
            }

            const formData = new FormData(this);
            
            try {
                const response = await fetch('{{ route("category.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    if (data.errors) {
                        if (data.errors.category_name) {
                            document.getElementById('category_name').classList.add('ring-2', 'ring-red-500');
                            document.getElementById('category_name_error').textContent = data.errors.category_name[0];
                            document.getElementById('category_name_error').classList.remove('hidden');
                        }
                        if (data.errors.type) {
                            document.getElementById('type').classList.add('ring-2', 'ring-red-500');
                            document.getElementById('type_error').textContent = data.errors.type[0];
                            document.getElementById('type_error').classList.remove('hidden');
                        }
                    }
                    return;
                }

                document.querySelector('[x-data*="openAddCategory"]').__x.$data.openAddCategory = false;
                location.reload();
            } catch (error) {
                console.error('Error:', error);
            }
        });

        document.getElementById('category_name').addEventListener('input', function() {
            this.classList.remove('ring-2', 'ring-red-500');
            document.getElementById('category_name_error').classList.add('hidden');
        });

        document.getElementById('type').addEventListener('change', function() {
            this.classList.remove('ring-2', 'ring-red-500');
            document.getElementById('type_error').classList.add('hidden');
        });
    </script>
        @endif
    @endauth
@endsection
