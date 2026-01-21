<?php

namespace Database\Seeders;

use App\Models\Pakaian;
use App\Models\KategoriPakaian;
use Illuminate\Database\Seeder;

class PakaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pdh = KategoriPakaian::where('name', 'Pakaian Dinas Harian (PDH)')->first();
        $pdl = KategoriPakaian::where('name', 'Pakaian Dinas Lapangan (PDL)')->first();
        $batik = KategoriPakaian::where('name', 'Batik Khas Daerah')->first();
        $korpri = KategoriPakaian::where('name', 'Seragam KORPRI')->first();

        $pakaians = [
            [
                'kategori_pakaian_id' => $pdh->id,
                'contoh_pakaian' => 'Kemeja Putih Lengan Panjang',
            ],
            [
                'kategori_pakaian_id' => $pdh->id,
                'contoh_pakaian' => 'Celana/Rok Warna Khaki',
            ],
            [
                'kategori_pakaian_id' => $pdl->id,
                'contoh_pakaian' => 'Kemeja Lengan Panjang Warna Gelap',
            ],
            [
                'kategori_pakaian_id' => $batik->id,
                'contoh_pakaian' => 'Batik Motif Parang',
            ],
            [
                'kategori_pakaian_id' => $korpri->id,
                'contoh_pakaian' => 'Seragam KORPRI Biru',
            ],
        ];

        foreach ($pakaians as $pakaian) {
            Pakaian::create($pakaian);
        }
    }
}
