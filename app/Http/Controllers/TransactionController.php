<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Income;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('no_factur', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $transactions = $query->with('category')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        $category = Category::all();

        $income = Transaction::where('type', 'income')->sum('amount');
        $expenditure = Transaction::where('type', 'expenditure')->sum('amount');

        return view('transaction', compact('transactions', 'category', 'income', 'expenditure'));
    }

    public function show($id)
    {
        $transaction = Transaction::with('category')->findOrFail($id);
        return response()->json($transaction);
    }

    public function edit($id)
    {
        try {
            $transaction = Transaction::with('category')->findOrFail($id);
            $categories = Category::all();

            return view('transactions.edit', compact('transaction', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error loading transaction for edit:', ['error' => $e->getMessage()]);
            return redirect()->route('transactions.index')->with('error', 'Transaction not found.');
        }
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
                'no_factur' => 'nullable|string',
            ];

            if ($request->hasFile('attachment')) {
                $validationRules['attachment'] = 'file|mimes:jpg,jpeg,png,pdf|max:2048';
            }

            $request->validate($validationRules);

            DB::beginTransaction();

            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            }

            Log::info('Creating transaction with data:', [
                'type' => $request->type,
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'date' => $request->date,
                'all_request_data' => $request->all()
            ]);

            $transactionType = $request->input('type');
            if (!in_array($transactionType, ['income', 'expenditure'])) {
                throw new \Exception('Invalid transaction type: ' . $transactionType);
            }

            $transaction = Transaction::create([
                'type' => $transactionType,
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => $request->description,
                'date_factur' => $request->date_factur,
                'no_factur' => $request->no_factur,
                'attachment' => $attachmentPath,
                'date_entry' => now(),
            ]);

            Log::info('Transaction created successfully:', [
                'id' => $transaction->id,
                'type' => $transaction->type,
                'category_id' => $transaction->category_id
            ]);

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaction saved successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating transaction:', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Error saving transaction: ' . $e->getMessage());
        }
    }

    // Edit Transaksi
    public function update(Request $request, $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            $validationRules = [
                'type' => 'required|in:income,expenditure',
                'category_id' => 'required|exists:category,id',
                'amount' => 'required|numeric|min:0',
                'date' => 'required|date',
                'description' => 'nullable|string|max:255',
                'date_factur' => 'nullable|date',
                'no_factur' => 'nullable|string',
            ];

            if ($request->hasFile('attachment')) {
                $validationRules['attachment'] = 'file|mimes:jpg,jpeg,png,pdf|max:2048';
            }

            $request->validate($validationRules);

            DB::beginTransaction();

            if ($request->hasFile('attachment')) {
                if ($transaction->attachment) {
                    Storage::disk('public')->delete($transaction->attachment);
                }

                $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            }

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
                'date_entry' => now(),
            ]);

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating transaction:', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Error updating transaction: ' . $e->getMessage());
        }
    }

    // Hapus Transaksi
    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->type === 'income' && $transaction->no_factur) {
                Income::where('no_factur', $transaction->no_factur)->delete();
            } elseif ($transaction->type === 'expenditure' && $transaction->no_factur) {
                Expenditure::where('no_factur', $transaction->no_factur)->delete();
            }
            if ($transaction->attachment) {
                Storage::disk('public')->delete($transaction->attachment);
            }

            $transaction->delete();

            return redirect()->back()->with('success', 'Transaksi dan lampirannya berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting transaction:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error deleting transaction: ' . $e->getMessage());
        }
    }

    // Hapus Banyak Transaksi
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'transaction_ids' => 'required|array|min:1',
                'transaction_ids.*' => 'exists:transactions,id'
            ]);

            DB::beginTransaction();

            $transactionIds = $request->transaction_ids;
            $transactions = Transaction::whereIn('id', $transactionIds)->get();

            Log::info('Bulk delete request received', [
                'transaction_ids' => $transactionIds,
                'count' => count($transactionIds)
            ]);

            foreach ($transactions as $transaction) {
                if ($transaction->type === 'income' && $transaction->no_factur) {
                    Income::where('no_factur', $transaction->no_factur)->delete();
                } elseif ($transaction->type === 'expenditure' && $transaction->no_factur) {
                    Expenditure::where('no_factur', $transaction->no_factur)->delete();
                }
                if ($transaction->attachment) {
                    Storage::disk('public')->delete($transaction->attachment);
                }
            }

            $deletedCount = Transaction::whereIn('id', $transactionIds)->delete();

            DB::commit();

            Log::info('Bulk delete completed successfully', [
                'deleted_count' => $deletedCount
            ]);

            return redirect()->route('transactions.index')
                ->with('success', "Berhasil menghapus {$deletedCount} transaksi dan lampirannya!");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error bulk deleting transactions:', [
                'error' => $e->getMessage(),
                'transaction_ids' => $request->transaction_ids ?? []
            ]);
            return redirect()->back()->with('error', 'Error menghapus transaksi: ' . $e->getMessage());
        }
    }

    // Download Lampiran
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
