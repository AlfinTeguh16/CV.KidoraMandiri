<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PelatihanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $jenisPelatihan = ['Teknis', 'Soft Skills'];

        for ($i = 0; $i < 20; $i++) {
            DB::table('pelatihan')->insert([
                'nama_pelatihan'  => 'Pelatihan ' . $faker->word,
                'jenis_pelatihan' => $faker->randomElement($jenisPelatihan),
                'penyelenggara'   => $faker->company,
                'durasi'          => $faker->numberBetween(1, 8),
                'tujuan_pelatihan'=> $faker->sentence,
                'materi_pelatihan'=> $faker->paragraph,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
