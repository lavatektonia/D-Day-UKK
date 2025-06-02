<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industries = Industry::insert([
            [
                'name' => 'PT Multiintegra', 
                'picture' => 'default.png',
                'industry_sector' => 'IT Navigation, Solution at Sea, Ashore & Port Terminal, Simulation & Training System, Radio Communication',
                'contact' => '0817-4705-108',
                'email' => 'info@multiintegra.co.id',
                'website' => 'https://www.multiintegra.co.id/',
                'address' => 'Taman Berdikari Sentosa B-1D, Jl. Pemuda, Jakarta Timur 13220',
            ],
            [
                'name' => 'PT Gamatechno Indonesia', 
                'picture' => 'default.png',
                'industry_sector' => 'Penyedia layanan, solusi, dan produk inovasi teknologi informasi serta holding company yang melahirkan startup di bidang teknologi informasi.',
                'contact' => '0274-5044044',
                'email' => 'info@gamatechno.com',
                'website' => 'https://www.gamatechno.com/',
                'address' => 'Jl. Purwomartani, Karangmojo, Purwomartani, Kec. Kalasan, Kabupaten Sleman, Daerah Istimewa Yogyakarta',
            ],
            [
                'name' => 'Lifemedia', 
                'picture' => 'default.png',
                'industry_sector' => 'Network',
                'contact' => '0274-6055655',
                'email' => 'cs@lifemedia.id',
                'website' => 'https://lifemedia.id/',
                'address' => 'Jl. Parangtritis No.97, Brontokusuman, Kec. Mergangsan, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55153',
            ],
            [
                'name' => 'CV Karya Hidup Sentosa', 
                'picture' => 'default.png',
                'industry_sector' => 'Pertanian',
                'contact' => '0274-512095',
                'email' => 'operator1@quick.co.id',
                'website' => 'https://quick.co.id/',
                'address' => 'Jl. Magelang 144, Karangwaru, Tegalrejo, Yogyakarta, Indonesia – 55241',
            ],
        ]);
    }
}