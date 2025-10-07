<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class CategoryTransactionController extends Controller
{
    public function income(Request $request)
    {
        $categoryId = $request->query('category_id');
        
        $category = Category::findOrFail($categoryId);
        
        $transactions = Transaction::where('category_id', $categoryId)
            ->where('type', 'income')
            ->orderBy('date', 'desc')
            ->get();
        
        $recentTransactions = Transaction::where('category_id', $categoryId)
            ->where('type', 'income')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();
        
        $paymentData = Transaction::where('category_id', $categoryId)
            ->where('type', 'income')
            ->selectRaw('payment, SUM(amount) as total')
            ->groupBy('payment')
            ->get();
 
        $labels = [];
        $values = [];
        $colors = ['#0B3B9F', '#4169E1', '#6495ED', '#87CEEB', '#B0E0E6'];
        
        foreach ($paymentData as $index => $data) {
            $labels[] = ucfirst($data->payment ?? 'Tidak Diketahui');
            $values[] = (float) $data->total;
        }

        $chart = (new LarapexChart)->pieChart()
<<<<<<< HEAD
            ->setTitle('Transaksi per Metode Pembayaran')
=======
            ->setTitle('')
>>>>>>> origin/ui-ux
            ->setLabels($labels)
            ->setDataset($values)
            ->setColors($colors);
        
        return view('transactions.income', compact('category', 'chart', 'recentTransactions'));
    }
    
    public function expenditure(Request $request)
    {
        $categoryId = $request->query('category_id');
        
        $category = Category::findOrFail($categoryId);
        
        $transactions = Transaction::where('category_id', $categoryId)
            ->where('type', 'expenditure')
            ->orderBy('date', 'desc')
            ->get();
        
        $recentTransactions = Transaction::where('category_id', $categoryId)
            ->where('type', 'expenditure')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();
        
        $paymentData = Transaction::where('category_id', $categoryId)
            ->where('type', 'expenditure')
            ->selectRaw('payment, SUM(amount) as total')
            ->groupBy('payment')
            ->get();

        $labels = [];
        $values = [];
        $colors = ['#F20E0F', '#FF4500', '#FF6347', '#FF7F50', '#FFA07A'];
        
        foreach ($paymentData as $index => $data) {
            $labels[] = ucfirst($data->payment ?? 'Tidak Diketahui');
            $values[] = (float) $data->total;
        }

        $chart = (new LarapexChart)->pieChart()
<<<<<<< HEAD
            ->setTitle('Transaksi per Metode Pembayaran')
=======
            ->setTitle('')
>>>>>>> origin/ui-ux
            ->setLabels($labels)
            ->setDataset($values)
            ->setColors($colors);
        
        return view('transactions.expenditure', compact('category', 'chart', 'recentTransactions'));
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> origin/ui-ux
