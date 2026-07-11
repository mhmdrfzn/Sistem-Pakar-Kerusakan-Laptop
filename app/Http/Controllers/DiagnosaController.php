<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\SesiDiagnosa;
use App\Services\ForwardChainingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DiagnosaController extends Controller
{
    protected ForwardChainingService $fcService;

    public function __construct(ForwardChainingService $fcService)
    {
        $this->fcService = $fcService;
    }

    /**
     * Landing Page / Home
     */
    public function index()
    {
        $totalKerusakan = Kerusakan::count();
        $totalGejala = Gejala::count();

        $kategoriGejala = Gejala::selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori')
            ->get();

        return view('welcome', compact('totalKerusakan', 'totalGejala', 'kategoriGejala'));
    }

    /**
     * Halaman Form Diagnosa
     */
    public function form()
    {
        $gejalaTerkelompok = Gejala::orderBy('kode')
            ->get()
            ->groupBy('kategori');

        $kerusakanList = Kerusakan::orderBy('kode')->get();

        return view('diagnosa.index', compact('gejalaTerkelompok', 'kerusakanList'));
    }

    /**
     * Proses Diagnosa Forward Chaining + Certainty Factor
     */
    public function proses(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'nullable|string|max:100',
            'nama_laptop'   => 'nullable|string|max:100',
            'gejala'        => 'required|array|min:1',
            'gejala.*'      => 'string|exists:gejala,kode',
            'cf_user'       => 'nullable|array',
            'cf_user.*'     => 'nullable|numeric|min:0.1|max:1.0',
        ], [
            'gejala.required' => 'Pilih minimal 1 gejala untuk melakukan diagnosa.',
            'gejala.min'      => 'Pilih minimal 1 gejala.',
        ]);

        $kodeGejala = $request->input('gejala', []);
        $namaUser   = $request->input('nama_pengguna', 'Anonim');
        $namaLaptop = $request->input('nama_laptop', 'Tidak diketahui');

        // CF User per gejala — default 1.0 jika tidak diisi
        $cfUserInput = $request->input('cf_user', []);
        $cfUser = [];
        foreach ($kodeGejala as $kode) {
            $cfUser[$kode] = isset($cfUserInput[$kode])
                ? (float) $cfUserInput[$kode]
                : 1.0;
        }

        // Jalankan mesin inferensi Forward Chaining + CF
        $hasilDiagnosa = $this->fcService->diagnosa($kodeGejala, $cfUser);

        // Simpan sesi diagnosa ke database
        $sesi = SesiDiagnosa::create([
            'nama_pengguna' => $namaUser,
            'nama_laptop'   => $namaLaptop,
            'gejala_dipilih'=> $kodeGejala,
            'hasil_diagnosa'=> $hasilDiagnosa,
            'ip_address'    => $request->ip(),
        ]);

        // Ambil detail gejala yang dipilih
        $gejalaDipilih = Gejala::whereIn('kode', $kodeGejala)->get();

        return view('diagnosa.hasil', [
            'sesi'          => $sesi,
            'hasilDiagnosa' => $hasilDiagnosa,
            'gejalaDipilih' => $gejalaDipilih,
            'namaUser'      => $namaUser,
            'namaLaptop'    => $namaLaptop,
            'kodeGejala'    => $kodeGejala,
            'cfUser'        => $cfUser,
        ]);
    }

    /**
     * API: Get gejala per kategori (JSON)
     */
    public function apiGejala()
    {
        $data = Gejala::orderBy('kode')->get()->groupBy('kategori');
        return response()->json($data);
    }

    /**
     * Halaman riwayat diagnosa
     */
    public function riwayat()
    {
        $sesiList = SesiDiagnosa::orderByDesc('created_at')->paginate(10);
        return view('diagnosa.riwayat', compact('sesiList'));
    }

    /**
     * Halaman detail satu sesi diagnosa
     */
    public function detail($id)
    {
        $sesi = SesiDiagnosa::findOrFail($id);

        $hasilDiagnosa = $sesi->hasil_diagnosa ?? [];
        $kodeGejala    = $sesi->gejala_dipilih ?? [];

        // Ambil detail gejala dari database berdasarkan kode yang tersimpan
        $gejalaDipilih = Gejala::whereIn('kode', $kodeGejala)->get();

        return view('diagnosa.detail', [
            'sesi'          => $sesi,
            'hasilDiagnosa' => $hasilDiagnosa,
            'gejalaDipilih' => $gejalaDipilih,
            'namaUser'      => $sesi->nama_pengguna ?? 'Anonim',
            'namaLaptop'    => $sesi->nama_laptop   ?? 'Tidak diketahui',
            'kodeGejala'    => $kodeGejala,
        ]);
    }
}
