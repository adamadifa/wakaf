<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Manager::truncate();

        $managers = [
            [
                'name' => 'H. Ahmad Fauzi',
                'position' => 'Ketua Yayasan',
                'image' => 'https://ui-avatars.com/api/?name=Ahmad+Fauzi&background=0D8ABC&color=fff&size=512',
                'bio' => 'Berpengalaman lebih dari 20 tahun dalam pengelolaan lembaga sosial keagamaan. Berdedikasi untuk memajukan wakaf produktif.',
                'facebook_link' => 'https://facebook.com/ahmadfauzi',
                'instagram_link' => 'https://instagram.com/ahmadfauzi',
                'order' => 1,
            ],
            [
                'name' => 'Dr. Siti Aminah',
                'position' => 'Direktur Eksekutif',
                'image' => 'https://ui-avatars.com/api/?name=Siti+Aminah&background=random&size=512',
                'bio' => 'Ahli ekonomi syariah dengan fokus pada pengembangan instrumen wakaf tunai. Lulusan Universitas Al-Azhar Kairo.',
                'facebook_link' => 'https://facebook.com/sitiaminah',
                'instagram_link' => 'https://instagram.com/sitiaminah',
                'order' => 2,
            ], 
            [
                'name' => 'Rizky Pratama',
                'position' => 'Manajer Program',
                'image' => 'https://ui-avatars.com/api/?name=Rizky+Pratama&background=random&size=512',
                'bio' => 'Memiliki passion dalam pemberdayaan masyarakat melalui program-program wakaf produktif yang inovatif.',
                'facebook_link' => 'https://facebook.com/rizkypratama',
                'instagram_link' => 'https://instagram.com/rizkypratama',
                'order' => 3,
            ],
            [
                'name' => 'Nurul Hidayati',
                'position' => 'Manajer Keuangan',
                'image' => 'https://ui-avatars.com/api/?name=Nurul+Hidayati&background=random&size=512',
                'bio' => 'Akuntan profesional yang memastikan transparansi dan akuntabilitas pengelolaan dana wakaf.',
                'facebook_link' => 'https://facebook.com/nurulhidayati',
                'instagram_link' => 'https://instagram.com/nurulhidayati',
                'order' => 4,
            ]
        ];

        foreach ($managers as $manager) {
            \App\Models\Manager::create($manager);
        }
    }
}
