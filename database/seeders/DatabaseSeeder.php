<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@wakaf.com'],
            [
                'name' => 'Admin Wakaf',
                'password' => bcrypt('password'), // Ensure you hash the password
                'role' => 'admin',
                'phone' => '081234567890',
            ]
        );

        // 2. Categories
        $categories = [
            ['name' => 'Wakaf Pembangunan', 'slug' => 'wakaf-pembangunan', 'description' => 'Program pembangunan infrastruktur umat seperti Masjid, Sekolah, dan Asrama.'],
            ['name' => 'Wakaf Al-Quran', 'slug' => 'wakaf-alquran', 'description' => 'Tebar mushaf Al-Quran ke pelosok negeri.'],
            ['name' => 'Zakat Maal', 'slug' => 'zakat-maal', 'description' => 'Membersihkan harta dengan menunaikan kewajiban zakat.'],
            ['name' => 'Sedekah Subuh', 'slug' => 'sedekah-subuh', 'description' => 'Awali hari dengan kebaikan sedekah.'],
            ['name' => 'Kemanusiaan', 'slug' => 'kemanusiaan', 'description' => 'Bantuan darurat untuk bencana alam dan krisis kemanusiaan.'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Payment Methods
        $banks = [
            ['bank_name' => 'BCA', 'account_number' => '7778889991', 'account_name' => 'Yayasan Wakaf Indonesia'],
            ['bank_name' => 'Bank Mandiri', 'account_number' => '123000456000', 'account_name' => 'Yayasan Wakaf Indonesia'],
            ['bank_name' => 'BSI (Syariah)', 'account_number' => '1002003004', 'account_name' => 'Yayasan Wakaf Indonesia'],
            ['bank_name' => 'BRI', 'account_number' => '000101000123500', 'account_name' => 'Yayasan Wakaf Indonesia'],
        ];

        foreach ($banks as $bank) {
            \App\Models\PaymentMethod::firstOrCreate(['account_number' => $bank['account_number']], $bank + ['is_active' => true]);
        }

        // 4. Campaigns
        $campaigns = [
            [
                'title' => 'Bangun Masjid di Pelosok Desa',
                'category_slug' => 'wakaf-pembangunan',
                'target_amount' => 500000000, // 500jt
                'current_amount' => 125000000,
                'image_url' => 'campaigns/masjid.jpg',
                'short_description' => 'Bantu warga desa memiliki tempat ibadah yang layak.',
                'full_description' => '<p>Warga desa X sudah lama merindukan masjid yang layak...</p>',
            ],
            [
                'title' => 'Tebar 10.000 Al-Quran Nusantara',
                'category_slug' => 'wakaf-alquran',
                'target_amount' => 1000000000,
                'current_amount' => 450000000,
                'image_url' => 'campaigns/alquran.jpg',
                'short_description' => 'Menghapuskan buta aksara Quran di pelosok negeri.',
                'full_description' => '<p>Program ini bertujuan untuk...</p>',
            ],
            [
                'title' => 'Bantuan Banjir Bandang',
                'category_slug' => 'kemanusiaan',
                'target_amount' => 200000000,
                'current_amount' => 190000000,
                'image_url' => 'campaigns/bencana.jpg',
                'short_description' => 'Darurat! Saudara kita membutuhkan bantuan segera.',
                'full_description' => '<p>Banjir bandang telah meluluhlantakkan...</p>',
            ],
        ];

        foreach ($campaigns as $camp) {
            $category = \App\Models\Category::where('slug', $camp['category_slug'])->first();
            \App\Models\Campaign::create([
                'category_id' => $category->id,
                'user_id' => $admin->id,
                'title' => $camp['title'],
                'slug' => \Illuminate\Support\Str::slug($camp['title']),
                'short_description' => $camp['short_description'],
                'full_description' => $camp['full_description'],
                'target_amount' => $camp['target_amount'],
                'current_amount' => $camp['current_amount'],
                'start_date' => now(),
                'status' => 'active',
                'image_url' => $camp['image_url'] ?? 'placeholder.jpg', // Will be broken image likely
                'is_featured' => true,
            ]);
        }

        // 5. Donors & Donations
        // Create 10 dummy donors
        for ($i = 0; $i < 10; $i++) {
            $donor = \App\Models\User::create([
                'name' => 'Donatur ' . ($i + 1),
                'email' => 'donatur' . ($i + 1) . '@example.com',
                'password' => bcrypt('password'),
                'role' => 'donor',
            ]);

            // Each donor makes 1-3 donations
            $numDonations = rand(1, 3);
            for ($j = 0; $j < $numDonations; $j++) {
                $campaign = \App\Models\Campaign::inRandomOrder()->first();
                $amount = rand(10000, 5000000);
                \App\Models\Donation::create([
                    'invoice_number' => 'INV/' . date('Ymd') . '/' . rand(10000, 99999),
                    'campaign_id' => $campaign->id,
                    'user_id' => $donor->id,
                    'payment_method_id' => \App\Models\PaymentMethod::inRandomOrder()->first()->id,
                    'amount' => $amount,
                    'unique_code' => rand(1, 100),
                    'total_transfer' => $amount, // Simplify
                    'status' => ['pending', 'confirmed'][rand(0, 1)],
                    'is_anonymous' => rand(0, 1) == 1,
                    'confirmed_at' => now(), 
                ]);
            }
        }
    }
}
