<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expenditure;
use App\Models\Transaction;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class HomeController extends Controller
{
    public function index() {
        $totalIncome = Income::sum('amount');
        $totalExpenditure = Expenditure::sum('amount');
        $saldo = $totalIncome - $totalExpenditure;

        $saldoGiro = Transaction::where('type', 'giro')->sum('amount');

        $incomePerMonth = Income::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $expenditurePerMonth = Expenditure::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $chart = (new LarapexChart)->lineChart()
            ->setTitle('Grafik Keuangan Perusahaan')
            ->addData('Pemasukan', array_values($incomePerMonth))
            ->addData('Pengeluaran', array_values($expenditurePerMonth))
            ->setXAxis(['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']);

        $recentTransactions = Transaction::latest()->take(5)->get();

        return view('dashboard', compact(
            'saldo', 
            'saldoGiro', 
            'chart', 
            'recentTransactions',
            'totalIncome', 
            'totalExpenditure'
        ));
    }
}
