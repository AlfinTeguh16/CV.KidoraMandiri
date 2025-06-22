<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){
        return view('pages.dashboard.index');
    }

     // Korelasi: Jumlah Karyawan Lulus Pelatihan per Departemen
    public function pelatihanLulusPerDepartemen()
    {
        $data = DB::table('data_karyawan_dan_pelatihan')
            ->select('departemen', DB::raw('COUNT(*) as total'))
            ->where('status_kelulusan', 'LULUS')
            ->groupBy('departemen')
            ->get();

        return response()->json($data);
    }

    // Korelasi: Jumlah Insiden per Departemen
    public function insidenPerDepartemen()
    {
        $data = DB::table('data_insiden')
            ->select('departemen', DB::raw('COUNT(*) as jumlah_insiden'))
            ->groupBy('departemen')
            ->get();

        return response()->json($data);
    }

    // Korelasi: Jumlah Promosi Berdasarkan Tahun Bergabung
    public function promosiBerdasarkanTahun()
    {
        $rawData = DB::table('data_promosi')
            ->select('bergabung_dengan_pt_kidora as tahun', DB::raw('COUNT(*) as jumlah_promosi'))
            ->groupBy('bergabung_dengan_pt_kidora')
            ->get()
            ->keyBy('tahun');

        $tahunAwal = 2012; // ⬅️ dimulai dari 2012
        $tahunSekarang = now()->year;

        $data = [];

        for ($tahun = $tahunAwal; $tahun <= $tahunSekarang; $tahun++) {
            $jumlah = isset($rawData[$tahun]) ? $rawData[$tahun]->jumlah_promosi : 0;
            $data[] = [
                'tahun' => $tahun,
                'jumlah_promosi' => $jumlah
            ];
        }

        return response()->json($data);
    }





    // Korelasi: Turnover Berdasarkan Alasan
    public function turnoverPerAlasan()
    {
        $data = DB::table('data_turnover')
            ->select('alasan', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('alasan')
            ->orderByDesc('jumlah')
            ->get();

        return response()->json($data);
    }
}
