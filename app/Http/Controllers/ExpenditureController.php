<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenditure;
use App\Models\Transaction;

class ExpenditureController extends Controller
{
    public function create()
    {
        return view('expenditure');
    }

    public function store(Request $request)
    {
        $expenditure = Expenditure::create([
            'category_id' => $request->category_id,
            'customer' => $request->customer,
            'amount' => $request->amount,
            'date_entry' => $request->date_entry,
            'description' => $request->description,
            'date_factur' => $request->date_factur,
            'no_factur' => $request->no_factur,
            'date' => $request->date,
        ]);

        Transaction::create([
            'type' => 'income',
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('expenditure.index')->with('success', 'Expenditure saved successfully!');
    }
}
