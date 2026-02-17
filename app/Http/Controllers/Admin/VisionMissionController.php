<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use Illuminate\Http\Request;

class VisionMissionController extends Controller
{
    public function index()
    {
        $visionMission = VisionMission::first();
        if (!$visionMission) {
            $visionMission = VisionMission::create(['visi' => '', 'misi' => '']);
        }
        return view('admin.vision_mission.index', compact('visionMission'));
    }

    public function update(Request $request)
    {
        $visionMission = VisionMission::first();
        if (!$visionMission) {
            $visionMission = VisionMission::create([]);
        }

        $request->validate([
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
        ]);

        $visionMission->update($request->only(['visi', 'misi']));

        return redirect()->back()->with('success', 'Visi dan Misi berhasil diperbarui.');
    }
}
