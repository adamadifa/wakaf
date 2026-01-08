<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Categories
        $categories = [
            'Kegiatan Sosial',
            'Pendidikan',
            'Kesehatan',
            'Laporan Penyaluran',
            'Artikel Islami'
        ];

        $categoryIds = [];

        foreach ($categories as $catName) {
            $category = NewsCategory::create([
                'name' => $catName,
                'slug' => Str::slug($catName),
            ]);
            $categoryIds[] = $category->id;
        }

        // 2. Create News Items
        $titles = [
            'Penyaluran Wakaf Al-Quran ke pelosok Desa',
            'Pembangunan Sumur Wakaf untuk Masyarakat Kekeringan',
            'Beasiswa Pendidikan Santri Penghafal Quran',
            'Layanan Kesehatan Gratis Dhuafa',
            'Renovasi Masjid di Daerah Terpencil',
            'Keutamaan Berwakaf di Bulan Ramadhan',
            'Laporan Keuangan Wakaf Periode Q1 2026',
            'Kisah Inspiratif Pewakaf Tanah',
            'Sedekah Jumat Berkah: Berbagi Makanan',
            'Program Wakaf Produktif Kebun Kurma'
        ];

        foreach ($titles as $index => $title) {
            News::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p><p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
                'published_at' => now()->subDays(rand(1, 30)),
                'user_id' => 1, // Assumes user ID 1 exists (admin)
                'news_category_id' => $categoryIds[array_rand($categoryIds)],
                'image' => null, // Placeholder or null
            ]);
        }
    }
}
