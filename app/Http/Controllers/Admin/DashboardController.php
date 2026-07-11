<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\Rule;
use App\Models\SesiDiagnosa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_kerusakan' => Kerusakan::count(),
            'total_gejala'    => Gejala::count(),
            'total_rules'     => Rule::count(),
            'total_sesi'      => SesiDiagnosa::count(),
        ];

        $recentSesi = SesiDiagnosa::orderByDesc('created_at')->limit(5)->get();

        // Distribusi kerusakan dari riwayat diagnosa
        $kerusakanPopuler = [];
        SesiDiagnosa::all()->each(function ($sesi) use (&$kerusakanPopuler) {
            $hasil = $sesi->hasil_diagnosa ?? [];
            if (!empty($hasil)) {
                $top = $hasil[0];
                $kode = $top['kode'] ?? 'Unknown';
                $nama = $top['nama'] ?? 'Unknown';
                if (!isset($kerusakanPopuler[$kode])) {
                    $kerusakanPopuler[$kode] = ['nama' => $nama, 'count' => 0];
                }
                $kerusakanPopuler[$kode]['count']++;
            }
        });
        arsort($kerusakanPopuler);
        $kerusakanPopuler = array_slice($kerusakanPopuler, 0, 5, true);

        return view('admin.dashboard', compact('stats', 'recentSesi', 'kerusakanPopuler'));
    }
}
