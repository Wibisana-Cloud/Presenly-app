<?php

namespace Database\Seeders;

use App\Models\HariLibur;
use Illuminate\Database\Seeder;

class HariLiburSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['tanggal' => '2026-01-01', 'nama' => 'Tahun Baru Masehi'],
            ['tanggal' => '2026-01-27', 'nama' => 'Isra Miraj Nabi Muhammad SAW'],
            ['tanggal' => '2026-02-17', 'nama' => 'Tahun Baru Imlek 2577'],
            ['tanggal' => '2026-03-03', 'nama' => 'Hari Raya Nyepi (Tahun Baru Saka 1948)'],
            ['tanggal' => '2026-03-20', 'nama' => 'Wafat Isa Al Masih'],
            ['tanggal' => '2026-03-31', 'nama' => 'Hari Raya Idul Fitri 1447 H'],
            ['tanggal' => '2026-04-01', 'nama' => 'Hari Raya Idul Fitri 1447 H (Hari Kedua)'],
            ['tanggal' => '2026-04-05', 'nama' => 'Hari Paskah'],
            ['tanggal' => '2026-05-01', 'nama' => 'Hari Buruh Internasional'],
            ['tanggal' => '2026-05-14', 'nama' => 'Kenaikan Isa Al Masih'],
            ['tanggal' => '2026-05-23', 'nama' => 'Hari Raya Waisak 2570'],
            ['tanggal' => '2026-06-01', 'nama' => 'Hari Lahir Pancasila'],
            ['tanggal' => '2026-06-07', 'nama' => 'Hari Raya Idul Adha 1447 H'],
            ['tanggal' => '2026-06-27', 'nama' => 'Tahun Baru Islam 1448 H'],
            ['tanggal' => '2026-08-17', 'nama' => 'Hari Kemerdekaan Republik Indonesia'],
            ['tanggal' => '2026-09-05', 'nama' => 'Maulid Nabi Muhammad SAW'],
            ['tanggal' => '2026-12-25', 'nama' => 'Hari Raya Natal'],
        ];

        foreach ($data as $item) {
            HariLibur::updateOrCreate(
                ['tanggal' => $item['tanggal']],
                [
                    'nama' => $item['nama'],
                    'tipe' => 'nasional',
                    'is_manual' => false,
                ]
            );
        }

        echo '✓ '.count($data)." hari libur 2026 berhasil ditambahkan!\n";
    }
}
