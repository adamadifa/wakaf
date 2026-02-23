<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use App\Models\VisionMissionWakaf;
use Illuminate\Http\Request;

class VisionMissionController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'umum');
        
        if ($tab === 'wakaf') {
            $visionMission = VisionMissionWakaf::first();
            if (!$visionMission) {
                $visionMission = VisionMissionWakaf::create(['visi' => '', 'misi' => '']);
            }
        } else {
            $visionMission = VisionMission::first();
            if (!$visionMission) {
                $visionMission = VisionMission::create(['visi' => '', 'misi' => '']);
            }
        }

        return view('admin.vision_mission.index', compact('visionMission', 'tab'));
    }

    public function update(Request $request)
    {
        $tab = $request->input('tab', 'umum');
        
        $model = ($tab === 'wakaf') ? VisionMissionWakaf::class : VisionMission::class;
        $visionMission = $model::first();
        if (!$visionMission) {
            $visionMission = $model::create([]);
        }

        $request->validate([
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
        ]);

        $visionMission->update($request->only(['visi', 'misi']));

        return redirect()->route('admin.vision-mission.index', ['tab' => $tab])
            ->with('success', 'Visi dan Misi ' . ($tab === 'wakaf' ? 'Wakaf ' : '') . 'berhasil diperbarui.');
    }
}
