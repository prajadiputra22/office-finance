<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CategoryTransactionsExport;

class CategoryTransactionController extends Controller
{
    public function income(Request $request)
    {
        $categoryId = $request->query('category_id');
        $year = $request->query('year', now()->year);
        
        $category = Category::findOrFail($categoryId);
        
        $transactions = Transaction::where('category_id', $categoryId)
            ->where('type', 'income')
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->get();
        
        $recentTransactions = Transaction::where('category_id', $categoryId)
            ->where('type', 'income')
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();
        
        $monthlyData = Transaction::where('category_id', $categoryId)
            ->where('type', 'income')
            ->whereYear('date', $year)
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
 
        $labels = [];
        $values = [];
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = $monthNames[$i - 1];
            $monthData = $monthlyData->firstWhere('month', $i);
            $values[] = $monthData ? (float) $monthData->total : 0;
        }

        $chart = (new LarapexChart)->lineChart()
            ->setTitle('')
            ->setLabels($labels)
            ->setDataset([
                [
                    'name' => 'Pemasukan',
                    'data' => $values
                ]
            ])
            ->setHeight(250)
            ->setColors(['#0B3B9F']);
        
        $availableYears = Transaction::where('category_id', $categoryId)
            ->where('type', 'income')
            ->selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
        
        return view('transactions.income', compact('category', 'chart', 'recentTransactions', 'year', 'availableYears'));
    }
    
    public function expenditure(Request $request)
    {
        $categoryId = $request->query('category_id');
        $year = $request->query('year', now()->year);
        
        $category = Category::findOrFail($categoryId);
        
        $transactions = Transaction::where('category_id', $categoryId)
            ->where('type', 'expenditure')
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->get();
        
        $recentTransactions = Transaction::where('category_id', $categoryId)
            ->where('type', 'expenditure')
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();
        
        $monthlyData = Transaction::where('category_id', $categoryId)
            ->where('type', 'expenditure')
            ->whereYear('date', $year)
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $labels = [];
        $values = [];
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = $monthNames[$i - 1];
            $monthData = $monthlyData->firstWhere('month', $i);
            $values[] = $monthData ? (float) $monthData->total : 0;
        }

        $chart = (new LarapexChart)->lineChart()
            ->setTitle('')
            ->setLabels($labels)
            ->setDataset([
                [
                    'name' => 'Pengeluaran',
                    'data' => $values
                ]
            ])
            ->setHeight(250)
            ->setColors(['#F20E0F']);
            
        
        $availableYears = Transaction::where('category_id', $categoryId)
            ->where('type', 'expenditure')
            ->selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
        
        return view('transactions.expenditure', compact('category', 'chart', 'recentTransactions', 'year', 'availableYears'));
    }

    public function exportIncome(Request $request)
    {
        $categoryId = $request->query('category_id');
        $year = $request->query('year', now()->year);

        $categoryName = null;
        if ($categoryId) {
            $category = Category::find($categoryId);
            $categoryName = $category ? $category->category_name : 'semua_kategori';
        } else {
            $categoryName = 'semua_kategori';
        }
        
        return Excel::download(
            new CategoryTransactionsExport($categoryId, 'income', $year),
            'laporan_'. $categoryName. '_'. $year . '.xlsx'
        );
    }

    public function exportExpenditure(Request $request)
    {
        $categoryId = $request->query('category_id');
        $year = $request->query('year', now()->year);

        $categoryName = null;
        if ($categoryId) {
            $category = Category::find($categoryId);
            $categoryName = $category ? $category->category_name : 'semua_kategori';
        } else {
            $categoryName = 'semua_kategori';
        }
        
        return Excel::download(
            new CategoryTransactionsExport($categoryId, 'expenditure', $year),
            'laporan_'. $categoryName. '_'. $year . '.xlsx'
        );
    }
}