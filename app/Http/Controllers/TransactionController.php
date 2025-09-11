<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Income;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->has('type') && in_array($request->type, ['income', 'expenditure'])) {
            $query->where('type', $request->type);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->with('category')->orderBy('date', 'desc')->get();
        $category = Category::all();

        $income = Transaction::where('type', 'income')->sum('amount');
        $expenditure = Transaction::where('type', 'expenditure')->sum('amount');

        return view('transaction', compact('transactions', 'category', 'income', 'expenditure'));
    }

    public function store(Request $request)
    {
        try {
            $validationRules = [
                'type' => 'required|in:income,expenditure',
                'category_id' => 'required|exists:category,id',
                'amount' => 'required|numeric|min:0',
                'date' => 'required|date',
                'description' => 'nullable|string|max:255',
                'date_factur' => 'nullable|date',
                'no_factur' => 'nullable|integer',
            ];

            // Only add file validation if attachment is actually present
            if ($request->hasFile('attachment')) {
                $validationRules['attachment'] = 'file|mimes:jpg,jpeg,png,pdf|max:2048';
            }

            $request->validate($validationRules);

            DB::beginTransaction();

            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            }

            Log::info('Creating transaction with data:', $request->all());

            $transaction = Transaction::create([
                'type' => $request->type,
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => $request->description,
                'date_factur' => $request->date_factur,
                'no_factur' => $request->no_factur,
                'attachment' => $attachmentPath,
            ]);

            Log::info('Transaction created successfully:', ['id' => $transaction->id]);

            if ($request->type === 'income' && class_exists('App\Models\Income')) {
                Income::create([
                    'category_id' => $request->category_id,
                    'customer' => 'System',
                    'amount' => $request->amount,
                    'date_entry' => $request->date,
                    'description' => $request->description ?? '',
                    'date_factur' => $request->date_factur,
                    'no_factur' => $request->no_factur,
                    'date' => $request->date,
                    'attachment' => $attachmentPath,
                ]);
            } elseif ($request->type === 'expenditure' && class_exists('App\Models\Expenditure')) {
                Expenditure::create([
                    'category_id' => $request->category_id,
                    'customer' => 'System',
                    'amount' => $request->amount,
                    'date_entry' => $request->date,
                    'description' => $request->description ?? '',
                    'date_factur' => $request->date_factur,
                    'no_factur' => $request->no_factur,
                    'date' => $request->date,
                    'attachment' => $attachmentPath,
                ]);
            }

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaction saved successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating transaction:', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Error saving transaction: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Transaction $transaction)
    {
        try {
            $validationRules = [
                'type' => 'required|in:income,expenditure',
                'category_id' => 'required|exists:category,id',
                'amount' => 'required|numeric|min:0',
                'date' => 'required|date',
                'description' => 'nullable|string|max:255',
                'date_factur' => 'nullable|date',
                'no_factur' => 'nullable|integer',
            ];

            // Only add file validation if attachment is actually present
            if ($request->hasFile('attachment')) {
                $validationRules['attachment'] = 'file|mimes:jpg,jpeg,png,pdf|max:2048';
            }

            $request->validate($validationRules);

            DB::beginTransaction();

            $attachmentPath = $transaction->attachment;

            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            }

            $transaction->update([
                'type' => $request->type,
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => $request->description,
                'date_factur' => $request->date_factur,
                'no_factur' => $request->no_factur,
                'attachment' => $attachmentPath,
            ]);

            // Update related income/expenditure records if they exist
            if ($request->type === 'income' && class_exists('App\Models\Income')) {
                $income = Income::where('no_factur', $transaction->no_factur)->first();
                if ($income) {
                    $income->update([
                        'category_id' => $request->category_id,
                        'customer' => 'System',
                        'amount' => $request->amount,
                        'date_entry' => $request->date,
                        'description' => $request->description ?? '',
                        'date_factur' => $request->date_factur,
                        'no_factur' => $request->no_factur,
                        'date' => $request->date,
                        'attachment' => $attachmentPath,
                    ]);
                }
            } elseif ($request->type === 'expenditure' && class_exists('App\Models\Expenditure')) {
                $expenditure = Expenditure::where('no_factur', $transaction->no_factur)->first();
                if ($expenditure) {
                    $expenditure->update([
                        'category_id' => $request->category_id,
                        'customer' => 'System',
                        'amount' => $request->amount,
                        'date_entry' => $request->date,
                        'description' => $request->description ?? '',
                        'date_factur' => $request->date_factur,
                        'no_factur' => $request->no_factur,
                        'date' => $request->date,
                        'attachment' => $attachmentPath,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating transaction:', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Error updating transaction: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();

            return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting transaction:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error deleting transaction: ' . $e->getMessage());
        }
    }

    public function downloadAttachment($id)
    {
        $transaction = Transaction::findOrFail($id);

        if (!$transaction->attachment) {
            abort(404, 'File tidak ditemukan');
        }

        $filePath = storage_path('app/public/' . $transaction->attachment);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($filePath);
    }
}
