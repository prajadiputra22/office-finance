<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expenditure;

class HomeController extends Controller
{
    public function index() {
        $totalIncome = Income::sum('amount');
        $totalExpenditure = Expenditure::sum('amount');
        $saldo = $totalIncome - $totalExpenditure;

    return view('home', compact('saldo', 'totalIncome', 'totalExpenditure'));
    }
}
