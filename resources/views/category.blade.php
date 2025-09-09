@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <main class="flex-1 p-6" x-data="{ openAddCategory: false }">
        <!-- Updated header section to match the reference design exactly -->
        <section class="flex justify-start items-center gap-4 mb-8">
            <button type="button" @click="openAddCategory = true"
                class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <span class="mr-2 text-lg font-bold">⊕</span>
                Tambah Kategori pemasukan
            </button>
        </section>

        <!-- Updated table section with proper styling to match reference -->
        <section class="mt-8">
            <h2 class="text-2xl font-bold text-center mb-8">Daftar Kategori</h2>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <!-- Added No column to show sequential numbering -->
                            <th class="px-6 py-4 text-left font-semibold text-gray-900 w-16">No</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900 w-1/4">Status</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900 w-1/2">Kategori</th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-900 w-1/4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($categories as $index => $category)
                            <tr class="hover:bg-gray-50">
                                <!-- Display sequential number starting from 1 -->
                                <td class="px-6 py-4 text-gray-600 font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    @if ($category->type === 'income')
                                        <span class="text-green-600 font-semibold">Pemasukan</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Pengeluaran</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-900">{{ $category->category_name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <!-- Added delete form with proper route and method -->
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <!-- Updated colspan to include new No column -->
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada kategori yang ditambahkan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Added success message display -->
        @if(session('success'))
            <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                {{ session('success') }}
            </div>
        @endif

        <!-- Added validation error display -->
        @if($errors->any())
            <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Modal remains the same -->
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-show="openAddCategory"
            x-transition.opacity style="display: none;">
            <div class="bg-white rounded-lg w-full max-w-md mx-4 shadow-xl" @click.outside="openAddCategory = false">
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Tambah Kategori</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 text-xl"
                        @click="openAddCategory = false">
                        ✕
                    </button>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('category.store') }}" method="POST" class="p-4">
                    @csrf

                    <!-- Kategori Field -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <input type="text" name="category_name" value="{{ old('category_name') }}"
                            class="w-full px-3 py-2 bg-gray-100 border-0 rounded-md focus:bg-white focus:ring-2 focus:ring-[#84cc16] focus:outline-none transition-colors @error('category_name') ring-2 ring-red-500 @enderror"
                            placeholder="Masukkan nama kategori" required>
                        @error('category_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="type"
                            class="w-full px-3 py-2 bg-gray-100 border-0 rounded-md focus:bg-white focus:ring-2 focus:ring-[#84cc16] focus:outline-none transition-colors @error('type') ring-2 ring-red-500 @enderror" required>
                            <option value="">Pilih status</option>
                            <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expenditure" {{ old('type') == 'expenditure' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="openAddCategory = false"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors font-medium">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-[#84cc16] text-white rounded-md hover:bg-[#65a30d] transition-colors font-medium">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
