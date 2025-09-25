<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Transaction;
use App\Models\Category;

class ReportsController extends Controller
{
    public function index()
    {
        $income = Transaction::where('type', 'income')->sum('amount');
        $expenditure = Transaction::where('type', 'expenditure')->sum('amount');

        $incomePerCategory = Transaction::join('category', 'transactions.category_id', '=', 'category.id')
            ->where('transactions.type', 'income')
            ->selectRaw('category.category_name, SUM(transactions.amount) as total')
            ->groupBy('category.id', 'category.category_name')
            ->get();

        $expenditurePerCategory = Transaction::join('category', 'transactions.category_id', '=', 'category.id')
            ->where('transactions.type', 'expenditure')
            ->selectRaw('category.category_name, SUM(transactions.amount) as total')
            ->groupBy('category.id', 'category.category_name')
            ->get();

        $incomeLabels = $incomePerCategory->pluck('category_name')->toArray();
        $incomeValues = $incomePerCategory->pluck('total')->map(function($value) {
            return (float) $value;
        })->toArray();

        $expenditureLabels = $expenditurePerCategory->pluck('category_name')->toArray();
        $expenditureValues = $expenditurePerCategory->pluck('total')->map(function($value) {
            return (float) $value;
        })->toArray();

        $incomeColors = ['#16A34A','#22C55E','#4ADE80','#86EFAC','#BBF7D0','#DCFCE7',
                        '#15803D','#166534','#14532D','#047857','#065F46','#064E3B'];
        
        $expenditureColors = ['#DC2626','#EF4444','#F87171','#FCA5A5','#FECACA','#FEE2E2',
                             '#B91C1C','#991B1B','#7F1D1D','#9F1239','#BE123C','#E11D48'];

        $incomeChart = (new LarapexChart)->pieChart()
            ->setTitle('Pemasukan per Kategori')
            ->setDataset($incomeValues)
            ->setLabels($incomeLabels)
            ->setHeight(300)
            ->setColors($incomeColors);

        $expenditureChart = (new LarapexChart)->pieChart()
            ->setTitle('Pengeluaran per Kategori')
            ->setDataset($expenditureValues)
            ->setLabels($expenditureLabels)
            ->setHeight(300)
            ->setColors($expenditureColors);

        $incomePercentages = [];
        if ($income > 0) {
            foreach ($incomePerCategory as $index => $item) {
                $incomePercentages[] = [
                    'category' => $item->category_name,
                    'amount' => $item->total,
                    'percentage' => round(($item->total / $income) * 100, 1),
                    'color' => $incomeColors[$index % count($incomeColors)]
                ];
            }
        }

        $expenditurePercentages = [];
        if ($expenditure > 0) {
            foreach ($expenditurePerCategory as $index => $item) {
                $expenditurePercentages[] = [
                    'category' => $item->category_name,
                    'amount' => $item->total,
                    'percentage' => round(($item->total / $expenditure) * 100, 1),
                    'color' => $expenditureColors[$index % count($expenditureColors)]
                ];
            }
        }

        return view('report', compact(
            'income', 'expenditure',
            'incomeChart', 'expenditureChart',
            'incomePercentages', 'expenditurePercentages'
        ));
    }
}