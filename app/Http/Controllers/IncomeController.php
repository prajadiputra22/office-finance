<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;

class IncomeController extends Controller
{
    public function create()
    {
        return view('income');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_finance' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Income::create([
            'category_finance' => $request->category_finance,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Pemasukan berhasil disimpan');
    }
}
