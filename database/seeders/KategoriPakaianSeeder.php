<?php

namespace Database\Seeders;

use App\Models\KategoriPakaian;
use Illuminate\Database\Seeder;

class KategoriPakaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'name' => 'Pakaian Dinas Harian (PDH)',
                'keterangan' => 'Pakaian yang digunakan untuk tugas sehari-hari',
            ],
            [
                'name' => 'Pakaian Dinas Lapangan (PDL)',
                'keterangan' => 'Pakaian yang digunakan untuk tugas di lapangan',
            ],
            [
                'name' => 'Pakaian Sipil Harian (PSH)',
                'keterangan' => 'Pakaian sipil untuk kegiatan harian tertentu',
            ],
            [
                'name' => 'Batik Khas Daerah',
                'keterangan' => 'Pakaian batik resmi pemerintah daerah',
            ],
            [
                'name' => 'Seragam KORPRI',
                'keterangan' => 'Seragam resmi anggota KORPRI',
            ],
        ];

        foreach ($kategoris as $kategori) {
            KategoriPakaian::create($kategori);
        }
    }
}
