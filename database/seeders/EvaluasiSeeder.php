<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EvaluasiSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $karyawanIds = DB::table('karyawan')->pluck('id_karyawan')->toArray();

        // Buat 50 data evaluasi
        for ($i = 0; $i < 50; $i++) {
            DB::table('evaluasi')->insert([
                'id_karyawan'      => $faker->randomElement($karyawanIds),
                'tanggal_evaluasi' => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
                'nilai_kualitas'   => $faker->randomFloat(2, 50, 100),
                'nilai_kuantitas'  => $faker->randomFloat(2, 50, 100),
                'komentar'         => $faker->sentence,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}
