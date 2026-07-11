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
        // Sumber: Tabel 4. Basis Rule
        // Format aturan: IF Gx(cf) AND Gy(cf) ... THEN Kn

        $rules = [
            // K001 - LCD
            // IF G001(0,6) AND G002(0,4) AND G003(0,2) AND G004(0,6) AND G005(0,4) THEN K001
            'K001' => [
                ['G001', 0.6], // Layar monitor tidak menampilkan gambar
                ['G002', 0.4], // Menyala tetapi keluar garis-garis vertikal
                ['G003', 0.2], // Tampak blok hitam
                ['G004', 0.6], // Gambar tidak simetris atau acak
                ['G005', 0.4], // Tampak blank putih
            ],

            // K002 - Keyboard
            // IF G006(1) AND G007(0,8) AND G008(0,8) THEN K002
            'K002' => [
                ['G006', 1.0], // Beberapa tombol tidak berfungsi
                ['G007', 0.8], // Huruf menekan sendiri
                ['G008', 0.8], // Keluar bunyi beep panjang
            ],

            // K003 - Memory RAM
            // IF G001(0,6) AND G009(0,4) AND G010(0,4) AND G011(0,8) AND G012(0,6) THEN K003
            'K003' => [
                ['G001', 0.6], // Layar monitor tidak menampilkan gambar
                ['G009', 0.4], // Blank screen pada saat mulai loading operating system
                ['G010', 0.4], // Saat dinyalakan screen tidak menyala
                ['G011', 0.8], // Fan menyala sebentar kemudian mati
                ['G012', 0.6], // LED indikator power menyala
            ],

            // K004 - Charger
            // IF G013(0,6) AND G014(0,6) AND G015(0,8) AND G016(0,2) THEN K004
            'K004' => [
                ['G013', 0.6], // Tidak ada indikator daya masuk
                ['G014', 0.6], // Laptop di-charge posisi hidup kemudian mati
                ['G015', 0.8], // Kursor bergetar tidak stabil
                ['G016', 0.2], // Case laptop atau slot device nyetrum
            ],

            // K005 - Harddisk
            // IF G017(1) AND G018(1) AND G019(0,8) AND G020(0,8) AND G021(0,2) AND G022(1)
            //    AND G023(0,8) AND G024(0,8) AND G038(0,6) AND G040(0,8) THEN K005
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
            // IF G015(0,8) AND G025(1) AND G026(0,6) AND G027(1) THEN K006
            'K006' => [
                ['G015', 0.8], // Kursor bergetar tidak stabil
                ['G025', 1.0], // Tidak dapat di klik tombol touchpad
                ['G026', 0.6], // Kursor mouse bergerak sendiri
                ['G027', 1.0], // Touchpad / mouse tidak berfungsi
            ],

            // K007 - Cooling Fan
            // IF G028(1) AND G029(0,8) AND G030(0,2) THEN K007
            'K007' => [
                ['G028', 1.0], // Kipas tidak terputar
                ['G029', 0.8], // Bagian bawah laptop sangat panas
                ['G030', 0.2], // Laptop suhu tinggi (overheat)
            ],

            // K008 - Webcam
            // IF G031(0,4) AND G032(1) AND G033(0,6) THEN K008
            'K008' => [
                ['G031', 0.4], // Driver tidak bisa diinstall
                ['G032', 1.0], // Tidak hidup webcam
                ['G033', 0.6], // Tidak menyala lampu webcam
            ],

            // K009 - Baterai
            // IF G034(1) AND G035(0,2) AND G036(0,8) THEN K009
            'K009' => [
                ['G034', 1.0], // Baterai silang
                ['G035', 0.2], // LED baterai mati
                ['G036', 0.8], // Baterai tidak mau mengisi
            ],

            // K010 - Motherboard
            // IF G017(1) AND G036(0,8) AND G037(0,6) AND G038(0,6) AND G039(0,2) AND G040(0,8)
            //    AND G041(0,2) THEN K010
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
            // IF G042(1) AND G043(0,4) AND G044(0,8) AND G045(0,6) THEN K011
            'K011' => [
                ['G042', 1.0], // Tidak ada bunyi suara sound
                ['G043', 0.4], // Suara lebih kecil dari biasanya meskipun volume sudah maksimal
                ['G044', 0.8], // Suara muncul dan hilang secara tiba-tiba
                ['G045', 0.6], // Suara terdengar pecah atau kemresek pada volume tinggi
            ],
        ];

        foreach ($rules as $kodeKerusakan => $gejalaRules) {
            $kerusakan = Kerusakan::where('kode', $kodeKerusakan)->first();

            if (!$kerusakan) continue;

            foreach ($gejalaRules as [$kodeGejala, $cfNilai]) {
                $gejala = Gejala::where('kode', $kodeGejala)->first();

                if (!$gejala) continue;

                Rule::updateOrCreate(
                    [
                        'kerusakan_id' => $kerusakan->id,
                        'gejala_id'    => $gejala->id,
                    ],
                    ['cf_nilai' => $cfNilai]
                );
            }
        }
    }
}
