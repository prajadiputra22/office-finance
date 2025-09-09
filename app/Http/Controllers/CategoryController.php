<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category', compact('categories'));
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'type' => 'required|in:income,expenditure',
        ]);

        Category::create($request->only('category_name', 'type'));

        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Form edit kategori
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    // Hapus kategori
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }


    // Ambil kategori berdasarkan tipe
    public function getByType($type)
    {
        $categories = Category::where('type', $type)->get();
        return response()->json($categories);
    }
}
