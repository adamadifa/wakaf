<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMissionWakaf;
use Illuminate\Http\Request;

class VisionMissionWakafController extends Controller
{
    public function index()
    {
        $visionMission = VisionMissionWakaf::first();
        if (!$visionMission) {
            $visionMission = VisionMissionWakaf::create(['visi' => '', 'misi' => '']);
        }
        return view('admin.vision_mission_wakaf.index', compact('visionMission'));
    }

    public function update(Request $request)
    {
        $visionMission = VisionMissionWakaf::first();
        if (!$visionMission) {
            $visionMission = VisionMissionWakaf::create([]);
        }

        $request->validate([
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
        ]);

        $visionMission->update($request->only(['visi', 'misi']));

        return redirect()->back()->with('success', 'Visi dan Misi Wakaf berhasil diperbarui.');
    }
}
