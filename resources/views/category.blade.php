@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div x-data="{ openAddCategory: false, filterDropdown: false }">
    <h2 id="saldo-title" class="text-xl md:text-2xl font-bold text-gray-800 mb-5">
       Masukkan Kategori
    </h2>

    <section class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 sm:gap-4 mb-6 sm:mb-8">
        <button type="button" @click="openAddCategory = true"
            class="w-full sm:w-auto flex items-center justify-center sm:justify-start px-4 sm:px-6 py-3 sm:py-4 bg-white border-2 border-[#e1e5e9] rounded-xl font-semibold text-gray-700 text-sm sm:text-base hover:bg-[#0B3B9F] hover:border-[#0B3B9F] hover:text-white shadow transition">
            <span class="mr-2 font-bold text-xl">+</span>
            Tambah Kategori
        </button>

        <div class="flex gap-2 relative w-full sm:w-auto">
            <button @click="filterDropdown = !filterDropdown"
                class="flex-1 sm:flex-none flex items-center justify-center sm:justify-start px-3 py-2 bg-white border-2 border-[#e1e5e9] text-xs sm:text-sm rounded-lg hover:bg-[#0B3B9F] hover:text-white cursor-pointer transition">
                <span class="mr-1">Filter</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="filterDropdown" @click.outside="filterDropdown = false"
                x-transition
                class="absolute right-0 mt-1 w-32 bg-white rounded-md shadow-lg border border-gray-200 z-10"
                style="display: none;">
                <div class="py-1">
                    <a href="{{ route('category.index') }}"
                        class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ !request('type') ? 'bg-green-50 text-green-700 font-medium' : '' }}">
                        Semua
                    </a>
                    <a href="{{ route('category.index', ['type' => 'income']) }}"
                        class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('type') === 'income' ? 'bg-blue-50 text-blue-800 font-medium' : '' }}">
                        Pemasukan
                    </a>
                    <a href="{{ route('category.index', ['type' => 'expenditure']) }}"
                        class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('type') === 'expenditure' ? 'bg-red-50 text-red-700 font-medium' : '' }}">
                        Pengeluaran
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section>
        <h1 class="text-xl sm:text-2xl font-bold text-center mt-8 sm:mt-12 mb-6 sm:mb-8 animate-fade-in">
            Daftar Kategori
            @if (request('type') === 'income')
                - Pemasukan
            @elseif(request('type') === 'expenditure')
                - Pengeluaran
            @endif
        </h1>

        <div class="hidden md:block bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900 w-16">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900 w-1/4">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900 w-1/2">Kategori</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-900 w-1/4 relative">Action</th>
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

    @if (session('success'))
        <div class="fixed top-4 right-4 bg-[#0B3B9F] text-white px-6 py-3 rounded-lg shadow-lg z-50"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 max-w-sm"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        x-show="openAddCategory" x-transition.opacity style="display: none;">
        <div class="bg-white rounded-lg w-full max-w-md shadow-xl" @click.outside="openAddCategory = false">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Kategori</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600 text-xl"
                    @click="openAddCategory = false">✕</button>
            </div>
            <form action="{{ route('category.store') }}" method="POST" class="p-4">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <input type="text" name="category_name" value="{{ old('category_name') }}"
                        class="w-full px-3 py-2 bg-gray-100 border-0 rounded-md focus:bg-white focus:ring-2 focus:ring-[#0B3B9F] focus:outline-none transition-colors @error('category_name') ring-2 ring-red-500 @enderror"
                        placeholder="Masukkan nama kategori" required>
                    @error('category_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="type"
                        class="w-full px-3 py-2 bg-gray-100 border-0 rounded-md focus:bg-white focus:ring-2 focus:ring-[#0B3B9F] focus:outline-none transition-colors @error('type') ring-2 ring-red-500 @enderror"
                        required>
                        <option value="">Pilih status</option>
                        <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expenditure" {{ old('type') == 'expenditure' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="openAddCategory = false"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors font-medium text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-[#0B3B9F] text-white rounded-md hover:bg-[#0B3B9F] transition-colors font-medium text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
