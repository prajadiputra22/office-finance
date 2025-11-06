@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div x-data="{ openAddCategory: false, filterDropdown: false }">

    <section class="flex justify-between items-center gap-4 mb-8 flex-wrap">
        {{-- Tampilkan tombol tambah kategori hanya untuk admin --}}
        @auth
            @if(auth()->user()->role === 'admin')
        <button type="button" @click="openAddCategory = true"
            class="flex items-center px-6 py-4 bg-white border-2 border-[#e1e5e9] rounded-xl font-semibold text-gray-700 hover:bg-[#0B3B9F] hover:border-[#0B3B9F] hover:text-white shadow">
            <span class="mr-2 font-bold text-xl">+</span>
            Tambah Kategori
        </button>
            @endif
        @endauth

    </section>

    <section>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900 w-16">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900 w-1/4">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900 w-1/2">Kategori</th>
                        {{-- Tampilkan kolom action hanya untuk admin --}}
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
                            {{-- Tampilkan tombol delete hanya untuk admin --}}
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
    </section>


    {{-- Modal tambah kategori hanya untuk admin --}}
    @auth
        @if(auth()->user()->role === 'admin')
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        x-show="openAddCategory" x-transition.opacity style="display: none;">
        <div class="bg-white rounded-lg w-full max-w-md mx-4 shadow-xl" @click.outside="openAddCategory = false">
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
        @endif
    @endauth
@endsection
