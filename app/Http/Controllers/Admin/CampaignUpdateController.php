<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignUpdate;
use Illuminate\Http\Request;

class CampaignUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CampaignUpdate::with('campaign');

        if ($request->has('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        if ($request->has('campaign_id') && $request->campaign_id != '') {
            $query->where('campaign_id', $request->campaign_id);
        }

        $updates = $query->latest('published_at')->paginate(10);
        $campaigns = Campaign::select('id', 'title')->get();

        return view('admin.campaign_updates.index', compact('updates', 'campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $campaigns = Campaign::where('status', 'active')->select('id', 'title')->get();
        return view('admin.campaign_updates.create', compact('campaigns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'required|date',
        ]);

        CampaignUpdate::create($validated);

        return redirect()->route('admin.campaign-updates.index')
            ->with('success', 'Kabar terbaru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CampaignUpdate $campaignUpdate)
    {
        $campaigns = Campaign::select('id', 'title')->get();
        return view('admin.campaign_updates.edit', compact('campaignUpdate', 'campaigns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CampaignUpdate $campaignUpdate)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'required|date',
        ]);

        $campaignUpdate->update($validated);

        return redirect()->route('admin.campaign-updates.index')
            ->with('success', 'Kabar terbaru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CampaignUpdate $campaignUpdate)
    {
        $campaignUpdate->delete();

        return redirect()->route('admin.campaign-updates.index')
            ->with('success', 'Kabar terbaru berhasil dihapus.');
    }
}
