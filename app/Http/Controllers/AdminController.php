<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($user->role === 'admin' || $user->email === 'admin@wakaf.com') {
            // Get monthly donation stats for current year
            $donations = \App\Models\Donation::select(
                \Illuminate\Support\Facades\DB::raw('SUM(amount) as total'),
                \Illuminate\Support\Facades\DB::raw('MONTH(created_at) as month')
            )
            ->where('status', 'confirmed')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

            $chartData = [
                'labels' => [],
                'data' => []
            ];

            // Fill all 12 months (0 if no data)
            for ($i = 1; $i <= 12; $i++) {
                $chartData['labels'][] = date('M', mktime(0, 0, 0, $i, 1));
                $chartData['data'][] = isset($donations[$i]) ? $donations[$i] : 0;
            }

            return view('admin.dashboard', compact('chartData'));
        }

        return view('dashboard');
    }
}
