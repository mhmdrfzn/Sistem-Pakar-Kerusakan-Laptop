<?php

namespace App\Services;

use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\Rule;

/**
 * Certainty Factor Service
 * 
 * Menghitung nilai keyakinan (Certainty Factor) diagnosa berdasarkan gejala yang dipilih.
 * Formula: CF_combine(CF1, CF2) = CF1 + CF2 * (1 - CF1)
 */
class CertaintyFactorService
{
    /**
     * Menggabungkan dua nilai CF
     * CF_combine = CF1 + CF2 × (1 - CF1)
     */
    public function combine(float $cf1, float $cf2): float
    {
        if ($cf1 >= 0 && $cf2 >= 0) {
            // Keduanya positif
            return $cf1 + $cf2 * (1 - $cf1);
        } elseif ($cf1 < 0 && $cf2 < 0) {
            // Keduanya negatif
            return $cf1 + $cf2 * (1 + $cf1);
        } else {
            // Campuran positif dan negatif
            return ($cf1 + $cf2) / (1 - min(abs($cf1), abs($cf2)));
        }
    }

    /**
     * Hitung CF gabungan dari array nilai CF
     */
    public function hitungCFGabungan(array $cfValues): float
    {
        if (empty($cfValues)) return 0.0;

        $cfKombinasi = 0.0;
        foreach ($cfValues as $cf) {
            $cfKombinasi = $this->combine($cfKombinasi, (float) $cf);
        }

        return round($cfKombinasi, 4);
    }

    /**
     * Konversi nilai CF ke persentase keyakinan
     */
    public function toPercentage(float $cf): float
    {
        return round($cf * 100, 2);
    }

    /**
     * Interpretasi nilai CF
     */
    public function interpretasi(float $cf): array
    {
        $persen = $this->toPercentage($cf);

        if ($persen >= 80) {
            return [
                'label' => 'Sangat Yakin',
                'color' => 'red',
                'badge' => 'KRITIS',
                'icon' => '🔴',
                'deskripsi' => 'Sangat kemungkinan besar mengalami kerusakan ini.',
            ];
        } elseif ($persen >= 60) {
            return [
                'label' => 'Yakin',
                'color' => 'orange',
                'badge' => 'TINGGI',
                'icon' => '🟠',
                'deskripsi' => 'Kemungkinan besar mengalami kerusakan ini.',
            ];
        } elseif ($persen >= 40) {
            return [
                'label' => 'Cukup Yakin',
                'color' => 'yellow',
                'badge' => 'SEDANG',
                'icon' => '🟡',
                'deskripsi' => 'Cukup memungkinkan mengalami kerusakan ini.',
            ];
        } elseif ($persen >= 20) {
            return [
                'label' => 'Kurang Yakin',
                'color' => 'blue',
                'badge' => 'RENDAH',
                'icon' => '🔵',
                'deskripsi' => 'Kemungkinan rendah, perlu pemeriksaan lebih lanjut.',
            ];
        } else {
            return [
                'label' => 'Tidak Yakin',
                'color' => 'gray',
                'badge' => 'MINOR',
                'icon' => '⚪',
                'deskripsi' => 'Kemungkinan sangat kecil mengalami kerusakan ini.',
            ];
        }
    }
}
