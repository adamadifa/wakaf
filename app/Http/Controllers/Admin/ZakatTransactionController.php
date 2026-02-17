<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ZakatTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\ZakatTransaction::with(['zakatType', 'donor', 'paymentMethod'])->latest();

        // Filter: Search (Invoice, Name, Email)
        if ($request->q) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter: Zakat Type
        if ($request->zakat_type_id) {
            $query->where('zakat_type_id', $request->zakat_type_id);
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
        $zakatTypes = \App\Models\ZakatType::all();
            
        return view('admin.zakat.transactions.index', compact('transactions', 'zakatTypes'));
    }

    public function show($id)
    {
        $transaction = \App\Models\ZakatTransaction::with(['zakatType', 'donor', 'paymentMethod'])->findOrFail($id);
        return view('admin.zakat.transactions.show', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = \App\Models\ZakatTransaction::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,rejected',
        ]);

        $transaction->update([
            'status' => $request->status,
            'confirmed_at' => $request->status == 'confirmed' ? now() : null,
        ]);

        // Send Confirmation Email
        if ($request->status == 'confirmed' && $transaction->email) {
            try {
                dispatch(new \App\Jobs\SendEmailJob($transaction->email, new \App\Mail\ZakatConfirmedMail($transaction)));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Zakat Confirmation Email Error: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $transaction = \App\Models\ZakatTransaction::findOrFail($id);
        if ($transaction->payment_proof) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($transaction->payment_proof);
        }
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus');
    }
}
