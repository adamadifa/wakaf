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
            return view('admin.dashboard');
        }

        return view('dashboard');
    }
}
