<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {  
        $transactions = Transaction::latest()->get();
        $income = Transaction::where('type', 'income')->sum('amount');
        $expenditure = Transaction::where('type', 'expenditure')->sum('amount');    

        return view('transaction', compact('transactions', 'income', 'expenditure'));
    }

    public function create()
    {
        return view('transaction');
    }

    public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'type' => 'required|in:income,expenditure',
        'amount' => 'required|numeric',
        'customer' => 'nullable|string|max:255',
        'gyro_cash' => 'nullable|string|max:255',
        'date_entry' => 'nullable|date',
        'description' => 'nullable|string',
        'date_factur' => 'nullable|date',
        'no_factur' => 'nullable|string|max:255',
    ]);

    Transaction::create($request->all());
    
    return redirect()->route('transaction')->with('success', 'Transaksi berhasil ditambahkan');
}

public function edit(Transaction $transaction)
{
    return view('transaction', compact('transaction'));
}

public function update(Request $request, Transaction $transaction)
{
    $request->validate([
        'date' => 'required|date',
        'type' => 'required|in:income,expenditure',
        'amount' => 'required|numeric',
        'customer' => 'nullable|string|max:255',
        'gyro_cash' => 'nullable|string|max:255',
        'date_entry' => 'nullable|date',
        'description' => 'nullable|string',
        'date_factur' => 'nullable|date',
        'no_factur' => 'nullable|string|max:255',
    ]);
    
    $transaction->update($request->all());
    
    return redirect()->route('transaction.index')->with('success', 'Transaksi berhasil diperbarui');
}

public function destroy(Transaction $transaction)
{
    $transaction->delete();
    
    return redirect()->route('transaction.index')->with('success', 'Transaksi berhasil dihapus');
}
}
