<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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

        $transactions = $query->orderBy('date', 'desc')->paginate(10);

        return view('transaction.index', compact('transactions'));
    }

    // Detail transaksi
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transaction.show', compact('transaction'));
    }

    // Hapus transaksi (optional, biasanya jangan hapus manual kalau sinkron dengan income/expenditure)
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully!');
    }

    // Laporan ringkas cashflow bulanan
    public function report()
    {
        $report = Transaction::selectRaw('type, MONTH(date) as month, YEAR(date) as year, SUM(amount) as total')
            ->groupBy('type', 'year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('transaction.report', compact('report'));
    }
}
