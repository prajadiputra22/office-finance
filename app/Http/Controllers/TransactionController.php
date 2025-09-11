<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Income;
use App\Models\Expenditure;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->has('type') && in_array($request->type, ['income', 'expenditure'])) {
            $query->where('type', $request->type);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->with('category')->orderBy('date', 'desc')->get();
        $category = Category::all();
        
        $income = Transaction::where('type', 'income')->sum('amount');
        $expenditure = Transaction::where('type', 'expenditure')->sum('amount');

        return view('transaction', compact('transactions', 'category', 'income', 'expenditure'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expenditure',
            'category_id' => 'required|exists:category,id',
            'date' => 'required|date',
        ]);

        Transaction::create($request->all());

        if ($request->type === 'income') {
            Income::create([
                'category_id' => $request->category_id,
                'customer' => 'System',
                'amount' => $request->amount,
                'date_entry' => $request->date,
                'description' => $request->description ?? '',
                'date_factur' => $request->date,
                'no_factur' => rand(1000, 9999),
                'date' => $request->date,
            ]);
        } elseif ($request->type === 'expenditure') {
            Expenditure::create([
                'category_id' => $request->category_id,
                'customer' => 'System',
                'amount' => $request->amount,
                'date_entry' => $request->date,
                'description' => $request->description ?? '',
                'date_factur' => $request->date,
                'no_factur' => rand(1000, 9999),
                'date' => $request->date,
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}
