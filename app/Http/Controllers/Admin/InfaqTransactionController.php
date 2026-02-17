<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfaqTransaction;
use Illuminate\Http\Request;

class InfaqTransactionController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\InfaqTransaction::with(['infaqCategory', 'donor', 'paymentMethod'])->latest();

        // Filter: Search (Invoice, Name, Email)
        if ($request->q) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter: Infaq Category
        if ($request->infaq_category_id) {
            $query->where('infaq_category_id', $request->infaq_category_id);
        }

        // Filter: Status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter: Date Range
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->paginate(10)->withQueryString();
        $categories = \App\Models\InfaqCategory::all();
            
        return view('admin.infaq.transactions.index', compact('transactions', 'categories'));
    }

    public function show($id)
    {
        $transaction = \App\Models\InfaqTransaction::with(['infaqCategory', 'donor', 'paymentMethod'])->findOrFail($id);
        return view('admin.infaq.transactions.show', compact('transaction'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $transaction = \App\Models\InfaqTransaction::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,rejected',
        ]);

        $transaction->update([
            'status' => $request->status,
            'confirmed_at' => $request->status == 'confirmed' ? now() : null,
        ]);

        // Send Confirmation Email (Optional - logic similar to Zakat)
        // if ($request->status == 'confirmed' && $transaction->email) { ... }

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $transaction = \App\Models\InfaqTransaction::findOrFail($id);
        if ($transaction->payment_proof) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($transaction->payment_proof);
        }
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus');
    }
}
