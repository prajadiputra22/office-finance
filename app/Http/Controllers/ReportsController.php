<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Transaction;

class ReportsController extends Controller
{
    public function index()
    {
        // Ambil total income dan expense (semua)
        $income = Transaction::where('type', 'income')->sum('amount');
        $expenditure = Transaction::where('type', 'expenditure')->sum('amount');

        // Ambil income per bulan
        $incomePerMonth = Transaction::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->where('type', 'income')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Ambil expense per bulan
        $expenditurePerMonth = Transaction::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->where('type', 'expenditure')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Buat array 12 bulan
        $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $incomeValues = [];
        $expenseValues = [];
        foreach (range(1, 12) as $m) {
            $incomeValues[] = (float) ($incomePerMonth[$m] ?? 0);
            $expenseValues[] = (float) ($expenditurePerMonth[$m] ?? 0);
        }
        
        $incomeValues = array_values($incomeValues);
        $expenseValues = array_values($expenseValues);

        // Pie Chart 1: Income
        $incomeChart = (new LarapexChart)->pieChart()
            ->setTitle('Total Income Per Bulan')
            ->addData($incomeValues)
            ->setLabels($months)
            ->setColors(['#16A34A','#22C55E','#4ADE80','#86EFAC','#BBF7D0','#DCFCE7',
                         '#15803D','#166534','#14532D','#047857','#065F46','#064E3B']);

        // Pie Chart 2: Expense
        $expenditureChart = (new LarapexChart)->pieChart()
            ->setTitle('Total Expense Per Bulan')
            ->addData($expenseValues)
            ->setLabels($months)
            ->setColors(['#DC2626','#EF4444','#F87171','#FCA5A5','#FECACA','#FEE2E2',
                         '#B91C1C','#991B1B','#7F1D1D','#9F1239','#BE123C','#E11D48']);

        return view('report', compact(
            'income', 'expenditure',
            'incomeChart', 'expenditureChart'
        ));
    }
}
