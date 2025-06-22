<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function turnover(){
        $data = DB::table('fakta_turnover as ft')
            ->join('dim_turnover as dt', 'ft.id_turnover', '=', 'dt.id_turnover')
            ->join('dim_karyawan as dk', 'ft.id_karyawan', '=', 'dk.id')
            ->select(
                'ft.id_fakta_turnover',
                'dk.nama_sdm',
                'dk.departemen',
                'dt.alasan',
                'dt.status_resign',
                'dt.status_phk',
                'dt.bulan',
                'dt.tahun'
            )
            ->orderBy('dt.tahun')
            ->orderByRaw("FIELD(dt.bulan,
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
            ->get();

        return response()->json($data);
    }

    public function insiden()
    {
        $data = DB::table('fakta_insiden as fi')
            ->join('dim_insiden as di', 'fi.id_insiden', '=', 'di.id_insiden')
            ->join('dim_karyawan as dk', 'fi.id_karyawan', '=', 'dk.id')
            ->join('dim_waktu as dw', 'fi.id_waktu', '=', 'dw.id_waktu')
            ->select(
                'fi.id_fakta_insiden',
                'dk.nama_sdm',
                'dk.departemen',
                'di.jenis_insiden',
                'di.kerugian',
                'di.faktor',
                'di.status_penanganan',
                'di.lokasi',
                'dw.bulan',
                'dw.tahun'
            )
            ->orderBy('dw.tahun')
            ->orderBy('dw.bulan')
            ->get();

        return response()->json($data);
    }


    public function pelatihan()
    {
        $data = DB::table('fakta_pelatihan as fp')
            ->join('dim_pelatihan as dp', 'fp.id_pelatihan', '=', 'dp.id_pelatihan')
            ->join('dim_karyawan as dk', 'fp.id_karyawan', '=', 'dk.id')
            ->select(
                'fp.id_fakta_pelatihan',
                'dk.nama_sdm',
                'dk.departemen',
                'dp.nama_pelatihan',
                'dp.materi',
                'dp.sertifikasi',
                'fp.penilaian as nilai',
                'fp.status_kelulusan'
            )
            ->whereNotNull('fp.status_kelulusan')
            ->get();

        return response()->json($data);
    }

    public function promosi()
    {
        $data = DB::table('fakta_promosi as fpr')
            ->join('dim_promosi as dp', 'fpr.id_promosi', '=', 'dp.id_promosi')
            ->join('dim_karyawan as dk', 'fpr.id_karyawan', '=', 'dk.id')
            ->select(
                'fpr.id_fakta_promosi',
                'dk.nama_sdm',
                'dk.departemen',
                'dp.jabatan_sebelum',
                'dp.jabatan_sesudah',
                'fpr.masa_jabatan'
            )
            ->orderBy('dk.departemen')
            ->orderBy('dp.jabatan_sesudah')
            ->get();

        return response()->json($data);
    }




}
