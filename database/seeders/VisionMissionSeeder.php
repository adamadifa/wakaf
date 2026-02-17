<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisionMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\VisionMission::truncate();

        \App\Models\VisionMission::create([
            'visi' => 'Menjadi lembaga pengelola wakaf yang amanah, produktif, dan profesional untuk kemaslahatan umat.',
            'misi' => '<ul><li>Mengelola aset wakaf secara produktif dan berkelanjutan.</li><li>Meningkatkan kesadaran masyarakat tentang pentingnya berwakaf.</li><li>Memberikan manfaat wakaf seluas-luasnya bagi masyarakat yang membutuhkan.</li><li>Membangun tata kelola lembaga yang transparan dan akuntabel.</li></ul>',
        ]);
    }
}
