<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenditure;

class ExpenditureController extends Controller
{
    public function create()
    {
        return view('expenditure');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'category_finance' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Expenditure::create([
            'description' => $request->description,
            'category_finance' => $request->category_finance,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil disimpan');
    }
}
