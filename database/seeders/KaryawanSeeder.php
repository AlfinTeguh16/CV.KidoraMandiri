<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker       = Faker::create('id_ID');
        $departemen  = ['Keamanan', 'Kebersihan', 'Penanganan Bagasi'];
        $jabatan     = ['Staff', 'Supervisor', 'Manager'];
        $lokasi      = ['Terminal', 'Apron'];
        $statusKepegawaian = ['Tetap', 'Kontrak', 'Freelance'];
        $shiftKerja  = ['Pagi', 'Siang', 'Malam'];

        for ($i = 0; $i < 50; $i++) {
            DB::table('karyawan')->insert([
                'nama'                => $faker->name,
                'tgl_lahir'           => $faker->date('Y-m-d', '2000-01-01'),
                'departemen'          => $faker->randomElement($departemen),
                'jabatan'             => $faker->randomElement($jabatan),
                'lokasi'              => $faker->randomElement($lokasi),
                'tingkat_pendidikan'  => $faker->randomElement(['SMA', 'Diploma', 'Sarjana']),
                'keterampilan_khusus' => $faker->sentence(6),
                'bahasa'              => $faker->randomElement(['Indonesia', 'Inggris']),
                'sertifikasi'         => $faker->word,
                'status_kepegawaian'  => $faker->randomElement($statusKepegawaian),
                'shift_kerja'         => $faker->randomElement($shiftKerja),
                'status_kesehatan'    => $faker->randomElement(['Sehat', 'Tidak Sehat']),
                'kontak_darurat'      => $faker->phoneNumber,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }
    }
}
