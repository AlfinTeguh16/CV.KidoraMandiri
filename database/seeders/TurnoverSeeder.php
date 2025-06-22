<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TurnoverSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $karyawanIds = DB::table('karyawan')->pluck('id_karyawan')->toArray();

        for ($i = 0; $i < 20; $i++) {
            DB::table('turnover')->insert([
                'id_karyawan' => $faker->randomElement($karyawanIds),
                'tanggal_keluar' => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
                'alasan'      => $faker->sentence,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
