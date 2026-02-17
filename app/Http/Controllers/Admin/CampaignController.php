<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $query = Campaign::with('category', 'user')->latest();

        // Keyword Search
        if (request('q')) {
            $search = request('q');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('full_description', 'like', "%{$search}%");
            });
        }

        // Filter by Category
        if (request('category_id')) {
            $query->where('category_id', request('category_id'));
        }

        // Filter by Status
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Filter by Date Range (Start Date)
        if (request('start_date')) {
            $query->whereDate('start_date', '>=', request('start_date'));
        }

        if (request('end_date')) {
            $query->whereDate('start_date', '<=', request('end_date'));
        }

        $campaigns = $query->paginate(10)->withQueryString();
        $categories = \App\Models\Category::all(); // For filter dropdown
            
        return view('admin.campaigns.index', compact('campaigns', 'categories'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.campaigns.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'target_amount' => 'required|numeric|min:10000',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('campaigns', 'public');
            $validated['image_url'] = $path;
        }

        $validated['slug'] = \Illuminate\Support\Str::slug($request->title) . '-' . time();
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'active';
        $validated['current_amount'] = 0;
        $validated['short_description'] = \Illuminate\Support\Str::limit($request->description, 150);
        $validated['full_description'] = $request->description;
        unset($validated['description']);

        if (empty($validated['start_date'])) {
            $validated['start_date'] = now();
        }

        $validated['is_featured'] = $request->has('is_featured');

        Campaign::create($validated);

        return redirect()->route('admin.campaigns.index')->with('success', 'Program wakaf berhasil dibuat!');
    }

    public function show(Campaign $campaign)
    {
        $campaign->load(['category', 'user', 'donations.donor', 'distributions.user', 'updates']);
        
        // Get confirmed donations with donors
        $donations = $campaign->donations()->with('donor')->where('status', 'confirmed')->latest()->get();
        
        // Get distributions
        $distributions = $campaign->distributions()->with('user')->latest()->get();
        
        // Get campaign updates
        $updates = $campaign->updates()->latest()->get();
        
        return view('admin.campaigns.show', compact('campaign', 'donations', 'distributions', 'updates'));
    }

    public function edit(Campaign $campaign)
    {
        $categories = \App\Models\Category::all();
        return view('admin.campaigns.edit', compact('campaign', 'categories'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'target_amount' => 'required|numeric|min:10000',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive,completed',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($campaign->image_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($campaign->image_url)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($campaign->image_url);
            }
            
            $path = $request->file('image')->store('campaigns', 'public');
            $validated['image_url'] = $path;
        }

        $validated['is_featured'] = $request->has('is_featured');

        $validated['slug'] = \Illuminate\Support\Str::slug($request->title);
        $validated['short_description'] = \Illuminate\Support\Str::limit($request->description, 150);
        $validated['full_description'] = $request->description;
        unset($validated['description']);

        if (empty($validated['start_date'])) {
             unset($validated['start_date']); // Don't update if empty/null since it's required
        }

        $campaign->update($validated);

        return redirect()->route('admin.campaigns.index')->with('success', 'Program wakaf berhasil diperbarui!');
    }

    public function destroy(Campaign $campaign)
    {
        if ($campaign->image_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($campaign->image_url)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($campaign->image_url);
        }
        
        $campaign->delete();

        return redirect()->route('admin.campaigns.index')->with('success', 'Program wakaf berhasil dihapus!');
    }
}
