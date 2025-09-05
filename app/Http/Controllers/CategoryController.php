<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Tampilkan semua kategori
    public function index()
    {
        $categories = Category::all();
        return view('category', compact('categories'));
    }

    // Form tambah kategori
    public function create()
    {
        return view('categories.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'category'   => 'required|in:masuk,keluar',
            'subcategory'=> 'nullable|string|max:255',
            'type'       => 'required|in:income,expenditure',
        ]);
        
        $categoryName = $request->subcategory ?? ucfirst($request->category);
        
        Category::create([
            'category_name' => $categoryName,
            'type' => $request->type,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Form edit kategori
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Update kategori
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category'   => 'required|in:masuk,keluar',
            'subcategory'=> 'nullable|string|max:255',
            'type'       => 'required|in:income,expenditure',
        ]);

        $categoryName = $request->subcategory ?? ucfirst($request->category);
        
        $category->update([
            'category_name' => $categoryName,
            'type' => $request->type,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Hapus kategori
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    // Ambil kategori berdasarkan tipe
    public function getByType($type)
    {
        $categories = Category::where('type', $type)->get();
        return response()->json($categories);
    }
}
