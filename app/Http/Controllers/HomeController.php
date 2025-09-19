<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\TransactionsChart;
use App\Models\Transaction;

class HomeController extends Controller
{
    public function index(TransactionsChart $transactionsChart)
    {
        $chart = $transactionsChart->build();
        
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpenditure = Transaction::where('type', 'expenditure')->sum('amount');
        $balance = $totalIncome - $totalExpenditure;
        
        $recentTransactions = Transaction::with('category')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('home', compact('chart', 'balance', 'totalIncome', 'totalExpenditure', 'recentTransactions'));
    }
}
