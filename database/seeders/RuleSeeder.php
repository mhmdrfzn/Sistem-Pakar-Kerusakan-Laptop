<?php

namespace Database\Seeders;

use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\Rule;
use Illuminate\Database\Seeder;

class RuleSeeder extends Seeder
{
    public function run(): void
    {
        // Mapping: [kode_kerusakan => [[kode_gejala, cf_nilai], ...]]
        // Struktur baru: 1 Rule per kerusakan, gejala disimpan di pivot rule_gejala

        $rules = [
            // K001 - LCD
            'K001' => [
                ['G001', 0.6], // Layar monitor tidak menampilkan gambar
                ['G002', 0.4], // Menyala tetapi keluar garis-garis vertikal
                ['G003', 0.2], // Tampak blok hitam
                ['G004', 0.6], // Gambar tidak simetris atau acak
                ['G005', 0.4], // Tampak blank putih
            ],

            // K002 - Keyboard
            'K002' => [
                ['G006', 1.0], // Beberapa tombol tidak berfungsi
                ['G007', 0.8], // Huruf menekan sendiri
                ['G008', 0.8], // Keluar bunyi beep panjang
            ],

            // K003 - Memory RAM
            'K003' => [
                ['G001', 0.6], // Layar monitor tidak menampilkan gambar
                ['G009', 0.4], // Blank screen pada saat mulai loading OS
                ['G010', 0.4], // Saat dinyalakan screen tidak menyala
                ['G011', 0.8], // Fan menyala sebentar kemudian mati
                ['G012', 0.6], // LED indikator power menyala
            ],

            // K004 - Charger
            'K004' => [
                ['G013', 0.6], // Tidak ada indikator daya masuk
                ['G014', 0.6], // Laptop di-charge posisi hidup kemudian mati
                ['G015', 0.8], // Kursor bergetar tidak stabil
                ['G016', 0.2], // Case laptop atau slot device nyetrum
            ],

            // K005 - Harddisk
            'K005' => [
                ['G017', 1.0], // Sering bluescreen
                ['G018', 1.0], // Loading data atau loading system lambat
                ['G019', 0.8], // Berbunyi tidak normal
                ['G020', 0.8], // Pembacaan data lambat
                ['G021', 0.2], // System membaca file system dan tidak ditemukan
                ['G022', 1.0], // System restart tidak terdeteksi
                ['G023', 0.8], // Muncul notifikasi scandisk diawal laptop dinyalakan
                ['G024', 0.8], // Sering muncul notifikasi "application has stop working"
                ['G038', 0.6], // Laptop tiba-tiba restart/mati sendiri
                ['G040', 0.8], // Hardisk tidak detek di bios laptop
            ],

            // K006 - Touchpad
            'K006' => [
                ['G015', 0.8], // Kursor bergetar tidak stabil
                ['G025', 1.0], // Tidak dapat di klik tombol touchpad
                ['G026', 0.6], // Kursor mouse bergerak sendiri
                ['G027', 1.0], // Touchpad / mouse tidak berfungsi
            ],

            // K007 - Cooling Fan
            'K007' => [
                ['G028', 1.0], // Kipas tidak terputar
                ['G029', 0.8], // Bagian bawah laptop sangat panas
                ['G030', 0.2], // Laptop suhu tinggi (overheat)
            ],

            // K008 - Webcam
            'K008' => [
                ['G031', 0.4], // Driver tidak bisa diinstall
                ['G032', 1.0], // Tidak hidup webcam
                ['G033', 0.6], // Tidak menyala lampu webcam
            ],

            // K009 - Baterai
            'K009' => [
                ['G034', 1.0], // Baterai silang
                ['G035', 0.2], // LED baterai mati
                ['G036', 0.8], // Baterai tidak mau mengisi
            ],

            // K010 - Motherboard
            'K010' => [
                ['G017', 1.0], // Sering bluescreen
                ['G036', 0.8], // Baterai tidak mau mengisi
                ['G037', 0.6], // Tidak ada bunyi bep yang muncul
                ['G038', 0.6], // Laptop tiba-tiba restart/mati sendiri
                ['G039', 0.2], // Tombol power on-off tidak berfungsi
                ['G040', 0.8], // Hardisk tidak detek di bios laptop
                ['G041', 0.2], // Tampilan gambar kadang mati kadang hilang
            ],

            // K011 - Speaker
            'K011' => [
                ['G042', 1.0], // Tidak ada bunyi suara sound
                ['G043', 0.4], // Suara lebih kecil dari biasanya
                ['G044', 0.8], // Suara muncul dan hilang secara tiba-tiba
                ['G045', 0.6], // Suara terdengar pecah atau kemresek
            ],
        ];

        foreach ($rules as $kodeKerusakan => $gejalaList) {
            $kerusakan = Kerusakan::where('kode', $kodeKerusakan)->first();
            if (!$kerusakan) continue;

            // Buat 1 Rule per kerusakan (struktur baru)
            $rule = Rule::firstOrCreate(
                ['kerusakan_id' => $kerusakan->id],
                ['nama_rule'    => 'Rule ' . $kodeKerusakan]
            );

            // Kumpulkan pivot data: [gejala_id => ['cf_nilai' => value]]
            $pivotData = [];
            foreach ($gejalaList as [$kodeGejala, $cfNilai]) {
                $gejala = Gejala::where('kode', $kodeGejala)->first();
                if (!$gejala) continue;
                $pivotData[$gejala->id] = ['cf_nilai' => $cfNilai];
            }

            // Sync pivot ke rule_gejala (replace all)
            if (!empty($pivotData)) {
                $rule->gejala()->sync($pivotData);
            }
        }
    }
}
