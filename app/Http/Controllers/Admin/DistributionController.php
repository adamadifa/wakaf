<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distribution;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DistributionController extends Controller
{
    public function index()
    {
        $query = Distribution::with(['campaign', 'user'])->latest();

        // 1. Keyword Search (Title or Description)
        if (request()->has('q') && request()->q != '') {
            $search = request()->q;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 2. Filter by Campaign
        if (request()->has('campaign_id') && request()->campaign_id != '') {
            $query->where('campaign_id', request()->campaign_id);
        }

        // 3. Filter by Date Range
        if (request()->has('start_date') && request()->start_date != '') {
            $query->whereDate('distributed_at', '>=', request()->start_date);
        }
        if (request()->has('end_date') && request()->end_date != '') {
            $query->whereDate('distributed_at', '<=', request()->end_date);
        }

        $distributions = $query->paginate(10)->withQueryString();
        $campaigns = Campaign::latest()->get(); // For Filter Dropdown

        return view('admin.distributions.index', compact('distributions', 'campaigns'));
    }

    public function create()
    {
        $campaigns = Campaign::where('status', 'active')->latest()->get();
        return view('admin.distributions.create', compact('campaigns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1000',
            'distributed_at' => 'required|date',
            'description' => 'required|string',
            'documentation' => 'nullable|file|mimes:jpg,jpeg,png,pdf,zip|max:5120',
        ]);

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('documentation')) {
            $validated['documentation_url'] = $request->file('documentation')->store('distributions', 'public');
        }

        Distribution::create($validated);

        return redirect()->route('admin.distributions.index')
            ->with('success', 'Data penyaluran berhasil ditambahkan!');
    }

    public function edit(Distribution $distribution)
    {
        $campaigns = Campaign::latest()->get();
        return view('admin.distributions.edit', compact('distribution', 'campaigns'));
    }

    public function update(Request $request, Distribution $distribution)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1000',
            'distributed_at' => 'required|date',
            'description' => 'required|string',
            'documentation' => 'nullable|file|mimes:jpg,jpeg,png,pdf,zip|max:5120',
        ]);

        if ($request->hasFile('documentation')) {
            // Delete old file if exists
            if ($distribution->documentation_url && Storage::disk('public')->exists($distribution->documentation_url)) {
                Storage::disk('public')->delete($distribution->documentation_url);
            }
            $validated['documentation_url'] = $request->file('documentation')->store('distributions', 'public');
        }

        $distribution->update($validated);

        return redirect()->route('admin.distributions.index')
            ->with('success', 'Data penyaluran berhasil diperbarui!');
    }

    public function destroy(Distribution $distribution)
    {
        if ($distribution->documentation_url && Storage::disk('public')->exists($distribution->documentation_url)) {
            Storage::disk('public')->delete($distribution->documentation_url);
        }
        
        $distribution->delete();

        return redirect()->route('admin.distributions.index')
            ->with('success', 'Data penyaluran berhasil dihapus!');
    }
}
