<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenditure;

class ExpenditureController extends Controller
{
    public function create()
    {
        return view('expenditure');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'   => 'required|exists:category,id',
            'customer'      => 'required|string|max:25',
            'amount'        => 'required|numeric',
            'gyro_cash'     => 'required|numeric',
            'date_entry'    => 'required|date',
            'description'   => 'required|string|max:255',
            'date_factur'   => 'required|date',
            'no_factur'     => 'required|integer',
            'date'          => 'required|date',
        ]);

        Expenditure::create([
            'category_id' => $request->category_id,
            'customer'    => $request->customer,
            'amount'      => $request->amount,
            'gyro_cash'   => $request->gyro_cash,
            'date_entry'  => $request->date_entry,
            'description' => $request->description,
            'date_factur' => $request->date_factur,
            'no_factur'   => $request->no_factur,
            'date'        => $request->date,
        ]);
        
        return redirect()->back()->with('success', 'Pengeluaran berhasil disimpan');
    }
}
