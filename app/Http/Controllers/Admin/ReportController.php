<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\ZakatTransaction;
use App\Models\InfaqTransaction;
use App\Models\InfaqCategory;
use App\Models\Distribution;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function zakat(Request $request)
    {
        $zakatTypes = \App\Models\ZakatType::all();
        return $this->generateReport($request, 'zakat', 'Laporan Zakat', ['zakatTypes' => $zakatTypes]);
    }

    public function donation(Request $request)
    {
        $campaigns = \App\Models\Campaign::where('status', 'active')->latest()->get();
        return $this->generateReport($request, 'donation', 'Laporan Wakaf / Donasi', ['campaigns' => $campaigns]);
    }

    public function infaq(Request $request)
    {
        $infaqCategories = InfaqCategory::all();
        return $this->generateReport($request, 'infaq', 'Laporan Infaq', ['infaqCategories' => $infaqCategories]);
    }

    private function generateReport(Request $request, $forceType = null, $pageTitle = 'Laporan Transaksi', $additionalData = [])
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        // If forceType is set, use it. Otherwise allow 'type' from request, defaulting to 'all'
        $type = $forceType ?? $request->input('type', 'all'); 

        $transactions = collect();

        // Query Zakat Transactions
        if ($type === 'all' || $type === 'zakat') {
            $query = ZakatTransaction::with('zakatType')
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);

            // Filter by Zakat Type
            if ($request->has('zakat_type_id') && $request->zakat_type_id != '') {
                $query->where('zakat_type_id', $request->zakat_type_id);
            }

            // Filter by Status
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            $zakat = $query->get()
            ->map(function ($item) {
                $item->type = 'Zakat';
                $item->details = $item->zakatType->name ?? 'Zakat';
                $item->formatted_amount = $item->total_transfer;
                return $item;
            });
            $transactions = $transactions->merge($zakat);
        }

        // Query Donations
        if ($type === 'all' || $type === 'donation') {
            $query = Donation::with(['campaign.category', 'donor'])
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);

            // Filter by Campaign
            if ($request->has('campaign_id') && $request->campaign_id != '') {
                $query->where('campaign_id', $request->campaign_id);
            }

            // Filter by Status
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            $donations = $query->get()
            ->map(function ($item) {
                $item->type = 'Donasi';
                $item->details = ($item->campaign->title ?? '-') . ' (' . ($item->campaign->category->name ?? '-') . ')';
                $item->formatted_amount = $item->total_transfer;
                
                // Map donor details
                if ($item->is_anonymous) {
                     $item->name = 'Hamba Allah';
                } else {
                     $item->name = $item->donor->name ?? 'Guest';
                }
                $item->email = $item->donor->email ?? '-';
                
                return $item;
            });
            $transactions = $transactions->merge($donations);
        }

        // Query Infaq Transactions
        if ($type === 'all' || $type === 'infaq') {
            $query = InfaqTransaction::with('infaqCategory')
                ->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);

            // Filter by Infaq Category
            if ($request->has('infaq_category_id') && $request->infaq_category_id != '') {
                $query->where('infaq_category_id', $request->infaq_category_id);
            }

            // Filter by Status
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            $infaq = $query->get()
                ->map(function ($item) {
                    $item->type = 'Infaq';
                    $item->details = $item->infaqCategory->name ?? 'Infaq';
                    $item->formatted_amount = $item->total_transfer;
                    return $item;
                });
            $transactions = $transactions->merge($infaq);
        }

        // Sort by date descending
        $transactions = $transactions->sortByDesc('created_at');

        // Calculate Summary
        $totalAmount = $transactions->where('status', 'confirmed')->sum('total_transfer');
        $totalTransactions = $transactions->count();
        $pendingTransactions = $transactions->where('status', 'pending')->count();
        $successTransactions = $transactions->where('status', 'confirmed')->count();

        // Merge additional data (zakatTypes, campaigns) into view data
        $viewData = array_merge([
            'transactions' => $transactions,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'type' => $type,
            'forceType' => $forceType,
            'pageTitle' => $pageTitle,
            'totalAmount' => $totalAmount,
            'totalTransactions' => $totalTransactions,
            'pendingTransactions' => $pendingTransactions,
            'successTransactions' => $successTransactions
        ], $additionalData);

        return view('admin.reports.index', $viewData);
    }

    public function printReport(Request $request)
    {
        $type = $request->input('type', 'all');
        $pageTitle = 'Laporan Transaksi';
        $additionalData = [];

        if ($type === 'zakat') {
            $pageTitle = 'Laporan Zakat';
            $additionalData['zakatTypes'] = \App\Models\ZakatType::all();
        } elseif ($type === 'donation') {
            $pageTitle = 'Laporan Wakaf / Donasi';
            $additionalData['campaigns'] = Campaign::where('status', 'active')->latest()->get();
        } elseif ($type === 'infaq') {
            $pageTitle = 'Laporan Infaq';
            $additionalData['infaqCategories'] = InfaqCategory::all();
        }

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $forceType = $type !== 'all' ? $type : null;

        $transactions = collect();

        // Query Zakat
        if ($type === 'all' || $type === 'zakat') {
            $query = ZakatTransaction::with('zakatType')
                ->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            if ($request->has('zakat_type_id') && $request->zakat_type_id != '') {
                $query->where('zakat_type_id', $request->zakat_type_id);
            }
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }
            $zakat = $query->get()->map(function ($item) {
                $item->type = 'Zakat';
                $item->details = $item->zakatType->name ?? 'Zakat';
                return $item;
            });
            $transactions = $transactions->merge($zakat);
        }

        // Query Donations
        if ($type === 'all' || $type === 'donation') {
            $query = Donation::with(['campaign.category', 'donor'])
                ->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            if ($request->has('campaign_id') && $request->campaign_id != '') {
                $query->where('campaign_id', $request->campaign_id);
            }
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }
            $donations = $query->get()->map(function ($item) {
                $item->type = 'Donasi';
                $item->details = ($item->campaign->title ?? '-') . ' (' . ($item->campaign->category->name ?? '-') . ')';
                if ($item->is_anonymous) {
                    $item->name = 'Hamba Allah';
                } else {
                    $item->name = $item->donor->name ?? 'Guest';
                }
                $item->email = $item->donor->email ?? '-';
                return $item;
            });
            $transactions = $transactions->merge($donations);
        }

        // Query Infaq
        if ($type === 'all' || $type === 'infaq') {
            $query = InfaqTransaction::with('infaqCategory')
                ->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            if ($request->has('infaq_category_id') && $request->infaq_category_id != '') {
                $query->where('infaq_category_id', $request->infaq_category_id);
            }
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }
            $infaq = $query->get()->map(function ($item) {
                $item->type = 'Infaq';
                $item->details = $item->infaqCategory->name ?? 'Infaq';
                return $item;
            });
            $transactions = $transactions->merge($infaq);
        }

        $transactions = $transactions->sortByDesc('created_at');

        $totalAmount = $transactions->where('status', 'confirmed')->sum('total_transfer');
        $totalTransactions = $transactions->count();
        $pendingTransactions = $transactions->where('status', 'pending')->count();

        $setting = \App\Models\Setting::first();

        return view('admin.reports.print', array_merge([
            'transactions' => $transactions,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'type' => $type,
            'forceType' => $forceType,
            'pageTitle' => $pageTitle,
            'totalAmount' => $totalAmount,
            'totalTransactions' => $totalTransactions,
            'pendingTransactions' => $pendingTransactions,
            'setting' => $setting,
        ], $additionalData));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $type = $request->input('type', 'all');

        $transactions = collect();

        // Query Zakat Transactions
        if ($type === 'all' || $type === 'zakat') {
            $query = ZakatTransaction::with(['zakatType', 'donor'])
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);

            if ($request->has('zakat_type_id') && $request->zakat_type_id != '') {
                $query->where('zakat_type_id', $request->zakat_type_id);
            }

            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            $zakat = $query->get()->map(function ($item) {
                return [
                    $item->created_at->format('Y-m-d H:i:s'),
                    $item->invoice_number,
                    'Zakat - ' . ($item->zakatType->name ?? 'Zakat'),
                    $item->name,
                    $item->email,
                    $item->phone,
                    $item->total_transfer,
                    $item->status,
                ];
            });
            $transactions = $transactions->merge($zakat);
        }

        // Query Donations
        if ($type === 'all' || $type === 'donation') {
            $query = Donation::with(['campaign.category', 'donor'])
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);

            if ($request->has('campaign_id') && $request->campaign_id != '') {
                $query->where('campaign_id', $request->campaign_id);
            }

            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            $donations = $query->get()->map(function ($item) {
                $donorName = $item->is_anonymous ? 'Hamba Allah' : ($item->donor->name ?? 'Guest');
                $donorEmail = $item->donor->email ?? '-';
                $donorPhone = $item->donor->phone ?? '-';

                return [
                    $item->created_at->format('Y-m-d H:i:s'),
                    $item->invoice_number,
                    'Wakaf - ' . ($item->campaign->title ?? '-') . ' (' . ($item->campaign->category->name ?? '-') . ')',
                    $donorName,
                    $donorEmail,
                    $donorPhone,
                    $item->total_transfer,
                    $item->status,
                ];
            });
            $transactions = $transactions->merge($donations);
        }

        // Query Infaq Transactions
        if ($type === 'all' || $type === 'infaq') {
            $query = InfaqTransaction::with('infaqCategory')
                ->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);

            if ($request->has('infaq_category_id') && $request->infaq_category_id != '') {
                $query->where('infaq_category_id', $request->infaq_category_id);
            }

            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            $infaq = $query->get()->map(function ($item) {
                return [
                    $item->created_at->format('Y-m-d H:i:s'),
                    $item->invoice_number,
                    'Infaq - ' . ($item->infaqCategory->name ?? 'Infaq'),
                    $item->is_anonymous ? 'Hamba Allah' : $item->name,
                    $item->email,
                    $item->phone ?? '-',
                    $item->total_transfer,
                    $item->status,
                ];
            });
            $transactions = $transactions->merge($infaq);
        }

        $transactions = $transactions->sortByDesc(function($item) {
            return $item[0]; // Sort by date (first column)
        });

        $filename = 'laporan_transaksi_' . date('Ymd_His') . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\TransactionExport($transactions), $filename);
    }

    public function distribution(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $query = Distribution::with(['campaign.category', 'user'])
            ->whereBetween('distributed_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);

        // Filter by Campaign
        if ($request->has('campaign_id') && $request->campaign_id != '') {
            $query->where('campaign_id', $request->campaign_id);
        }

        $distributions = $query->latest('distributed_at')->get();

        // Calculate Summary
        $totalAmount = $distributions->sum('amount');
        $totalDistributions = $distributions->count();
        $campaigns = Campaign::where('status', 'active')->latest()->get();

        return view('admin.reports.distribution', [
            'distributions' => $distributions,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalAmount' => $totalAmount,
            'totalDistributions' => $totalDistributions,
            'campaigns' => $campaigns,
            'pageTitle' => 'Laporan Penyaluran Dana'
        ]);
    }

    public function exportDistribution(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $query = Distribution::with(['campaign.category', 'user'])
            ->whereBetween('distributed_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);

        if ($request->has('campaign_id') && $request->campaign_id != '') {
            $query->where('campaign_id', $request->campaign_id);
        }

        $distributions = $query->latest('distributed_at')->get()->map(function ($item) {
            return [
                $item->distributed_at->format('Y-m-d'),
                $item->title,
                $item->campaign->title ?? '-',
                $item->campaign->category->name ?? '-',
                $item->amount,
                $item->user->name ?? '-',
                $item->description,
            ];
        });

        $filename = 'laporan_penyaluran_' . date('Ymd_His') . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DistributionExport($distributions), $filename);
    }
}
