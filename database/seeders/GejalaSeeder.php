<?php

namespace Database\Seeders;

use App\Models\Gejala;
use Illuminate\Database\Seeder;

class GejalaSeeder extends Seeder
{
    public function run(): void
    {
        $gejala = [
            // ============================
            // GEJALA LCD / DISPLAY (G001-G005)
            // ============================
            ['kode' => 'G001', 'deskripsi' => 'Layar monitor tidak menampilkan gambar',              'kategori' => 'Display & Layar'],
            ['kode' => 'G002', 'deskripsi' => 'Menyala tetapi keluar garis-garis vertikal',          'kategori' => 'Display & Layar'],
            ['kode' => 'G003', 'deskripsi' => 'Tampak blok hitam',                                   'kategori' => 'Display & Layar'],
            ['kode' => 'G004', 'deskripsi' => 'Gambar tidak simetris atau acak',                     'kategori' => 'Display & Layar'],
            ['kode' => 'G005', 'deskripsi' => 'Tampak blank putih',                                  'kategori' => 'Display & Layar'],

            // ============================
            // GEJALA KEYBOARD (G006-G008)
            // ============================
            ['kode' => 'G006', 'deskripsi' => 'Beberapa tombol tidak berfungsi',                     'kategori' => 'Keyboard & Input'],
            ['kode' => 'G007', 'deskripsi' => 'Huruf menekan sendiri',                               'kategori' => 'Keyboard & Input'],
            ['kode' => 'G008', 'deskripsi' => 'Keluar bunyi beep panjang',                           'kategori' => 'Keyboard & Input'],

            // ============================
            // GEJALA MEMORY RAM (G009-G012)
            // ============================
            ['kode' => 'G009', 'deskripsi' => 'Blank screen pada saat mulai loading operating system','kategori' => 'Performa & Sistem'],
            ['kode' => 'G010', 'deskripsi' => 'Saat dinyalakan screen tidak menyala',                'kategori' => 'Performa & Sistem'],
            ['kode' => 'G011', 'deskripsi' => 'Fan menyala sebentar kemudian mati',                  'kategori' => 'Performa & Sistem'],
            ['kode' => 'G012', 'deskripsi' => 'LED indikator power menyala',                         'kategori' => 'Performa & Sistem'],

            // ============================
            // GEJALA CHARGER / POWER (G013-G016)
            // ============================
            ['kode' => 'G013', 'deskripsi' => 'Tidak ada indikator daya masuk',                      'kategori' => 'Daya & Baterai'],
            ['kode' => 'G014', 'deskripsi' => 'Laptop di-charge posisi hidup kemudian mati',         'kategori' => 'Daya & Baterai'],
            ['kode' => 'G015', 'deskripsi' => 'Kursor bergetar tidak stabil',                        'kategori' => 'Keyboard & Input'],
            ['kode' => 'G016', 'deskripsi' => 'Case laptop atau slot device nyetrum',                'kategori' => 'Daya & Baterai'],

            // ============================
            // GEJALA HARDDISK / STORAGE (G017-G024)
            // ============================
            ['kode' => 'G017', 'deskripsi' => 'Sering bluescreen',                                   'kategori' => 'Penyimpanan & Boot'],
            ['kode' => 'G018', 'deskripsi' => 'Loading data atau loading system lambat',             'kategori' => 'Penyimpanan & Boot'],
            ['kode' => 'G019', 'deskripsi' => 'Berbunyi tidak normal',                               'kategori' => 'Penyimpanan & Boot'],
            ['kode' => 'G020', 'deskripsi' => 'Pembacaan data lambat',                               'kategori' => 'Penyimpanan & Boot'],
            ['kode' => 'G021', 'deskripsi' => 'System membaca file system dan tidak ditemukan',      'kategori' => 'Penyimpanan & Boot'],
            ['kode' => 'G022', 'deskripsi' => 'System restart tidak terdeteksi',                     'kategori' => 'Penyimpanan & Boot'],
            ['kode' => 'G023', 'deskripsi' => 'Muncul notifikasi scandisk diawal laptop dinyalakan', 'kategori' => 'Penyimpanan & Boot'],
            ['kode' => 'G024', 'deskripsi' => 'Sering muncul notifikasi "application has stop working"', 'kategori' => 'Penyimpanan & Boot'],

            // ============================
            // GEJALA TOUCHPAD (G025-G027)
            // ============================
            ['kode' => 'G025', 'deskripsi' => 'Tidak dapat di klik tombol touchpad',                 'kategori' => 'Keyboard & Input'],
            ['kode' => 'G026', 'deskripsi' => 'Kursor mouse bergerak sendiri',                       'kategori' => 'Keyboard & Input'],
            ['kode' => 'G027', 'deskripsi' => 'Touchpad / mouse tidak berfungsi',                    'kategori' => 'Keyboard & Input'],

            // ============================
            // GEJALA COOLING FAN (G028-G030)
            // ============================
            ['kode' => 'G028', 'deskripsi' => 'Kipas tidak terputar',                                'kategori' => 'Pendinginan & Suhu'],
            ['kode' => 'G029', 'deskripsi' => 'Bagian bawah laptop sangat panas',                    'kategori' => 'Pendinginan & Suhu'],
            ['kode' => 'G030', 'deskripsi' => 'Laptop suhu tinggi (overheat)',                        'kategori' => 'Pendinginan & Suhu'],

            // ============================
            // GEJALA WEBCAM (G031-G033)
            // ============================
            ['kode' => 'G031', 'deskripsi' => 'Driver tidak bisa diinstall',                         'kategori' => 'Kamera & Multimedia'],
            ['kode' => 'G032', 'deskripsi' => 'Tidak hidup webcam',                                  'kategori' => 'Kamera & Multimedia'],
            ['kode' => 'G033', 'deskripsi' => 'Tidak menyala lampu webcam',                          'kategori' => 'Kamera & Multimedia'],

            // ============================
            // GEJALA BATERAI (G034-G041)
            // ============================
            ['kode' => 'G034', 'deskripsi' => 'Baterai silang',                                      'kategori' => 'Daya & Baterai'],
            ['kode' => 'G035', 'deskripsi' => 'LED baterai mati',                                    'kategori' => 'Daya & Baterai'],
            ['kode' => 'G036', 'deskripsi' => 'Baterai tidak mau mengisi',                           'kategori' => 'Daya & Baterai'],
            ['kode' => 'G037', 'deskripsi' => 'Tidak ada bunyi bep yang muncul',                     'kategori' => 'Daya & Baterai'],
            ['kode' => 'G038', 'deskripsi' => 'Laptop tiba-tiba restart/mati sendiri',               'kategori' => 'Performa & Sistem'],
            ['kode' => 'G039', 'deskripsi' => 'Tombol power on-off tidak berfungsi',                 'kategori' => 'Performa & Sistem'],
            ['kode' => 'G040', 'deskripsi' => 'Hardisk tidak detek di bios laptop',                  'kategori' => 'Penyimpanan & Boot'],
            ['kode' => 'G041', 'deskripsi' => 'Tampilan gambar kadang mati kadang hilang',           'kategori' => 'Performa & Sistem'],

            // ============================
            // GEJALA SPEAKER / AUDIO (G042-G045)
            // ============================
            ['kode' => 'G042', 'deskripsi' => 'Tidak ada bunyi suara sound',                         'kategori' => 'Kamera & Multimedia'],
            ['kode' => 'G043', 'deskripsi' => 'Suara lebih kecil dari biasanya meskipun volume sudah maksimal', 'kategori' => 'Kamera & Multimedia'],
            ['kode' => 'G044', 'deskripsi' => 'Suara muncul dan hilang secara tiba-tiba',            'kategori' => 'Kamera & Multimedia'],
            ['kode' => 'G045', 'deskripsi' => 'Suara terdengar pecah atau kemresek pada volume tinggi','kategori' => 'Kamera & Multimedia'],
        ];

        foreach ($gejala as $item) {
            Gejala::updateOrCreate(
                ['kode' => $item['kode']],
                $item
            );
        }
    }
}
