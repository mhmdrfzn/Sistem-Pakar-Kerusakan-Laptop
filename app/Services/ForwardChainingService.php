<?php

namespace App\Services;

use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\Rule;

/**
 * Forward Chaining Service — Versi Multi-Gejala per Rule
 *
 * Alur:
 *  1. Fakta    = gejala yang dipilih pengguna
 *  2. Matching = cari rule yang gejalanya paling banyak cocok (≥50%)
 *  3. CF       = CF_pakar(pivot) × CF_user → combine iteratif per gejala yg cocok
 *  4. Resolve  = pilih 1 rule dengan CF_gabungan tertinggi (Conflict Resolution)
 */
class ForwardChainingService
{
    /** Minimal rasio gejala cocok agar sebuah rule dianggap aktif */
    const MATCH_THRESHOLD = 0.5;

    protected CertaintyFactorService $cfService;

    public function __construct(CertaintyFactorService $cfService)
    {
        $this->cfService = $cfService;
    }

    /**
     * Proses diagnosa berdasarkan gejala yang dipilih
     *
     * @param array $kodeGejala  Kode gejala yang dipilih pengguna ['G001','G003',...]
     * @param array $cfUser      CF User per kode gejala ['G001'=>0.8, 'G003'=>1.0,...]
     * @return array             Satu hasil diagnosa (array berisi 1 elemen) atau kosong
     */
    public function diagnosa(array $kodeGejala, array $cfUser = []): array
    {
        if (empty($kodeGejala)) {
            return [];
        }

        // ── Step 1: Bangun Working Memory (fakta) ─────────────────────────────
        $gejalaDipilih = Gejala::whereIn('kode', $kodeGejala)->get();
        if ($gejalaDipilih->isEmpty()) {
            return [];
        }

        // Map kode → id untuk pencarian cepat
        $kodeToId = $gejalaDipilih->pluck('id', 'kode');  // ['G001' => 1, ...]
        $selectedGejalaIds = $gejalaDipilih->pluck('id')->toArray();

        // ── Step 2: Load semua Rules beserta Gejala (dengan pivot CF) ─────────
        $semuaRules = Rule::with(['kerusakan', 'gejala'])->get();

        // ── Step 3: Matching Phase — cari rules yang aktif ────────────────────
        $conflictSet = [];   // rule-rule yang memenuhi threshold

        foreach ($semuaRules as $rule) {
            $ruleGejalaList = $rule->gejala; // collection dengan pivot cf_nilai
            $totalGejala    = $ruleGejalaList->count();

            if ($totalGejala === 0) continue;

            // Gejala dalam rule ini yang ada di fakta pengguna
            $gejalaYangCocok = $ruleGejalaList->filter(
                fn($g) => in_array($g->id, $selectedGejalaIds)
            );

            $matchCount = $gejalaYangCocok->count();
            $matchRatio = $matchCount / $totalGejala;

            // Rule aktif hanya jika match ratio ≥ threshold
            if ($matchRatio < self::MATCH_THRESHOLD) {
                continue;
            }

            // ── Step 4: Hitung CF untuk rule yang aktif ───────────────────────
            // CF_final per gejala = CF_pakar (pivot) × CF_user
            // Lalu combine iteratif semua CF_final
            $cfValues = [];
            $gejalaCocokDetail = [];

            foreach ($gejalaYangCocok as $g) {
                $cfPakar    = (float) $g->pivot->cf_nilai;
                $cfUserNilai = isset($cfUser[$g->kode])
                    ? (float) $cfUser[$g->kode]
                    : 1.0;
                $cfFinal = round($cfPakar * $cfUserNilai, 4);

                $cfValues[] = $cfFinal;
                $gejalaCocokDetail[] = [
                    'kode'      => $g->kode,
                    'deskripsi' => $g->deskripsi,
                    'cf_pakar'  => $cfPakar,
                    'cf_user'   => $cfUserNilai,
                    'cf_nilai'  => $cfFinal,
                ];
            }

            // Gejala dalam rule yang TIDAK dipilih user (untuk transparansi)
            $gejalaTidakCocok = $ruleGejalaList->filter(
                fn($g) => !in_array($g->id, $selectedGejalaIds)
            )->map(fn($g) => [
                'kode'      => $g->kode,
                'deskripsi' => $g->deskripsi,
                'cf_pakar'  => (float) $g->pivot->cf_nilai,
            ])->values()->toArray();

            $cfGabungan  = $this->cfService->hitungCFGabungan($cfValues);
            $persentase  = $this->cfService->toPercentage($cfGabungan);
            $interpretasi = $this->cfService->interpretasi($cfGabungan);

            $conflictSet[] = [
                'rule_id'          => $rule->id,
                'nama_rule'        => $rule->nama_rule,
                'kerusakan'        => $rule->kerusakan,
                'match_count'      => $matchCount,
                'total_gejala'     => $totalGejala,
                'match_ratio'      => round($matchRatio, 4),
                'cf_gabungan'      => $cfGabungan,
                'persentase'       => $persentase,
                'interpretasi'     => $interpretasi,
                'gejala_cocok'     => $gejalaCocokDetail,
                'gejala_tidak_cocok' => $gejalaTidakCocok,
            ];
        }

        if (empty($conflictSet)) {
            return [];
        }

        // ── Step 5: Conflict Resolution — pilih CF tertinggi ──────────────────
        usort($conflictSet, fn($a, $b) => $b['cf_gabungan'] <=> $a['cf_gabungan']);

        $winner    = $conflictSet[0];
        $kerusakan = $winner['kerusakan'];

        // ── Step 6: Bangun output akhir ────────────────────────────────────────
        $hasil = [
            'kode'               => $kerusakan->kode,
            'nama'               => $kerusakan->nama,
            'komponen_pengganti' => $kerusakan->komponen_pengganti,
            'est_part_min'       => $kerusakan->est_part_min,
            'est_part_max'       => $kerusakan->est_part_max,
            'service_fee'        => $kerusakan->service_fee,
            'solutions'          => $kerusakan->solutions,
            'icon'               => $kerusakan->icon,
            'cf_gabungan'        => $winner['cf_gabungan'],
            'persentase'         => $winner['persentase'],
            'interpretasi'       => $winner['interpretasi'],
            'gejala_cocok'       => $winner['gejala_cocok'],
            'gejala_tidak_cocok' => $winner['gejala_tidak_cocok'],
            'total_gejala'       => $winner['match_count'],
            'total_gejala_rule'  => $winner['total_gejala'],
            'match_ratio'        => $winner['match_ratio'],
            'nama_rule'          => $winner['nama_rule'],
            'estimasi_total_min' => $kerusakan->est_part_min + $kerusakan->service_fee,
            'estimasi_total_max' => $kerusakan->est_part_max + $kerusakan->service_fee,
            // Conflict set untuk transparansi mesin inferensi
            'conflict_set'       => array_map(fn($r) => [
                'kerusakan_kode' => $r['kerusakan']->kode,
                'kerusakan_nama' => $r['kerusakan']->nama,
                'nama_rule'      => $r['nama_rule'],
                'match_count'    => $r['match_count'],
                'total_gejala'   => $r['total_gejala'],
                'match_ratio'    => $r['match_ratio'],
                'cf_gabungan'    => $r['cf_gabungan'],
                'persentase'     => $r['persentase'],
            ], $conflictSet),
        ];

        // Wrap dalam array agar backward-compatible dengan view (foreach $hasilDiagnosa)
        return [$hasil];
    }

    /**
     * Dapatkan semua gejala dikelompokkan per kategori
     */
    public function getGejalaTerkelompok(): array
    {
        $semua   = Gejala::orderBy('kode')->get();
        $grouped = [];
        foreach ($semua as $g) {
            $grouped[$g->kategori][] = $g;
        }
        return $grouped;
    }
}
