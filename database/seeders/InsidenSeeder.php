<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class InsidenSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $karyawanIds = DB::table('karyawan')->pluck('id_karyawan')->toArray();
        $jenisInsiden = ['Kecelakaan', 'Keterlambatan', 'Kesalahan Operasional'];

        for ($i = 0; $i < 30; $i++) {
            DB::table('insiden')->insert([
                'id_karyawan'       => $faker->randomElement($karyawanIds),
                'tanggal_kejadian'  => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
                'lokasi'            => $faker->city,
                'jenis_insiden'     => $faker->randomElement($jenisInsiden),
                'akibat'            => $faker->sentence,
                'status_penanganan' => $faker->randomElement(['Selesai', 'Dalam Proses', 'Pending']),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}
