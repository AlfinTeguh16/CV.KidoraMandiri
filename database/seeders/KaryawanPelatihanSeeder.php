<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class KaryawanPelatihanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Ambil semua id karyawan dan pelatihan
        $karyawanIds = DB::table('karyawan')->pluck('id_karyawan')->toArray();
        $pelatihanIds = DB::table('pelatihan')->pluck('id_pelatihan')->toArray();
        $statuses = ['Lulus', 'Tidak Lulus', 'Sedang Berjalan'];

        // Buat 100 data hubungan karyawan dengan pelatihan
        for ($i = 0; $i < 100; $i++) {
            $startDate = $faker->dateTimeBetween('-1 years', 'now');
            // Tanggal selesai, minimal 1 hari setelah tanggal mulai
            $endDate = (clone $startDate)->modify('+'. $faker->numberBetween(1, 5) .' days');

            DB::table('karyawan_pelatihan')->insert([
                'id_karyawan'    => $faker->randomElement($karyawanIds),
                'id_pelatihan'   => $faker->randomElement($pelatihanIds),
                'tanggal_mulai'  => $startDate->format('Y-m-d'),
                'tanggal_selesai'=> $endDate->format('Y-m-d'),
                'status'         => $faker->randomElement($statuses),
                'nilai'          => $faker->randomFloat(2, 0, 100),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
