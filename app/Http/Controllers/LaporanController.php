<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedYear = $request->query('year');
        $selectedMonth = $request->query('month');

        // Get available years for dropdown
        $years = Laporan::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
            
        if (empty($years)) {
            $years = [date('Y')];
        }

        $query = Laporan::query();

        if ($selectedYear) {
            $query->where('year', $selectedYear);
        }

        if ($selectedMonth) {
            $query->where('month', $selectedMonth);
        }

        $laporans = $query->latest()->get();

        return view('laporan.index', compact('laporans', 'years', 'selectedYear', 'selectedMonth'));
    }
}
