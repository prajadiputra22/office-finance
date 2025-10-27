<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\TransactionsChart;
use App\Models\Transaction;

class HomeController extends Controller
{
    public function index(Request $request, TransactionsChart $transactionsChart)
    {
        
        $year = $request->get('year', date('Y'));
        
        $availableYears = Transaction::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([date('Y')]);
        }
        
        if (! $availableYears->contains($year)) {
            $availableYears->push($year);
            $availableYears = $availableYears->sortDesc()->values();
        }

        $chart = $transactionsChart->build((int) $year);
        
        $totalIncome = Transaction::where('type', 'income')
            ->whereYear('date', $year)
            ->sum('amount');

        $totalExpenditure = Transaction::where('type', 'expenditure')
            ->whereYear('date', $year)
            ->sum('amount');

        $balance = $totalIncome - $totalExpenditure;
        
        $recentTransactions = Transaction::with('category')
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('home', compact('chart', 'balance', 'totalIncome', 'totalExpenditure', 'recentTransactions', 'year', 'availableYears'));
    }
}