<?php

namespace Database\Seeders;

use App\Models\Kerusakan;
use Illuminate\Database\Seeder;

class KerusakanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kode' => 'K001',
                'nama' => 'LCD',
                'komponen_pengganti' => 'Panel LCD/LED Slim Laptop (11.6", 13.3", 14.0", atau 15.6" socket 30-pin/40-pin)',
                'est_part_min' => 650000,
                'est_part_max' => 1250000,
                'service_fee' => 150000,
                'icon' => '🖥️',
                'kategori' => 'display',
                'solutions' => [
                    'Matikan laptop dengan mencabut baterai.',
                    'Lepas konektor LCD dari kabel charger.',
                    'Tekan dan tahan tombol power off selama beberapa detik untuk membuang sisa arus/kapasitas listrik.',
                    'Pasang kembali baterai dan kabel konektor LCD secara presisi.',
                    'Jika langkah di atas tidak berhasil, maka perlu mengganti LCD baru.',
                ],
            ],
            [
                'kode' => 'K002',
                'nama' => 'Keyboard',
                'komponen_pengganti' => 'Keyboard Internal Laptop sesuai brand dan tipe sasis keyboard',
                'est_part_min' => 150000,
                'est_part_max' => 350000,
                'service_fee' => 100000,
                'icon' => '⌨️',
                'kategori' => 'input',
                'solutions' => [
                    'Bersihkan keyboard fisik dengan menyikat sela-sela tombol.',
                    'Cek apakah ada tombol tertekan terus.',
                    'Buka Device Manager dan periksa driver keyboard.',
                    'Jika beberapa tombol tetap rusak, ganti keyboard baru.',
                ],
            ],
            [
                'kode' => 'K003',
                'nama' => 'Memory RAM',
                'komponen_pengganti' => 'Kepingan RAM DDR3 / DDR4 / DDR5 SODIMM Laptop',
                'est_part_min' => 250000,
                'est_part_max' => 850000,
                'service_fee' => 50000,
                'icon' => '🧠',
                'kategori' => 'hardware',
                'solutions' => [
                    'Lepaskan RAM dari slot laptop secara hati-hati.',
                    'Bersihkan pin kuningan RAM menggunakan karet penghapus.',
                    'Pasang kembali RAM di slot yang berbeda.',
                    'Coba pasangkan RAM alternatif untuk menguji.',
                ],
            ],
            [
                'kode' => 'K004',
                'nama' => 'Charger',
                'komponen_pengganti' => 'Unit Adaptor Charger Laptop Original bawaan pabrik',
                'est_part_min' => 180000,
                'est_part_max' => 450000,
                'service_fee' => 0,
                'icon' => '🔌',
                'kategori' => 'power',
                'solutions' => [
                    'Uji adapter charger menggunakan multimeter.',
                    'Periksa apakah kabel power mengalami tekukan ekstrem.',
                    'Coba gunakan charger sejenis yang masih berfungsi.',
                    'Ganti adapter charger jika arus voltase sudah tidak stabil.',
                ],
            ],
            [
                'kode' => 'K005',
                'nama' => 'Harddisk',
                'komponen_pengganti' => 'Penyimpanan SSD (Solid State Drive) SATA 2.5 inch atau SSD M.2 NVMe',
                'est_part_min' => 300000,
                'est_part_max' => 1100000,
                'service_fee' => 100000,
                'icon' => '💾',
                'kategori' => 'storage',
                'solutions' => [
                    'Periksa kesehatan harddisk menggunakan HD Tune atau CrystalDiskInfo.',
                    'Lakukan defragmentasi disk secara berkala.',
                    'Lakukan backup data penting segera.',
                    'Sangat disarankan untuk upgrade ke SSD.',
                ],
            ],
            [
                'kode' => 'K006',
                'nama' => 'Touchpad',
                'komponen_pengganti' => 'Modul Touchpad Board / Kabel Flexible Konektor Touchpad',
                'est_part_min' => 100000,
                'est_part_max' => 250000,
                'service_fee' => 100000,
                'icon' => '🖱️',
                'kategori' => 'input',
                'solutions' => [
                    'Periksa pengaturan Touchpad di Windows Settings.',
                    'Tekan tombol shortcut keyboard (Fn + F6/F9).',
                    'Install ulang driver Touchpad melalui Device Manager.',
                    'Periksa konektor internal pada motherboard.',
                ],
            ],
            [
                'kode' => 'K007',
                'nama' => 'Cooling Fan',
                'komponen_pengganti' => 'Modul Kipas Pendingin Processor (CPU Fan) dan Thermal Paste premium',
                'est_part_min' => 70000,
                'est_part_max' => 180000,
                'service_fee' => 100000,
                'icon' => '🌀',
                'kategori' => 'cooling',
                'solutions' => [
                    'Bersihkan debu-debu tebal yang menyumbat sirip kipas.',
                    'Ganti thermal paste pada processor (CPU) dan chip grafis (GPU).',
                    'Beri sedikit pelumas khusus pada poros kipas.',
                    'Ganti modul kipas jika motor kipas sudah mati.',
                ],
            ],
            [
                'kode' => 'K008',
                'nama' => 'Webcam',
                'komponen_pengganti' => 'Modul internal kamera webcam laptop atau Webcam USB Eksternal',
                'est_part_min' => 120000,
                'est_part_max' => 300000,
                'service_fee' => 100000,
                'icon' => '📷',
                'kategori' => 'peripheral',
                'solutions' => [
                    'Periksa tombol saklar privasi fisik (shutter) webcam.',
                    'Pastikan akses izin kamera aktif pada pengaturan privasi.',
                    'Cek driver webcam pada Device Manager.',
                    'Kabel fleksibel kamera kemungkinan besar putus jika tidak terdeteksi.',
                ],
            ],
            [
                'kode' => 'K009',
                'nama' => 'Baterai',
                'komponen_pengganti' => 'Baterai Laptop Original tipe Li-ion atau Lithium-Polymer',
                'est_part_min' => 350000,
                'est_part_max' => 850000,
                'service_fee' => 50000,
                'icon' => '🔋',
                'kategori' => 'power',
                'solutions' => [
                    'Lakukan kalibrasi baterai secara berkala.',
                    'Bersihkan konektor baterai dari korosi atau debu.',
                    'Periksa Battery Health menggunakan batteryreport.',
                    'Ganti baterai utuh jika sudah mengalami drop parah.',
                ],
            ],
            [
                'kode' => 'K010',
                'nama' => 'Motherboard',
                'komponen_pengganti' => 'Perbaikan IC Power/Chipset (Servis Mikrokontroler) atau unit Motherboard Pengganti',
                'est_part_min' => 450000,
                'est_part_max' => 1800000,
                'service_fee' => 200000,
                'icon' => '🔧',
                'kategori' => 'hardware',
                'solutions' => [
                    'Lakukan pembersihan total mainboard menggunakan contact cleaner.',
                    'Periksa adanya kapasitor kembung atau terbakar.',
                    'Uji sirkuit IC power menggunakan multimeter.',
                    'Lakukan re-balling pada chipset atau ganti motherboard.',
                ],
            ],
            [
                'kode' => 'K011',
                'nama' => 'Speaker',
                'komponen_pengganti' => 'Satu set Modul Speaker Internal laptop yang kompatibel',
                'est_part_min' => 75000,
                'est_part_max' => 180000,
                'service_fee' => 100000,
                'icon' => '🔊',
                'kategori' => 'audio',
                'solutions' => [
                    'Periksa pengaturan volume, balance, dan output audio.',
                    'Lakukan update atau rollback driver Realtek.',
                    'Gunakan headphone untuk memastikan sumber kerusakan.',
                    'Ganti membran speaker internal jika terdengar pecah.',
                ],
            ],
        ];

        foreach ($data as $item) {
            Kerusakan::updateOrCreate(
                ['kode' => $item['kode']],
                $item
            );
        }
    }
}
