<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type');
        
        if ($type && in_array($type, ['income', 'expenditure'])) {
            $categories = Category::where('type', $type)->get();
        } else {
            $categories = Category::all();
        }
        
        return view('category', compact('categories', 'type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'type' => 'required|in:income,expenditure',
        ], [
            'type.in' => 'Tipe kategori tidak valid.',
        ]);

        $categoryName = $validated['category_name'];
        $type = $validated['type'];
        $baseSlug = Str::slug($categoryName);

        $existingCategory = Category::where('category_name', $categoryName)
            ->where('type', $type)
            ->first();

        if ($existingCategory) {
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => [
                        'category_name' => ['Kategori sudah tersedia.']
                    ]
                ], 422);
            }
            return redirect()->back()
                ->withInput()
                ->withErrors(['category_name' => 'Kategori sudah tersedia.']);
        }

        // Check if category with same name but different type exists
        $existingNameDifferentType = Category::where('category_name', $categoryName)
            ->where('type', '!=', $type)
            ->first();

        if ($existingNameDifferentType) {
            $existingTypeLabel = $existingNameDifferentType->type === 'income' ? 'income' : 'expenditure';
            $existingNameDifferentType->update([
                'slug' => $baseSlug . '-' . $existingTypeLabel
            ]);

            $typeLabel = $type === 'income' ? 'income' : 'expenditure';
            $slug = $baseSlug . '-' . $typeLabel;
        } else {
            $slug = $baseSlug;
        }

        $data = [
            'category_name' => $categoryName,
            'type' => $type,
            'slug' => $slug,
        ];

        Category::create($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil ditambahkan.']);
        }

        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $hasTransactions = \App\Models\Transaction::where('category_id', $id)->exists();

        if ($hasTransactions) {
            return redirect()->back()->with('error_delete', 'Kategori digunakan pada data transaksi');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }

    public function getByType($type)
    {
        $categories = Category::where('type', $type)->get();
        return response()->json($categories);
    }
}
