<?php

namespace App\Http\Controllers;

use App\Models\Kerusakan;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    // =========================================================================
    // BASIS PENGETAHUAN MENDALAM — setiap entri memiliki:
    //   'triggers'    : kata kunci / frase pemicu
    //   'judul'       : judul topik
    //   'penyebab'    : daftar penyebab umum
    //   'ciri'        : ciri-ciri spesifik yang bisa dikenali
    //   'mandiri'     : langkah-langkah penanganan mandiri di rumah
    //   'kapan_servis': kapan harus dibawa ke teknisi
    //   'pencegahan'  : tips mencegah kerusakan berulang
    //   'biaya_hint'  : gambaran biaya kasar
    //   'kode'        : kode kerusakan untuk referensi DB
    // =========================================================================
    private array $knowledgeBase = [

        // ------------------------------------------------------------------ K001 LCD
        'lcd_gelap' => [
            'triggers'  => ['layar gelap', 'layar hitam', 'layar tidak nyala', 'screen gelap', 'blank screen', 'layar mati'],
            'judul'     => '🖥️ Layar Gelap Total (Blank Screen)',
            'penyebab'  => [
                'Konektor LCD/LVDS longgar atau putus akibat engsel laptop terlalu sering dibuka-tutup ekstrem.',
                'Driver VGA/GPU mengalami crash atau korup setelah update Windows.',
                'Backlight inverter mati — layar sebenarnya menyala namun tidak terlihat (coba sinari dengan senter).',
                'RAM tidak terbaca sempurna sehingga POST gagal dan layar tidak menampilkan apa pun.',
                'Kerusakan IC power pada motherboard yang tidak mengirim tegangan ke layar.',
            ],
            'ciri'      => [
                '✔ Laptop berbunyi normal (suara boot, kipas berputar) tapi layar hitam.',
                '✔ Jika disambungkan ke monitor eksternal via HDMI, gambar muncul normal → masalah ada di layar/konektor.',
                '✔ Jika monitor eksternal juga hitam → masalah ada di VGA atau motherboard.',
                '✔ Layar terlihat sangat redup (bisa terlihat jika disinari senter) → backlight mati.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Restart paksa:** Tahan tombol Power 10 detik hingga laptop mati, lalu nyalakan kembali.',
                '**Langkah 2 – Uji monitor eksternal:** Sambungkan ke TV/monitor via HDMI atau VGA. Jika tampil → masalah di LCD bukan GPU.',
                '**Langkah 3 – Reset RAM:** Matikan laptop, lepas baterai, buka panel bawah, cabut RAM, bersihkan pin kuningan dengan karet penghapus, pasang kembali.',
                '**Langkah 4 – Drain kapasitor:** Setelah RAM dilepas, tahan tombol Power 30 detik (tanpa baterai & charger) untuk membuang sisa muatan.',
                '**Langkah 5 – Periksa konektor:** Jika berani bongkar, periksa kabel konektor LCD di bawah engsel — pastikan tidak tertekuk atau copot.',
                '**Langkah 6 – Uji backlight:** Sinari layar dengan senter di tempat gelap. Jika terlihat bayangan gambar → backlight mati, bukan panel LCD.',
            ],
            'kapan_servis' => 'Bawa ke teknisi jika: (1) monitor eksternal juga tidak tampil, (2) ada bayangan gambar saat disinari senter, (3) kabel konektor terlihat putus.',
            'pencegahan'   => [
                'Jangan buka/tutup layar secara paksa atau terlalu cepat — gerakkan dari bagian tengah engsel.',
                'Hindari meletakkan benda berat di atas laptop yang tertutup.',
                'Gunakan tas laptop dengan bantalan khusus saat dibawa bepergian.',
            ],
            'biaya_hint' => 'Ganti panel LCD: Rp 650.000–1.250.000 | Ganti konektor: Rp 50.000–150.000 | Perbaikan backlight: Rp 100.000–200.000',
            'kode'       => 'K001',
        ],

        'lcd_garis' => [
            'triggers'  => ['garis layar', 'layar bergaris', 'garis vertikal', 'garis horizontal', 'blok hitam', 'layar blok', 'gambar acak', 'tampilan acak', 'gambar aneh'],
            'judul'     => '🖥️ Layar Bergaris / Tampilan Rusak',
            'penyebab'  => [
                'Panel LCD/LED mengalami kerusakan fisik pada lapisan TFT (thin-film transistor) yang mengendalikan piksel.',
                'Kabel fleksibel (LVDS/eDP) yang menghubungkan motherboard ke layar tertekuk atau rapuh.',
                'Driver GPU bermasalah atau konflik setelah update sistem.',
                'Overheating GPU yang menyebabkan artefak visual (garis-garis atau kotak warna).',
                'IC GPU BGA mengalami dry joint (sambungan solder retak akibat termal).',
            ],
            'ciri'      => [
                '✔ Garis muncul sejak awal booting (sebelum masuk Windows) → kerusakan hardware LCD/konektor.',
                '✔ Garis hanya muncul setelah masuk Windows → kemungkinan driver GPU.',
                '✔ Garis berubah jika layar ditekan ringan atau ditekuk → kabel fleksibel bermasalah.',
                '✔ Monitor eksternal normal, layar laptop bergaris → masalah di panel atau kabel LCD.',
                '✔ Monitor eksternal juga bergaris → masalah GPU.',
            ],
            'mandiri'   => [
                '**Langkah 1:** Sambungkan ke monitor eksternal. Jika monitor eksternal normal, masalah di panel LCD.',
                '**Langkah 2:** Update atau rollback driver GPU via Device Manager → Display Adapters → klik kanan → Update/Rollback Driver.',
                '**Langkah 3:** Buka-tutup layar perlahan sambil amati apakah garis berubah — jika ya, kabel fleksibel perlu diganti.',
                '**Langkah 4:** Bersihkan ventilasi laptop dan pastikan suhu GPU tidak overheat (gunakan HWMonitor untuk cek suhu).',
                '**Langkah 5:** Jika garis muncul di area tertentu dan tidak berubah → panel LCD fisik rusak, perlu ganti panel.',
            ],
            'kapan_servis' => 'Langsung ke teknisi jika garis muncul sejak POST/BIOS (sebelum Windows), atau jika ada bekas benturan/tekanan pada layar.',
            'pencegahan'   => [
                'Pasang screen protector atau pelindung layar.',
                'Jangan pernah menutup laptop dengan benda kecil (pena, earphone) di atas keyboard — akan menekan layar dari dalam.',
                'Rutin update driver GPU dari situs resmi produsen (NVIDIA/AMD/Intel).',
            ],
            'biaya_hint' => 'Ganti panel LCD: Rp 650.000–1.250.000 | Ganti kabel fleksibel: Rp 50.000–200.000 | Servis GPU: Rp 200.000–500.000',
            'kode'       => 'K001',
        ],

        'lcd_blank_putih' => [
            'triggers'  => ['layar putih', 'blank putih', 'layar menyala tapi putih', 'white screen'],
            'judul'     => '🖥️ Layar Tampak Blank Putih',
            'penyebab'  => [
                'Konektor panel LCD longgar — sinyal video masuk namun tidak sempurna sehingga layar menampilkan warna solid.',
                'Panel LCD mengalami kerusakan pada lapisan polarizer atau backlight diffuser.',
                'Driver GPU crash pada tahap inisialisasi display.',
                'RAM bermasalah pada slot video memory (untuk GPU integrated yang berbagi RAM).',
            ],
            'mandiri'   => [
                '**Langkah 1:** Restart laptop. Jika putih sejak awal → bukan masalah OS.',
                '**Langkah 2:** Hubungkan monitor eksternal — jika normal, masalah di kabel atau panel LCD.',
                '**Langkah 3:** Buka panel bawah, periksa dan re-plug konektor LCD dengan hati-hati.',
                '**Langkah 4:** Lepas-pasang RAM untuk memastikan kontak baik.',
                '**Langkah 5:** Boot ke Safe Mode (F8 saat booting) — jika normal di Safe Mode, masalah driver GPU.',
            ],
            'kapan_servis' => 'Bawa ke teknisi jika semua langkah di atas gagal — kemungkinan panel LCD perlu diganti.',
            'pencegahan'   => ['Hindari benturan pada area layar.', 'Jaga kabel engsel tidak terlipat berulang.'],
            'biaya_hint' => 'Ganti panel: Rp 650.000–1.250.000 | Perbaikan konektor: Rp 75.000–150.000',
            'kode'       => 'K001',
        ],

        // ------------------------------------------------------------------ K002 Keyboard
        'keyboard_mati' => [
            'triggers'  => ['keyboard tidak berfungsi', 'tombol keyboard', 'keyboard mati', 'tombol tidak merespons', 'keyboard rusak', 'keyboard error', 'ketikan tidak muncul'],
            'judul'     => '⌨️ Keyboard Tidak Berfungsi',
            'penyebab'  => [
                'Debu atau kotoran yang menumpuk di bawah tombol menyebabkan kontak listrik tidak sempurna.',
                'Cairan (air, kopi, dll) yang masuk dan menyebabkan korsleting pada membrane keyboard.',
                'Kabel fleksibel penghubung keyboard ke motherboard longgar atau putus.',
                'Driver keyboard corrupt — sering terjadi setelah update Windows besar.',
                'Keyboard ter-lock (Fn + F-lock aktif) sehingga beberapa tombol berubah fungsi.',
            ],
            'ciri'      => [
                '✔ Beberapa tombol saja yang tidak berfungsi → debu atau kerusakan membrane parsial.',
                '✔ Semua tombol mati → kabel fleksibel atau driver bermasalah.',
                '✔ Tombol mengetik karakter salah → layout keyboard salah atau membrane rusak.',
                '✔ Huruf/angka muncul sendiri → tombol macet atau ada objek menekan tombol.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Periksa Fn Lock:** Coba tekan Fn + Num Lock / F-Lock untuk reset fungsi tombol.',
                '**Langkah 2 – Uji keyboard eksternal USB:** Hubungkan keyboard USB — jika berfungsi, masalah di keyboard internal bukan sistem.',
                '**Langkah 3 – On-Screen Keyboard:** Buka Start → cari "On-Screen Keyboard" untuk kebutuhan darurat.',
                '**Langkah 4 – Device Manager:** Buka Device Manager → Keyboards → klik kanan → Uninstall → Restart untuk reinstall driver.',
                '**Langkah 5 – Bersihkan fisik:** Matikan laptop, balik, dan ketuk ringan di atas permukaan rata untuk merontokkan debu. Gunakan blower udara (compressed air) di celah tombol.',
                '**Langkah 6 – Jika terkena cairan:** SEGERA matikan laptop, lepas baterai, rendam dengan alkohol isopropil 90%+ untuk mendorong air keluar, keringkan 48 jam sebelum dinyalakan.',
            ],
            'kapan_servis' => 'Bawa ke teknisi jika: setelah terkena cairan, tombol tetap macet setelah dibersihkan, atau keyboard sama sekali tidak terdeteksi di Device Manager.',
            'pencegahan'   => [
                'Jangan makan/minum di dekat laptop.',
                'Gunakan cover keyboard silikon sebagai pelindung dari debu dan cairan.',
                'Bersihkan keyboard setiap 2-3 bulan dengan blower udara.',
                'Jangan tekan tombol terlalu keras saat mengetik.',
            ],
            'biaya_hint' => 'Ganti keyboard internal: Rp 150.000–350.000 | Servis konektor: Rp 50.000–100.000',
            'kode'       => 'K002',
        ],

        'keyboard_sendiri' => [
            'triggers'  => ['huruf muncul sendiri', 'tombol menekan sendiri', 'keyboard mengetik sendiri', 'karakter muncul sendiri', 'keyboard ghost'],
            'judul'     => '⌨️ Keyboard Mengetik / Menekan Sendiri',
            'penyebab'  => [
                'Tombol fisik macet karena debu/kotoran terjepit di bawah keycap.',
                'Membrane keyboard mengalami konsleting akibat sisa cairan yang mengering.',
                'Ghost typing — kerusakan pada jalur konduktif membrane menyebabkan sinyal palsu.',
                'Malware/virus tertentu dapat mensimulasikan input keyboard.',
                'Baterai mengembung yang menekan keyboard dari bawah.',
            ],
            'mandiri'   => [
                '**Langkah 1:** Scan antivirus/malware terlebih dahulu menggunakan Windows Defender atau Malwarebytes.',
                '**Langkah 2:** Periksa fisik apakah ada tombol yang terlihat tenggelam/tertekan — coba angkat dengan pinset.',
                '**Langkah 3:** Buka panel bawah laptop — periksa apakah baterai mengembung (menggembung) dan menekan keyboard.',
                '**Langkah 4:** Coba non-aktifkan keyboard internal via Device Manager → Keyboards → Disable Device, lalu gunakan keyboard USB eksternal.',
                '**Langkah 5:** Bersihkan keyboard dengan alkohol isopropil 90% menggunakan cotton bud di celah tombol yang bermasalah.',
            ],
            'kapan_servis' => 'Segera ke teknisi jika baterai terlihat mengembung — ini berbahaya (risiko kebakaran). Juga jika setelah dibersihkan masalah tetap ada.',
            'pencegahan'   => ['Cek kondisi baterai secara berkala.', 'Jangan biarkan cairan tumpah dan mengering di keyboard.'],
            'biaya_hint' => 'Ganti keyboard: Rp 150.000–350.000 | Ganti baterai (jika penyebab): Rp 350.000–850.000',
            'kode'       => 'K002',
        ],

        // ------------------------------------------------------------------ K003 RAM
        'ram_masalah' => [
            'triggers'  => ['ram bermasalah', 'memory error', 'ram rusak', 'masalah ram', 'ram tidak terbaca', 'kapasitas ram berkurang', 'ram kurang'],
            'judul'     => '🧠 Masalah Memory RAM',
            'penyebab'  => [
                'Pin emas pada kepingan RAM teroksidasi atau kotor sehingga kontak ke slot tidak sempurna.',
                'Slot RAM di motherboard rusak (pin bengkok atau patah).',
                'RAM mengalami kerusakan fisik chip memori akibat usia, overclocking, atau lonjakan voltase.',
                'RAM tidak kompatibel dengan motherboard (frekuensi/timing tidak cocok).',
                'Setting XMP/DOCP di BIOS tidak stabil untuk RAM yang dipasang.',
            ],
            'ciri'      => [
                '✔ Bunyi beep panjang berulang saat dinyalakan → RAM tidak terbaca (1 panjang = no RAM).',
                '✔ Blue Screen dengan error MEMORY_MANAGEMENT atau BAD_POOL_HEADER → RAM bermasalah.',
                '✔ RAM terbaca lebih kecil dari spesifikasi di Task Manager → satu keping RAM mati atau slot rusak.',
                '✔ Hang acak tanpa pola → RAM intermittent failure.',
                '✔ Laptop menyala (kipas berputar, LED nyala) tapi layar tetap hitam → POST gagal karena RAM.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Bersihkan pin:** Matikan laptop, lepas baterai, cabut RAM, gosok pin kuningan dengan karet penghapus pensil hingga mengkilap, tiup slotnya.',
                '**Langkah 2 – Pindah slot:** Jika ada 2 slot, coba pasang RAM di slot lain satu per satu.',
                '**Langkah 3 – Uji satu keping:** Jika ada 2 keping RAM, coba boot dengan masing-masing secara terpisah untuk isolasi yang rusak.',
                '**Langkah 4 – Windows Memory Diagnostic:** Buka Start → ketik "mdsched" → Restart dan uji sekarang. Tunggu hasil setelah restart.',
                '**Langkah 5 – MemTest86:** Download MemTest86 (gratis), buat bootable USB, jalankan overnight untuk tes komprehensif.',
                '**Langkah 6 – BIOS:** Reset BIOS ke default (load optimized defaults) — matikan XMP jika aktif.',
            ],
            'kapan_servis' => 'Bawa ke teknisi jika: slot RAM terlihat rusak, atau MemTest86 menemukan error banyak (menunjukkan kerusakan RAM yang perlu diganti).',
            'pencegahan'   => [
                'Jangan cabut/pasang RAM saat laptop masih bermuatan listrik — selalu drain dulu (tahan Power 30 detik setelah baterai dilepas).',
                'Hindari overclocking RAM melebihi spesifikasi.',
                'Gunakan UPS/stabilizer untuk mencegah lonjakan tegangan.',
            ],
            'biaya_hint' => 'RAM DDR4 8GB: Rp 250.000–450.000 | RAM DDR5 8GB: Rp 400.000–850.000 | Servis slot RAM: Rp 100.000–300.000',
            'kode'       => 'K003',
        ],

        'ram_hang' => [
            'triggers'  => ['laptop hang', 'laptop freeze', 'laptop not responding', 'aplikasi hang', 'komputer hang', 'tidak merespons'],
            'judul'     => '🧠 Laptop Sering Hang / Freeze',
            'penyebab'  => [
                'RAM mulai rusak — tidak dapat mempertahankan data secara konsisten.',
                'Storage (HDD/SSD) hampir penuh atau mengalami bad sector.',
                'Virus/malware yang mengonsumsi resource berlebihan.',
                'Laptop overheat menyebabkan throttling ekstrem atau shutdown termal.',
                'Aplikasi dengan memory leak yang tidak dibebaskan.',
                'Driver yang tidak kompatibel atau corrupt.',
            ],
            'mandiri'   => [
                '**Langkah 1:** Periksa kapasitas storage — jika tersisa < 10%, bersihkan file sampah dengan Disk Cleanup.',
                '**Langkah 2:** Task Manager (Ctrl+Shift+Esc) → tab Performance → pantau RAM & CPU usage. Jika RAM 100% → tambah RAM atau kurangi aplikasi.',
                '**Langkah 3:** Scan malware dengan Windows Defender (Full Scan) atau Malwarebytes.',
                '**Langkah 4:** Periksa suhu laptop dengan HWMonitor — jika CPU > 90°C saat hang, masalah pendinginan.',
                '**Langkah 5:** Jalankan Windows Memory Diagnostic (ketik "mdsched" di Start) untuk uji RAM.',
                '**Langkah 6:** Periksa health HDD/SSD dengan CrystalDiskInfo — perhatikan nilai "Caution" atau "Bad".',
            ],
            'kapan_servis' => 'Ke teknisi jika hang terjadi bahkan saat idle (tanpa aplikasi berat), atau CrystalDiskInfo menunjukkan banyak reallocated sectors.',
            'pencegahan'   => [
                'Sisakan minimal 20% ruang storage kosong.',
                'Restart laptop minimal seminggu sekali.',
                'Nonaktifkan program startup yang tidak perlu via Task Manager → Startup.',
            ],
            'biaya_hint' => 'Tambah RAM: Rp 250.000–850.000 | Upgrade SSD: Rp 300.000–800.000',
            'kode'       => 'K003',
        ],

        // ------------------------------------------------------------------ K004 Charger
        'charger_tidak_ngecas' => [
            'triggers'  => ['charger tidak mengisi', 'tidak bisa cas', 'tidak mau ngecas', 'baterai tidak mengisi', 'indikator cas tidak menyala', 'tidak ada indikator', 'charger tidak berfungsi', 'cas mati'],
            'judul'     => '🔌 Charger Tidak Mengisi Daya',
            'penyebab'  => [
                'Kabel charger internal putus di dekat steker atau di dekat colokan laptop (titik paling sering tertekuk).',
                'IC power/charging pada motherboard rusak sehingga tidak menerima sinyal dari charger.',
                'Port DC jack di laptop longgar, aus, atau pin bengkok.',
                'Adaptor charger sudah aus (output voltase turun di bawah nominal).',
                'Baterai yang sudah sangat drop membuat sistem tidak mendeteksi arus masuk.',
                'Driver "Microsoft ACPI-Compliant Control Method Battery" corrupt.',
            ],
            'ciri'      => [
                '✔ LED charger tidak menyala sama sekali → charger mati atau kabel putus.',
                '✔ LED berkedip-kedip → koneksi tidak stabil (kabel/port goyang).',
                '✔ Charger panas berlebihan → komponen internal charger bermasalah.',
                '✔ Laptop menyala tanpa charger tapi mati saat di-charge → IC charging motherboard rusak.',
                '✔ Windows tampilkan "Plugged in, not charging" → kemungkinan driver atau baterai drop total.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Uji charger lain:** Coba charger sejenis milik teman. Jika berfungsi → charger kamu rusak.',
                '**Langkah 2 – Periksa kabel:** Raba sepanjang kabel charger — cari bagian yang lebih panas, menekuk tidak normal, atau terasa retak di dalam.',
                '**Langkah 3 – Bersihkan port DC:** Lihat lubang DC jack — pastikan tidak ada kotoran atau pin bengkok. Bersihkan dengan cotton bud kering.',
                '**Langkah 4 – Lepas baterai + charge:** Matikan laptop, lepas baterai (jika bisa dilepas), pasang charger saja, lalu nyalakan. Jika menyala → baterai bermasalah, bukan charger.',
                '**Langkah 5 – Reset driver baterai:** Device Manager → Batteries → klik kanan "Microsoft ACPI-Compliant Control Method Battery" → Uninstall → Restart.',
                '**Langkah 6 – Ukur voltase:** Jika punya multimeter, ukur output DC jack charger. Seharusnya sesuai label (misal 19V). Jika jauh berbeda → charger rusak.',
            ],
            'kapan_servis' => 'Segera ke teknisi jika: port DC jack goyang/rusak (perlu solder), atau laptop nyetrum/arus bocor saat disentuh.',
            'pencegahan'   => [
                'Jangan gulung kabel charger terlalu ketat — tekukan ekstrem merusak kawat tembaga di dalam.',
                'Cabut charger dengan memegang colokan, bukan menarik kabelnya.',
                'Gunakan charger original — charger KW seringkali outputnya tidak stabil.',
                'Hindari menggunakan laptop di atas kasur/bantal saat di-charge (panas terperangkap).',
            ],
            'biaya_hint' => 'Charger original baru: Rp 180.000–450.000 | Ganti DC jack: Rp 50.000–150.000 + jasa servis Rp 75.000',
            'kode'       => 'K004',
        ],

        'charger_nyetrum' => [
            'triggers'  => ['laptop nyetrum', 'setrum laptop', 'kesetrum laptop', 'bodi laptop nyetrum', 'case nyetrum', 'slot nyetrum'],
            'judul'     => '🔌 Laptop Nyetrum / Arus Bocor',
            'penyebab'  => [
                'Charger tanpa grounding (3 pin ke 2 pin) menyebabkan kebocoran arus ke bodi laptop.',
                'Insulasi kabel charger rusak sehingga arus bertegangan bocor ke casing.',
                'IC filter EMI di motherboard atau charger rusak.',
                'Komponen internal laptop mengalami kebocoran arus ke ground chassis.',
            ],
            'mandiri'   => [
                '**Langkah 1:** Cek apakah colokan charger di stopkontak adalah 2 pin atau 3 pin. Jika 2 pin → tidak ada grounding → wajar terasa tegangan kecil.',
                '**Langkah 2:** Gunakan stopkontak bergrounding (3 lubang) — biasanya nyetrum langsung hilang.',
                '**Langkah 3:** Ganti charger original yang memiliki grounding proper.',
                '**Langkah 4:** Jika sudah pakai grounding namun tetap nyetrum → segera cabut dan jangan gunakan dulu.',
            ],
            'kapan_servis' => 'SEGERA ke teknisi jika nyetrum terasa kuat (bukan sekadar "kriget") meski sudah menggunakan grounding — ini berbahaya.',
            'pencegahan'   => ['Selalu gunakan charger original dengan grounding 3 pin.', 'Periksa kondisi instalasi listrik di rumah.'],
            'biaya_hint' => 'Charger original bergrounding: Rp 180.000–450.000 | Servis IC filter: Rp 150.000–300.000',
            'kode'       => 'K004',
        ],

        // ------------------------------------------------------------------ K005 Harddisk
        'hdd_lambat' => [
            'triggers'  => ['laptop lambat', 'booting lama', 'loading lama', 'laptop lemot', 'windows lambat', 'startup lama', 'aplikasi lama dibuka'],
            'judul'     => '💾 Laptop / Loading Sangat Lambat',
            'penyebab'  => [
                'HDD (Hard Disk Drive) mekanik yang sudah tua — kecepatan baca/tulis jauh di bawah SSD.',
                'Bad sector pada HDD menyebabkan heads harus mencoba berulang kali membaca data.',
                'Storage hampir penuh (< 10% sisa) — OS tidak punya ruang untuk virtual memory & temp files.',
                'Terlalu banyak program startup yang berjalan saat booting.',
                'Fragmentasi file yang parah pada HDD (SSD tidak perlu defrag).',
                'Malware yang berjalan di background mengonsumsi I/O disk.',
                'RAM terlalu kecil sehingga Windows banyak menggunakan page file (virtual memory di disk).',
            ],
            'ciri'      => [
                '✔ LED disk berkedip terus-menerus (100% disk usage di Task Manager) → HDD overload.',
                '✔ Suara "klik-klik" atau "tik-tik" dari area HDD → bad sector atau head bermasalah.',
                '✔ Lambat hanya saat booting lalu normal → terlalu banyak startup program.',
                '✔ Lambat di semua kondisi → HDD tua atau RAM terlalu kecil.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Cek Disk Usage:** Ctrl+Shift+Esc → Performance → Disk. Jika selalu 100% → HDD bermasalah.',
                '**Langkah 2 – Health Check:** Download CrystalDiskInfo (gratis). Nilai "Good" = aman, "Caution" = segera backup, "Bad" = ganti segera.',
                '**Langkah 3 – Bersihkan Startup:** Task Manager → Startup → Disable semua yang tidak penting.',
                '**Langkah 4 – Disk Cleanup:** Start → ketik "cleanmgr" → pilih drive C → centang semua termasuk "System files".',
                '**Langkah 5 – Defragmentasi (HDD saja):** Start → ketik "defrag" → Optimize (jangan lakukan pada SSD!).',
                '**Langkah 6 – Cek Bad Sector:** Buka CMD sebagai Admin → ketik: `chkdsk C: /f /r` → konfirmasi Y → restart.',
                '**Langkah 7 – Upgrade ke SSD:** Ini solusi terbaik dan paling terasa perubahannya — booting dari 2 menit jadi 15 detik.',
            ],
            'kapan_servis' => 'Segera backup data jika CrystalDiskInfo menampilkan "Caution" atau "Bad". Jangan tunda — HDD yang sudah "Bad" bisa mati kapan saja.',
            'pencegahan'   => [
                'Jangan pernah isi storage lebih dari 80% kapasitas.',
                'Backup data minimal sebulan sekali ke cloud atau hard disk eksternal.',
                'Pertimbangkan upgrade ke SSD — harga semakin terjangkau dan manfaatnya luar biasa.',
                'Pasang antivirus dan scan rutin untuk mencegah malware.',
            ],
            'biaya_hint' => 'SSD SATA 256GB: Rp 300.000–500.000 | SSD M.2 NVMe 256GB: Rp 400.000–700.000 | Jasa instalasi + kloning data: Rp 100.000–150.000',
            'kode'       => 'K005',
        ],

        'hdd_bluescreen' => [
            'triggers'  => ['blue screen', 'bluescreen', 'bsod', 'layar biru', 'windows crash', 'laptop restart sendiri', 'restart tiba-tiba'],
            'judul'     => '💾 Blue Screen of Death (BSOD) / Restart Sendiri',
            'penyebab'  => [
                'Bad sector pada HDD yang diakses oleh file sistem Windows.',
                'File sistem Windows corrupt (misalnya akibat mati mendadak tanpa shutdown proper).',
                'Driver hardware yang tidak kompatibel atau corrupt (terutama driver VGA, network, storage).',
                'RAM yang bermasalah — sering menjadi penyebab BSOD acak.',
                'Overheating CPU/GPU yang menyebabkan sistem melakukan emergency shutdown.',
                'Virus/malware yang memodifikasi file sistem.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Baca error code BSOD:** Catat kode error (contoh: CRITICAL_PROCESS_DIED, IRQL_NOT_LESS_OR_EQUAL) — ini kunci untuk diagnosis.',
                '**Langkah 2 – Update driver:** Device Manager → klik kanan semua driver dengan tanda seru kuning → Update Driver.',
                '**Langkah 3 – SFC & DISM:** CMD sebagai Admin → ketik: `sfc /scannow` lalu tunggu. Lanjut dengan: `DISM /Online /Cleanup-Image /RestoreHealth`.',
                '**Langkah 4 – Uji RAM:** Jalankan Windows Memory Diagnostic (`mdsched` di Start) atau MemTest86.',
                '**Langkah 5 – Cek suhu:** Install HWMonitor, pantau suhu saat BSOD terjadi — jika > 95°C, masalah pendinginan.',
                '**Langkah 6 – Event Viewer:** Start → Event Viewer → Windows Logs → System → Cari "Critical" atau "Error" untuk menemukan penyebab.',
                '**Langkah 7 – Startup Repair:** Boot dari USB Windows → Troubleshoot → Advanced → Startup Repair.',
            ],
            'kapan_servis' => 'Ke teknisi jika BSOD terjadi setiap hari atau saat hardware paling dasar (startup), atau CrystalDiskInfo menunjukkan nilai Bad.',
            'pencegahan'   => [
                'Selalu shutdown Windows dengan benar — jangan langsung cabut daya.',
                'Pasang UPS/stabilizer untuk mencegah mati mendadak karena listrik.',
                'Update Windows dan driver secara berkala.',
            ],
            'biaya_hint' => 'Reinstall Windows: Rp 100.000–150.000 | Ganti SSD: Rp 300.000–800.000 | Servis software: Rp 100.000–200.000',
            'kode'       => 'K005',
        ],

        'hdd_bunyi' => [
            'triggers'  => ['harddisk bunyi', 'hdd bunyi', 'bunyi klik', 'bunyi aneh dari laptop', 'suara klik laptop', 'disk bunyi', 'suara dari dalam laptop'],
            'judul'     => '💾 Harddisk Berbunyi Aneh (Klik/Berisik)',
            'penyebab'  => [
                'Read/write head HDD mengalami "click of death" — kondisi darurat yang menandakan kerusakan fisik head.',
                'Permukaan platter HDD tergores akibat getaran atau benturan.',
                'HDD mulai mengalami bearing failure — komponen berputar sudah aus.',
                'Kabel SATA atau konektor HDD longgar menyebabkan suara "nge-klik" saat reconnect.',
            ],
            'mandiri'   => [
                '**PERHATIAN PENTING:** Bunyi klik berulang dari HDD adalah tanda **DARURAT** — segera backup semua data!',
                '**Langkah 1 – BACKUP SEKARANG:** Salin semua data penting ke cloud (Google Drive, OneDrive) atau hard disk eksternal SEGERA.',
                '**Langkah 2 – Kurangi penggunaan:** Jangan jalankan program berat — minimalisir akses disk untuk memperpanjang "usia" HDD.',
                '**Langkah 3 – Cek CrystalDiskInfo:** Jika status "Bad" dan Reallocated Sectors tinggi → HDD sangat kritis.',
                '**Langkah 4 – Jangan defrag:** Justru semakin mempercepat kerusakan pada HDD yang sudah sakit.',
            ],
            'kapan_servis' => 'SEGERA ke teknisi untuk kloning data ke SSD baru sebelum HDD benar-benar mati. Jangan ditunda — data bisa tidak terselamatkan.',
            'pencegahan'   => [
                'Jangan pindahkan laptop saat HDD sedang aktif bekerja (LED disk berkedip).',
                'Pasang laptop di permukaan rata dan stabil saat digunakan.',
                'Backup rutin — data lebih berharga dari hardware.',
            ],
            'biaya_hint' => 'Recovery data dari HDD rusak: Rp 500.000–3.000.000 (tergantung kerusakan) | Kloning ke SSD baru: Rp 100.000 + harga SSD',
            'kode'       => 'K005',
        ],

        // ------------------------------------------------------------------ K006 Touchpad
        'touchpad_mati' => [
            'triggers'  => ['touchpad mati', 'touchpad tidak berfungsi', 'mouse laptop tidak berfungsi', 'pointer tidak bergerak', 'kursor tidak bergerak', 'touchpad error', 'tidak bisa klik touchpad'],
            'judul'     => '🖱️ Touchpad Tidak Berfungsi',
            'penyebab'  => [
                'Touchpad ter-disable via tombol shortcut Fn+F (sering tidak disadari).',
                'Driver Synaptics/ELAN/HID touchpad corrupt atau belum terinstall.',
                'Konektor fleksibel touchpad ke motherboard longgar atau putus.',
                'Windows Update yang mengubah setting touchpad tanpa konfirmasi.',
                'Touchpad secara otomatis nonaktif saat mouse USB terhubung (setting di Windows).',
            ],
            'ciri'      => [
                '✔ Kursor tidak bergerak tapi klik kiri/kanan berfungsi → sensor gerak touchpad rusak.',
                '✔ Kursor bergerak tapi tidak bisa klik → tombol klik fisik rusak.',
                '✔ Semua tidak berfungsi → driver atau touchpad ter-disable.',
                '✔ Kursor bergerak sendiri → touchpad terlalu sensitif atau ada interferensi.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Cek shortcut:** Tekan Fn + F6 (atau F7/F9 tergantung brand). Cari ikon touchpad di tombol F.',
                '**Langkah 2 – Windows Settings:** Start → Settings → Bluetooth & Devices → Touchpad → pastikan toggle ON.',
                '**Langkah 3 – Device Manager:** Kembangkan "Mice and other pointing devices" → klik kanan driver touchpad → Enable/Update Driver.',
                '**Langkah 4 – Lepas mouse USB:** Jika ada mouse USB terpasang, cabut dulu — beberapa laptop otomatis disable touchpad.',
                '**Langkah 5 – Reinstall driver:** Kunjungi website resmi brand laptop → Support → Download driver touchpad sesuai model.',
                '**Langkah 6 – Periksa fisik:** Buka panel bawah, periksa kabel fleksibel touchpad — pastikan kencang di kedua ujungnya.',
            ],
            'kapan_servis' => 'Ke teknisi jika driver sudah diinstall ulang tapi masih tidak terdeteksi, atau konektor fleksibel terlihat robek.',
            'pencegahan'   => [
                'Jangan tekan touchpad terlalu keras — tekanan berlebihan merusak sensor.',
                'Selalu backup driver via DriverBackup sebelum reinstall Windows.',
                'Bersihkan permukaan touchpad dengan kain microfiber lembap — kotoran dapat mengganggu sensor.',
            ],
            'biaya_hint' => 'Ganti modul touchpad: Rp 100.000–250.000 | Ganti kabel fleksibel: Rp 30.000–80.000 | Jasa servis: Rp 100.000',
            'kode'       => 'K006',
        ],

        'touchpad_gerak_sendiri' => [
            'triggers'  => ['kursor gerak sendiri', 'pointer gerak sendiri', 'mouse bergerak sendiri', 'cursor bergerak sendiri', 'touchpad tidak stabil', 'kursor lompat'],
            'judul'     => '🖱️ Kursor / Touchpad Bergerak Sendiri',
            'penyebab'  => [
                'Touchpad terlalu sensitif — telapak tangan menyentuh touchpad tanpa disadari saat mengetik.',
                'Touchpad kotor — sidik jari, minyak, atau debu memengaruhi sensor kapasitif.',
                'Charger tanpa grounding menyebabkan interferensi elektromagnetik ke sensor touchpad.',
                'Driver touchpad yang tidak kompatibel menyebabkan false positive.',
                'Ada objek (sticker, kotoran) yang menempel di permukaan touchpad.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Bersihkan touchpad:** Lap dengan kain microfiber sedikit lembap (air saja, tanpa sabun).',
                '**Langkah 2 – Gunakan grounding:** Coba sambungkan charger ke stopkontak bergrounding (3 lubang).',
                '**Langkah 3 – Kurangi sensitivitas:** Settings → Bluetooth & Devices → Touchpad → kurangi slider sensitivitas.',
                '**Langkah 4 – Palm rejection:** Pastikan fitur "palm check" atau "palm rejection" aktif di pengaturan touchpad.',
                '**Langkah 5 – Hapus sticker:** Jika ada sticker di permukaan touchpad, lepas — bisa mengganggu sensor.',
                '**Langkah 6 – Reinstall driver:** Uninstall driver touchpad di Device Manager, restart (Windows akan install ulang otomatis).',
            ],
            'kapan_servis' => 'Ke teknisi jika setelah charger bergrounding dan driver diinstall ulang, kursor masih bergerak sendiri — kemungkinan sensor touchpad rusak.',
            'pencegahan'   => ['Jaga kebersihan permukaan touchpad.', 'Gunakan charger bergrounding.', 'Aktifkan palm rejection.'],
            'biaya_hint' => 'Ganti modul touchpad: Rp 100.000–250.000',
            'kode'       => 'K006',
        ],

        // ------------------------------------------------------------------ K007 Cooling Fan
        'cooling_panas' => [
            'triggers'  => ['laptop panas', 'overheat', 'suhu tinggi', 'laptop kepanasan', 'bawah laptop panas', 'panas berlebih', 'thermal throttling', 'laptop cepat panas'],
            'judul'     => '🌀 Laptop Overheat / Terlalu Panas',
            'penyebab'  => [
                'Debu tebal menumpuk di ventilasi dan heatsink — ini penyebab #1 overheat laptop berumur > 2 tahun.',
                'Thermal paste (pasta pendingin) antara CPU/GPU dan heatsink sudah mengering dan kehilangan efektivitas.',
                'Kipas pendingin berputar lambat atau mati karena bearing aus atau kabel kipas putus.',
                'Laptop digunakan di atas kasur/bantal yang menutup ventilasi udara.',
                'Ruangan terlalu panas atau laptop digunakan di bawah sinar matahari langsung.',
                'Proses berat (gaming, rendering, mining) yang melebihi kapasitas pendinginan laptop.',
            ],
            'ciri'      => [
                '✔ Kipas berputar sangat kencang terus-menerus bahkan saat idle.',
                '✔ Laptop mati sendiri tiba-tiba saat digunakan untuk tugas berat → thermal shutdown.',
                '✔ Performa turun drastis saat panas (throttling) — CPU dari 2.5GHz turun ke 0.5GHz.',
                '✔ Ventilasi (lubang udara di sisi/bawah) terasa tidak ada hembusan udara → tersumbat debu.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Cek suhu:** Install HWMonitor atau Core Temp — suhu idle normal: CPU 40–55°C, suhu load normal: CPU 70–85°C.',
                '**Langkah 2 – Posisi laptop:** Letakkan di permukaan keras dan rata (meja). Gunakan cooling pad jika perlu.',
                '**Langkah 3 – Bersihkan ventilasi:** Semprot compressed air ke ventilasi — arahkan berlawanan arah aliran normal agar debu keluar.',
                '**Langkah 4 – Buka dan bersihkan (advanced):** Lepas panel bawah, bersihkan heatsink dan kipas dengan kuas halus + blower. Ganti thermal paste CPU/GPU.',
                '**Langkah 5 – Thermal paste:** Hapus pasta lama dengan alkohol isopropil 90%, oleskan pasta baru (Arctic MX-4 atau Thermal Grizzly Kryonaut) setipis lapisan kartu kredit.',
                '**Langkah 6 – Power plan:** Ubah power plan ke "Balanced" atau gunakan throttlestop/undervolting untuk mengurangi panas CPU.',
                '**Langkah 7 – Cooling pad:** Gunakan cooling pad eksternal — efektif mengurangi suhu 5-15°C.',
            ],
            'kapan_servis' => 'Ke teknisi untuk pembersihan heatsink menyeluruh + ganti thermal paste jika tidak berani bongkar sendiri. Disarankan setiap 1-2 tahun.',
            'pencegahan'   => [
                'Bersihkan ventilasi dengan compressed air setiap 3 bulan.',
                'Jangan gunakan laptop di atas kasur, bantal, atau karpet.',
                'Ganti thermal paste setiap 2-3 tahun.',
                'Gunakan cooling pad eksternal untuk penggunaan gaming/berat.',
                'Atur power plan ke "Balanced" — hindari "High Performance" untuk penggunaan biasa.',
            ],
            'biaya_hint' => 'Ganti kipas: Rp 70.000–180.000 | Thermal paste: Rp 30.000–150.000 | Jasa servis (bersih + pasta): Rp 100.000–200.000',
            'kode'       => 'K007',
        ],

        'cooling_kipas_mati' => [
            'triggers'  => ['kipas mati', 'fan mati', 'kipas tidak berputar', 'kipas laptop mati', 'tidak ada angin', 'kipas tidak jalan'],
            'judul'     => '🌀 Kipas Laptop Tidak Berputar',
            'penyebab'  => [
                'Motor kipas sudah aus atau macet karena debu yang sangat padat.',
                'Kabel 3-pin/4-pin kipas putus atau lepas dari konektor di motherboard.',
                'IC fan controller pada motherboard rusak — kipas tidak mendapat sinyal untuk berputar.',
                'Firmware/BIOS yang membuat kipas berputar lambat pada suhu rendah (normal behavior).',
            ],
            'mandiri'   => [
                '**Langkah 1 – Bedakan:** Saat startup, apakah kipas sempat berputar sebentar lalu berhenti? Jika ya → normal untuk laptop modern (fan-stop feature).',
                '**Langkah 2 – Stress test:** Install Prime95 atau jalankan video 4K 10 menit. Jika suhu naik tapi kipas tetap mati → kipas atau sensor rusak.',
                '**Langkah 3 – SpeedFan / HWMonitor:** Pantau fan RPM — jika terbaca 0 RPM saat suhu > 70°C → kipas bermasalah.',
                '**Langkah 4 – Bersihkan:** Buka panel bawah, semprot kipas dengan compressed air untuk membuka macet.',
                '**Langkah 5 – Pelumas:** Jika kipas hanya lambat (masih berputar tapi pelan), lepas stiker belakang hub kipas, teteskan 1-2 tetes pelumas (WD-40 atau pelumas jam).',
            ],
            'kapan_servis' => 'SEGERA ke teknisi jika kipas benar-benar mati dan suhu sudah di atas 90°C — jangan gunakan laptop dalam kondisi ini, risiko kerusakan permanen CPU/GPU.',
            'pencegahan'   => ['Bersihkan kipas rutin setiap 6 bulan.', 'Jangan gunakan laptop dalam kondisi kipas mati.'],
            'biaya_hint' => 'Ganti kipas: Rp 70.000–180.000 | Servis motor kipas: Rp 50.000–100.000',
            'kode'       => 'K007',
        ],

        // ------------------------------------------------------------------ K008 Webcam
        'webcam_mati' => [
            'triggers'  => ['webcam mati', 'kamera tidak terdeteksi', 'webcam tidak berfungsi', 'kamera laptop mati', 'kamera tidak ada', 'webcam error', 'video call tidak bisa', 'zoom tidak bisa kamera'],
            'judul'     => '📷 Webcam Tidak Berfungsi',
            'penyebab'  => [
                'Shutter privasi fisik (penutup geser) sedang tertutup — sering lupa dibuka.',
                'Izin kamera di Windows dinonaktifkan — aplikasi tidak dapat mengakses kamera.',
                'Driver kamera tidak terinstall atau corrupt setelah update Windows.',
                'Kabel fleksibel kamera di dalam engsel layar putus karena terlalu sering dibuka-tutup.',
                'BIOS menonaktifkan kamera (pengaturan keamanan perusahaan/sekolah).',
                'Antivirus atau software privasi memblokir akses kamera.',
            ],
            'ciri'      => [
                '✔ Lampu LED kamera tidak menyala sama sekali → hardware tidak aktif (driver/akses/hardware).',
                '✔ LED menyala tapi gambar hitam → sensor kamera rusak atau kabel fleksibel bermasalah.',
                '✔ Kamera terdeteksi di Device Manager tapi error → driver corrupt.',
                '✔ Kamera tidak muncul di Device Manager → BIOS nonaktif atau kabel putus.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Shutter fisik:** Periksa sisi layar — apakah ada slider penutup kamera? Geser untuk membuka.',
                '**Langkah 2 – Izin Windows:** Settings → Privacy & Security → Camera → ON untuk "Camera access" dan izinkan aplikasi.',
                '**Langkah 3 – Device Manager:** Expand "Cameras" atau "Imaging Devices" → klik kanan → Enable (jika Disabled) atau Update Driver.',
                '**Langkah 4 – Test dengan aplikasi Camera bawaan:** Buka Camera app dari Start — lebih andal untuk tes dasar.',
                '**Langkah 5 – Reinstall driver:** Kunjungi website brand laptop → download driver kamera sesuai model.',
                '**Langkah 6 – Periksa BIOS:** Restart → masuk BIOS (tekan F2/Del/F10) → cari "Camera" → pastikan Enabled.',
                '**Langkah 7 – Cek antivirus:** Tambahkan pengecualian untuk aplikasi yang butuh kamera di setting antivirus.',
            ],
            'kapan_servis' => 'Ke teknisi jika kamera tidak muncul di Device Manager sama sekali meski driver sudah diinstall — kemungkinan kabel fleksibel putus di dalam engsel.',
            'pencegahan'   => [
                'Jangan buka-tutup layar terlalu cepat atau ekstrem.',
                'Gunakan penutup kamera (webcam cover) untuk privasi — pilih yang tipis agar tidak menekan layar.',
                'Update driver kamera secara berkala.',
            ],
            'biaya_hint' => 'Ganti modul webcam internal: Rp 120.000–300.000 | Webcam USB eksternal (alternatif): Rp 80.000–200.000',
            'kode'       => 'K008',
        ],

        // ------------------------------------------------------------------ K009 Baterai
        'baterai_cepat_habis' => [
            'triggers'  => ['baterai cepat habis', 'baterai boros', 'daya tahan baterai pendek', 'baterai tidak tahan lama', 'baterai drop', 'baterai habis cepat'],
            'judul'     => '🔋 Baterai Cepat Habis / Daya Tahan Pendek',
            'penyebab'  => [
                'Kapasitas baterai (Wear Level) sudah turun drastis akibat siklus charge yang banyak — normal setelah 2-3 tahun.',
                'Brightness layar terlalu tinggi — layar adalah konsumen daya terbesar laptop.',
                'Terlalu banyak aplikasi background yang aktif (Bluetooth, WiFi, sinkronisasi cloud).',
                'Baterai mengalami "memory effect" — sering di-charge dari 0% atau dibiarkan di 100% terus.',
                'Sel baterai Li-ion rusak akibat overcharging atau paparan panas berlebihan.',
            ],
            'ciri'      => [
                '✔ Dari 100% habis dalam 1 jam padahal spesifikasi 6+ jam → kapasitas baterai sudah drop > 60%.',
                '✔ Persentase tiba-tiba loncat dari 50% → 20% → mati → baterai kalibrasi salah.',
                '✔ Baterai mengembung (casing laptop terangkat di bagian tertentu) → sel baterai rusak — BERBAHAYA.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Battery Report:** Buka CMD sebagai Admin → ketik: `powercfg /batteryreport` → Buka file HTML di C:\\Users\\[nama]\\battery-report.html. Lihat "Design Capacity" vs "Full Charge Capacity" — jika selisih > 30% → baterai perlu ganti.',
                '**Langkah 2 – Kurangi brightness:** Turunkan brightness ke 50-60% — bisa menghemat hingga 30% daya.',
                '**Langkah 3 – Battery Saver mode:** Settings → System → Power & Battery → aktifkan Battery Saver.',
                '**Langkah 4 – Matikan fitur boros daya:** Bluetooth, WiFi (jika tidak dipakai), sinkronisasi cloud real-time.',
                '**Langkah 5 – Kalibrasi baterai:** Charge ke 100% → gunakan sampai 5-10% tanpa charger → charge kembali ke 100% → lakukan 2-3 kali.',
                '**Langkah 6 – Atur charge limit:** Beberapa laptop (ASUS, Lenovo) punya fitur "Battery Care Mode" — batasi charge di 80% untuk memperpanjang umur baterai.',
            ],
            'kapan_servis' => 'Ganti baterai jika: Full Charge Capacity < 50% dari Design Capacity, atau baterai mengembung (jangan tunda ini — risiko terbakar).',
            'pencegahan'   => [
                'Jaga baterai di kisaran 20-80% — hindari selalu 0% atau 100%.',
                'Jangan biarkan laptop kepanasan saat di-charge.',
                'Gunakan fitur Battery Care / Charge Limit jika tersedia.',
                'Cabut charger jika sudah 100% (untuk laptop tanpa battery care).',
            ],
            'biaya_hint' => 'Baterai original baru: Rp 350.000–850.000 | Baterai kompatibel: Rp 200.000–400.000',
            'kode'       => 'K009',
        ],

        'baterai_tidak_ngecas' => [
            'triggers'  => ['baterai tidak mengisi', 'baterai tidak mau ngecas', 'plugged in not charging', 'baterai silang', 'led baterai mati', 'baterai tidak terdeteksi', 'no battery', 'baterai 0 tidak ngecas'],
            'judul'     => '🔋 Baterai Tidak Mau Mengisi Daya',
            'penyebab'  => [
                'Driver baterai ACPI corrupt — Windows tidak mau menerima muatan meski charger berfungsi.',
                'IC BQ charging chip pada motherboard rusak.',
                'Baterai sudah benar-benar mati total (voltase di bawah threshold minimum untuk diisi).',
                'Charger tidak memberikan tegangan yang cukup — pastikan watt charger sesuai.',
                'Port charging (DC jack atau USB-C PD) longgar atau kotor.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Reset driver baterai:** Device Manager → Batteries → klik kanan "Microsoft ACPI-Compliant Control Method Battery" → Uninstall Device → Restart. Windows akan reinstall otomatis.',
                '**Langkah 2 – Uji charger:** Coba charger berbeda dengan watt yang sama. Jika berhasil → charger kamu bermasalah.',
                '**Langkah 3 – Lepas baterai (jika bisa):** Jalankan hanya dengan charger. Jika bisa nyala → baterai mati total.',
                '**Langkah 4 – Reseat baterai:** Matikan laptop, lepas dan pasang kembali baterai (untuk baterai model lama yang bisa dilepas) — pastikan kontak bersih.',
                '**Langkah 5 – Update BIOS:** Cek website brand untuk update BIOS terbaru — kadang update BIOS memperbaiki masalah charging.',
                '**Langkah 6 – Charge semalaman:** Untuk baterai yang habis total, colok charger dan biarkan 8-12 jam tanpa dinyalakan.',
            ],
            'kapan_servis' => 'Ke teknisi jika: laptop tidak bisa nyala tanpa baterai padahal charger berfungsi, atau IC charging di motherboard perlu diganti.',
            'pencegahan'   => ['Gunakan charger original dengan watt yang sesuai.', 'Jangan biarkan baterai kosong total dalam waktu lama.'],
            'biaya_hint' => 'Ganti baterai: Rp 350.000–850.000 | Servis IC charging: Rp 150.000–400.000',
            'kode'       => 'K009',
        ],

        // ------------------------------------------------------------------ K010 Motherboard
        'mobo_mati_total' => [
            'triggers'  => ['laptop tidak menyala', 'laptop mati total', 'laptop tidak bisa nyala', 'tidak ada tanda-tanda', 'tombol power tidak berfungsi', 'power on off tidak berfungsi', 'tidak ada respon'],
            'judul'     => '🔧 Laptop Mati Total / Tidak Bisa Menyala',
            'penyebab'  => [
                'IC power (MOSFET power switch) pada motherboard rusak — arus tidak mengalir saat tombol power ditekan.',
                'Baterai habis total dan charger tidak berfungsi secara bersamaan.',
                'Laptop terkena air/cairan yang menyebabkan korsleting pada motherboard.',
                'Kapasitor pada jalur power VRM (Voltage Regulator Module) bocor atau meledak.',
                'BIOS corrupt sehingga tidak dapat melakukan POST (Power-On Self-Test).',
                'Fuse (sekring) internal laptop putus akibat lonjakan tegangan.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Power drain:** Lepas baterai dan charger → tahan tombol Power 30–60 detik → pasang charger saja (tanpa baterai) → coba nyalakan.',
                '**Langkah 2 – Verifikasi charger:** Pastikan LED charger menyala (indikator charger berfungsi).',
                '**Langkah 3 – Lepas RAM:** Coba nyalakan tanpa RAM — jika ada bunyi beep, artinya motherboard masih hidup.',
                '**Langkah 4 – Periksa layar:** Sambungkan monitor eksternal — mungkin laptop menyala tapi layarnya yang mati.',
                '**Langkah 5 – Jika terkena air:** JANGAN nyalakan! Lepas baterai, keringkan dengan silica gel 48–72 jam, bawa ke teknisi.',
                '**Langkah 6 – Cek bunyi beep:** Hitung pola bunyi beep untuk kode error POST (berbeda tiap BIOS vendor).',
            ],
            'kapan_servis' => 'Segera ke teknisi jika tidak ada tanda kehidupan sama sekali (no power, no beep, no LED) — diagnosis motherboard memerlukan alat khusus (multimeter, oscilloscope).',
            'pencegahan'   => [
                'Gunakan UPS/stabilizer untuk melindungi dari lonjakan tegangan.',
                'Jauhkan cairan dari laptop.',
                'Jangan gunakan charger non-original yang murah — bisa merusak IC power.',
            ],
            'biaya_hint' => 'Servis IC power: Rp 150.000–350.000 | Ganti motherboard: Rp 500.000–1.800.000 | Catatan: servis mobo lebih hemat dari ganti baru jika komponen lain masih baik.',
            'kode'       => 'K010',
        ],

        'mobo_restart' => [
            'triggers'  => ['laptop restart sendiri', 'mati sendiri', 'shutdown sendiri', 'laptop mati tiba-tiba', 'restart tiba-tiba tanpa sebab', 'tampilan hilang tiba-tiba'],
            'judul'     => '🔧 Laptop Restart / Mati Sendiri Tiba-Tiba',
            'penyebab'  => [
                'Thermal shutdown — CPU/GPU terlalu panas melebihi ambang batas keamanan.',
                'IC power VRM tidak stabil, menyebabkan tegangan ke CPU drop tiba-tiba.',
                'RAM atau HDD mengalami kerusakan yang menyebabkan BSOD yang tertutup (no dump).',
                'Malware/virus yang memprogram shutdown otomatis.',
                'Driver yang bermasalah menyebabkan kernel panic dan restart.',
                'Pengaturan Windows "Automatically restart on system failure" aktif sehingga BSOD tidak terlihat.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Lihat BSOD:** Start → Settings → System → About → Advanced system settings → Advanced → Startup and Recovery → unceklis "Automatically restart" agar bisa membaca error BSOD.',
                '**Langkah 2 – Cek suhu:** Install HWMonitor — pantau suhu saat laptop mati. Jika > 90°C → overheat.',
                '**Langkah 3 – Event Viewer:** Start → Event Viewer → Windows Logs → System → Filter "Critical" — catat error sebelum restart terjadi.',
                '**Langkah 4 – Scan malware:** Full scan dengan Windows Defender atau Malwarebytes.',
                '**Langkah 5 – Update driver:** Terutama driver chipset, VGA, dan network.',
                '**Langkah 6 – Test RAM dan HDD:** Jalankan Memory Diagnostic dan CrystalDiskInfo untuk menyingkirkan kemungkinan hardware rusak.',
            ],
            'kapan_servis' => 'Ke teknisi jika restart terjadi bahkan di BIOS (sebelum OS load) — menunjukkan masalah hardware serius seperti VRM atau kapasitor motherboard.',
            'pencegahan'   => ['Jaga laptop tetap dingin.', 'Update driver dan Windows secara berkala.', 'Scan malware rutin.'],
            'biaya_hint' => 'Servis VRM/kapasitor: Rp 150.000–400.000 | Ganti motherboard (jika parah): Rp 500.000–1.800.000',
            'kode'       => 'K010',
        ],

        // ------------------------------------------------------------------ K011 Speaker
        'speaker_mati' => [
            'triggers'  => ['tidak ada suara', 'speaker mati', 'audio mati', 'sound tidak keluar', 'volume tidak ada suara', 'suara hilang', 'laptop bisu', 'tidak ada bunyi'],
            'judul'     => '🔊 Tidak Ada Suara dari Speaker',
            'penyebab'  => [
                'Volume di-mute (disengaja atau tidak — tombol mute sering tertekan).',
                'Output audio salah — Windows mengirim audio ke HDMI atau headphone padahal tidak terpasang.',
                'Driver Realtek HD Audio atau driver audio lainnya corrupt atau tidak terinstall.',
                'Windows Update yang menghapus/mengupdate driver audio secara tidak kompatibel.',
                'Kabel speaker internal putus atau konektor lepas dari motherboard.',
                'IC audio codec (Realtek chip) pada motherboard rusak.',
            ],
            'ciri'      => [
                '✔ Audio berfungsi via headphone tapi tidak dari speaker → speaker fisik rusak atau konektor lepas.',
                '✔ Tidak ada suara dari keduanya (speaker + headphone) → driver audio atau IC audio bermasalah.',
                '✔ Volume mixer tampil tapi tidak ada suara → output device salah.',
                '✔ Audio berfungsi di Safe Mode tapi tidak di normal mode → konflik driver.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Cek mute & volume:** Klik ikon speaker di taskbar — pastikan tidak di-mute dan volume > 50%.',
                '**Langkah 2 – Output device:** Klik kanan ikon speaker → Sound settings → Output → pilih "Speakers" (bukan HDMI atau Headphones).',
                '**Langkah 3 – Playback devices:** Klik kanan speaker taskbar → Sounds → tab Playback → klik kanan Speaker → Set as Default Device.',
                '**Langkah 4 – Audio Troubleshooter:** Settings → System → Sound → Troubleshoot (akan auto-fix masalah umum).',
                '**Langkah 5 – Update/Rollback driver:** Device Manager → Sound → klik kanan Realtek HD Audio → Update Driver atau Roll Back Driver.',
                '**Langkah 6 – Reinstall driver audio:** Download driver audio terbaru dari website brand laptop, uninstall yang lama dulu lalu install baru.',
                '**Langkah 7 – Uji dengan headphone:** Colok headphone — jika ada suara, masalah di speaker fisik.',
            ],
            'kapan_servis' => 'Ke teknisi jika headphone juga tidak ada suara setelah driver diinstall ulang — kemungkinan IC audio pada motherboard rusak.',
            'pencegahan'   => [
                'Jangan putar volume 100% terus-menerus — merusak membran speaker.',
                'Update driver audio secara berkala.',
                'Gunakan equalizer untuk menghindari frekuensi yang merusak speaker kecil.',
            ],
            'biaya_hint' => 'Ganti speaker internal: Rp 75.000–180.000 | Servis IC audio: Rp 100.000–250.000',
            'kode'       => 'K011',
        ],

        'speaker_pecah' => [
            'triggers'  => ['suara pecah', 'suara serak', 'suara kemresek', 'suara distorsi', 'suara bergema', 'speaker berbunyi aneh', 'suara lebih kecil', 'volume kecil meski maksimal'],
            'judul'     => '🔊 Suara Speaker Pecah / Distorsi',
            'penyebab'  => [
                'Membran speaker robek atau rusak akibat terlalu sering diputar di volume maksimal.',
                'Cairan masuk ke dalam speaker dan menggeser atau merusak membran.',
                'Kotoran (debu, serpihan) yang masuk ke dalam lubang speaker mengganggu getaran membran.',
                'Koneksi kabel speaker longgar menyebabkan suara "crackling" atau "popping".',
                'IC amplifier audio kelebihan beban atau mulai rusak.',
            ],
            'mandiri'   => [
                '**Langkah 1 – Tes volume:** Coba di volume 30-50% — jika suara normal di volume rendah tapi pecah di tinggi → membran rusak atau amplifier overload.',
                '**Langkah 2 – Uji dengan headphone:** Jika headphone suaranya jernih → masalah di speaker fisik, bukan driver/audio card.',
                '**Langkah 3 – Bersihkan lubang speaker:** Gunakan sikat gigi lembut untuk menyikat lubang speaker dari debu dan kotoran.',
                '**Langkah 4 – Equalizer:** Kurangi frekuensi bass di equalizer — bass berlebihan paling sering merusak speaker kecil laptop.',
                '**Langkah 5 – Cek koneksi:** Buka panel bawah, pastikan konektor kabel speaker ke motherboard kencang.',
                '**Langkah 6 – Update driver:** Pastikan driver Realtek terbaru terinstall — driver lama terkadang menyebabkan audio processing yang tidak optimal.',
            ],
            'kapan_servis' => 'Ke teknisi untuk ganti speaker jika suara pecah di semua level volume dan headphone masih jernih.',
            'pencegahan'   => [
                'Jangan putar musik/video di volume 90-100% dalam waktu lama.',
                'Hindari penggunaan bass booster ekstrem.',
                'Jauhkan laptop dari cairan.',
            ],
            'biaya_hint' => 'Ganti set speaker: Rp 75.000–180.000 | Servis jasa: Rp 100.000',
            'kode'       => 'K011',
        ],
    ];

    // =========================================================================
    // PERTANYAAN SPESIFIK YANG SERING DIAJUKAN (FAQ)
    // =========================================================================
    private array $faqPatterns = [
        'berapa biaya' => [
            'triggers' => ['berapa biaya', 'berapa harga', 'berapa ongkos', 'estimasi biaya', 'biaya servis', 'harga servis'],
            'handler'  => 'faqBiaya',
        ],
        'cara cek suhu' => [
            'triggers' => ['cara cek suhu', 'cek temperatur', 'suhu laptop berapa', 'lihat suhu', 'temperature laptop'],
            'handler'  => 'faqCekSuhu',
        ],
        'backup data' => [
            'triggers' => ['cara backup', 'backup data', 'selamatkan data', 'data aman'],
            'handler'  => 'faqBackup',
        ],
        'cara reset' => [
            'triggers' => ['cara reset', 'factory reset', 'reset laptop', 'install ulang windows', 'reinstall windows'],
            'handler'  => 'faqReset',
        ],
        'laptop kena air' => [
            'triggers' => ['kena air', 'laptop kena air', 'laptop basah', 'air tumpah', 'kena cairan', 'laptop terendam'],
            'handler'  => 'faqKenaAir',
        ],
        'laptop tua' => [
            'triggers' => ['laptop tua', 'laptop lama', 'laptop lambat karena tua', 'laptop sudah tua', 'upgrade laptop'],
            'handler'  => 'faqLaptopTua',
        ],
    ];

    // =========================================================================
    // KEYWORD MAP untuk matching cepat ke knowledgeBase key
    // =========================================================================
    private array $keywordIndex = [
        // LCD
        'layar gelap' => 'lcd_gelap', 'layar hitam' => 'lcd_gelap', 'layar tidak nyala' => 'lcd_gelap',
        'screen gelap' => 'lcd_gelap', 'blank screen' => 'lcd_gelap', 'layar mati' => 'lcd_gelap',
        'garis layar' => 'lcd_garis', 'layar bergaris' => 'lcd_garis', 'garis vertikal' => 'lcd_garis',
        'garis horizontal' => 'lcd_garis', 'blok hitam' => 'lcd_garis', 'gambar acak' => 'lcd_garis',
        'layar putih' => 'lcd_blank_putih', 'blank putih' => 'lcd_blank_putih', 'white screen' => 'lcd_blank_putih',
        // Keyboard
        'keyboard tidak berfungsi' => 'keyboard_mati', 'tombol keyboard' => 'keyboard_mati',
        'keyboard mati' => 'keyboard_mati', 'keyboard rusak' => 'keyboard_mati',
        'huruf muncul sendiri' => 'keyboard_sendiri', 'keyboard mengetik sendiri' => 'keyboard_sendiri',
        'tombol menekan sendiri' => 'keyboard_sendiri',
        // RAM
        'ram bermasalah' => 'ram_masalah', 'memory error' => 'ram_masalah', 'ram rusak' => 'ram_masalah',
        'laptop hang' => 'ram_hang', 'laptop freeze' => 'ram_hang', 'aplikasi hang' => 'ram_hang',
        // Charger
        'charger tidak mengisi' => 'charger_tidak_ngecas', 'tidak bisa cas' => 'charger_tidak_ngecas',
        'cas mati' => 'charger_tidak_ngecas', 'charger mati' => 'charger_tidak_ngecas',
        'nyetrum' => 'charger_nyetrum', 'laptop nyetrum' => 'charger_nyetrum', 'setrum' => 'charger_nyetrum',
        // HDD
        'laptop lambat' => 'hdd_lambat', 'booting lama' => 'hdd_lambat', 'loading lama' => 'hdd_lambat',
        'laptop lemot' => 'hdd_lambat', 'windows lambat' => 'hdd_lambat',
        'blue screen' => 'hdd_bluescreen', 'bluescreen' => 'hdd_bluescreen', 'bsod' => 'hdd_bluescreen',
        'restart sendiri' => 'hdd_bluescreen',
        'harddisk bunyi' => 'hdd_bunyi', 'bunyi klik' => 'hdd_bunyi', 'suara klik laptop' => 'hdd_bunyi',
        'disk bunyi' => 'hdd_bunyi',
        // Touchpad
        'touchpad mati' => 'touchpad_mati', 'touchpad tidak berfungsi' => 'touchpad_mati',
        'pointer tidak bergerak' => 'touchpad_mati', 'kursor tidak bergerak' => 'touchpad_mati',
        'kursor gerak sendiri' => 'touchpad_gerak_sendiri', 'pointer gerak sendiri' => 'touchpad_gerak_sendiri',
        'mouse bergerak sendiri' => 'touchpad_gerak_sendiri',
        // Cooling
        'laptop panas' => 'cooling_panas', 'overheat' => 'cooling_panas', 'suhu tinggi' => 'cooling_panas',
        'laptop kepanasan' => 'cooling_panas', 'bawah laptop panas' => 'cooling_panas',
        'kipas mati' => 'cooling_kipas_mati', 'fan mati' => 'cooling_kipas_mati',
        'kipas tidak berputar' => 'cooling_kipas_mati',
        // Webcam
        'webcam mati' => 'webcam_mati', 'kamera tidak terdeteksi' => 'webcam_mati',
        'webcam tidak berfungsi' => 'webcam_mati', 'kamera laptop mati' => 'webcam_mati',
        // Baterai
        'baterai cepat habis' => 'baterai_cepat_habis', 'baterai boros' => 'baterai_cepat_habis',
        'baterai drop' => 'baterai_cepat_habis',
        'baterai tidak mengisi' => 'baterai_tidak_ngecas', 'baterai silang' => 'baterai_tidak_ngecas',
        'tidak charging' => 'baterai_tidak_ngecas', 'plugged in not charging' => 'baterai_tidak_ngecas',
        // Motherboard
        'laptop tidak menyala' => 'mobo_mati_total', 'laptop mati total' => 'mobo_mati_total',
        'tombol power tidak berfungsi' => 'mobo_mati_total', 'tidak ada respon' => 'mobo_mati_total',
        'laptop mati tiba-tiba' => 'mobo_restart', 'shutdown sendiri' => 'mobo_restart',
        'mati sendiri' => 'mobo_restart',
        // Speaker
        'tidak ada suara' => 'speaker_mati', 'speaker mati' => 'speaker_mati',
        'suara hilang' => 'speaker_mati', 'audio mati' => 'speaker_mati',
        'suara pecah' => 'speaker_pecah', 'suara serak' => 'speaker_pecah',
        'suara kemresek' => 'speaker_pecah', 'suara distorsi' => 'speaker_pecah',
        'suara lebih kecil' => 'speaker_pecah',
    ];

    // =========================================================================
    // ENDPOINT UTAMA
    // =========================================================================
    public function reply(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);

        $raw     = $request->input('message');
        $message = strtolower(trim($raw));

        // 1) Sapaan
        if ($this->matchesAny($message, ['halo', 'hai', 'hi ', 'hello', 'hey ', 'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam', 'assalamualaikum', 'permisi', 'p agi'])) {
            return $this->jsonReply($this->buildGreeting(), 'greeting', $this->topicButtons());
        }

        // 2) Terima kasih
        if ($this->matchesAny($message, ['terima kasih', 'makasih', 'thanks', 'thank you', 'thx'])) {
            return $this->jsonReply(
                "Sama-sama! 😊 Senang bisa membantu. Jika ada pertanyaan lain atau butuh penjelasan lebih lanjut, jangan ragu untuk tanya lagi!",
                'thanks',
                $this->quickMenuButtons()
            );
        }

        // 3) FAQ spesifik
        foreach ($this->faqPatterns as $faqData) {
            if ($this->matchesAny($message, $faqData['triggers'])) {
                $handler = $faqData['handler'];
                return $this->$handler();
            }
        }

        // 4) Diagnosa / periksa
        if ($this->matchesAny($message, ['diagnosa', 'cek laptop', 'ingin diperiksa', 'minta diagnosa', 'periksa laptop'])) {
            return $this->jsonReply(
                "Untuk diagnosa akurat, gunakan fitur **Diagnosa** sistem pakar kami! 🔍\n\n"
                . "Sistem menggunakan metode **Forward Chaining + Certainty Factor** yang akan:\n"
                . "1. Meminta kamu memilih gejala-gejala yang dialami\n"
                . "2. Mencocokkan dengan basis pengetahuan 11 jenis kerusakan\n"
                . "3. Memberikan hasil dengan **tingkat keyakinan (%)** untuk tiap kemungkinan\n"
                . "4. Menampilkan estimasi biaya dan langkah perbaikan\n\n"
                . "_Chatbot saya juga bisa menjawab pertanyaan spesifik — coba ceritakan gejala laptopmu!_",
                'info',
                [
                    ['label' => '🔍 Mulai Diagnosa Sekarang', 'action' => 'link', 'url' => '/diagnosa'],
                    ['label' => '📋 Tanya Gejala Spesifik',   'action' => 'send', 'text' => 'bantuan'],
                ]
            );
        }

        // 5) Bantuan / help
        if ($this->matchesAny($message, ['bantuan', 'help', 'apa yang bisa', 'bisa apa', 'topik', 'menu'])) {
            return $this->jsonReply($this->buildHelpMessage(), 'help', $this->topicButtons());
        }

        // 6) Cari di knowledge base
        $kbKey = $this->findKnowledgeBase($message);
        if ($kbKey && isset($this->knowledgeBase[$kbKey])) {
            return $this->jsonReply(
                $this->buildDetailedResponse($this->knowledgeBase[$kbKey]),
                'detailed_info',
                $this->buildDetailButtons()
            );
        }

        // 7) Fuzzy fallback — coba cocokkan per-kata
        $fuzzyKey = $this->fuzzyMatch($message);
        if ($fuzzyKey && isset($this->knowledgeBase[$fuzzyKey])) {
            return $this->jsonReply(
                "_Sepertinya kamu menanyakan tentang:_\n\n" .
                $this->buildDetailedResponse($this->knowledgeBase[$fuzzyKey]),
                'detailed_info',
                $this->buildDetailButtons()
            );
        }

        // 8) Tidak dikenali
        return $this->jsonReply($this->buildUnknownResponse($raw), 'unknown', $this->buildAdminButtons());
    }

    // =========================================================================
    // BUILDER: Respons Detail Mendalam
    // =========================================================================
    private function buildDetailedResponse(array $kb): string
    {
        $out = "**{$kb['judul']}**\n\n";

        // Penyebab
        $out .= "**🔍 Kemungkinan Penyebab:**\n";
        foreach ($kb['penyebab'] as $i => $p) {
            $out .= ($i + 1) . ". {$p}\n";
        }

        // Ciri khas (jika ada)
        if (!empty($kb['ciri'])) {
            $out .= "\n**🔎 Cara Mengidentifikasi:**\n";
            foreach ($kb['ciri'] as $c) {
                $out .= "{$c}\n";
            }
        }

        // Langkah mandiri
        $out .= "\n**🛠️ Langkah Penanganan Mandiri:**\n";
        foreach ($kb['mandiri'] as $step) {
            $out .= "• {$step}\n";
        }

        // Kapan servis
        $out .= "\n**⚠️ Kapan Harus ke Teknisi?**\n";
        $out .= "_" . $kb['kapan_servis'] . "_\n";

        // Pencegahan
        $out .= "\n**🛡️ Tips Pencegahan:**\n";
        foreach ($kb['pencegahan'] as $p) {
            $out .= "• {$p}\n";
        }

        // Biaya
        $out .= "\n**💰 Estimasi Biaya:**\n";
        $out .= $kb['biaya_hint'];

        return $out;
    }

    // =========================================================================
    // FAQ HANDLERS
    // =========================================================================
    private function faqBiaya(): \Illuminate\Http\JsonResponse
    {
        $kerusakanList = Kerusakan::orderBy('kode')->get();
        $msg = "**💰 Estimasi Biaya Servis Laptop (Referensi)**\n\n";
        foreach ($kerusakanList as $k) {
            $min = number_format($k->est_part_min, 0, ',', '.');
            $max = number_format($k->est_part_max, 0, ',', '.');
            $fee = $k->service_fee > 0 ? " + jasa Rp " . number_format($k->service_fee, 0, ',', '.') : '';
            $msg .= "**{$k->icon} {$k->nama}:** Rp {$min} – {$max}{$fee}\n";
        }
        $msg .= "\n_⚠️ Harga dapat berbeda tergantung merek laptop, wilayah, dan kondisi kerusakan. Konsultasikan ke teknisi untuk estimasi akurat._";
        return $this->jsonReply($msg, 'biaya', $this->buildDetailButtons());
    }

    private function faqCekSuhu(): \Illuminate\Http\JsonResponse
    {
        $msg = "**🌡️ Cara Cek Suhu Laptop**\n\n"
             . "**Tool yang direkomendasikan (gratis):**\n"
             . "• **HWMonitor** (hwmonitor.com) — monitoring real-time CPU, GPU, HDD temp\n"
             . "• **Core Temp** — fokus pada suhu per-core CPU\n"
             . "• **SpeedFan** — bisa kontrol kecepatan kipas juga\n"
             . "• **MSI Afterburner** — cocok untuk laptop gaming\n\n"
             . "**📊 Batas Suhu Normal:**\n"
             . "• Idle (tidak ada aktivitas): CPU 35–55°C, GPU 40–60°C\n"
             . "• Beban ringan (browsing, dokumen): CPU 50–70°C\n"
             . "• Beban berat (gaming, rendering): CPU 70–85°C, GPU 70–85°C\n"
             . "• **BAHAYA:** CPU/GPU > 95°C — thermal shutdown akan terjadi!\n\n"
             . "**🚨 Jika suhu selalu > 85°C saat idle** → segera bersihkan kipas dan ganti thermal paste.";
        return $this->jsonReply($msg, 'info', [
            ['label' => '🌀 Info Masalah Panas',   'action' => 'send', 'text' => 'laptop panas overheat'],
            ['label' => '💬 Tanya Admin',           'action' => 'admin'],
        ]);
    }

    private function faqBackup(): \Illuminate\Http\JsonResponse
    {
        $msg = "**💾 Cara Backup Data Laptop**\n\n"
             . "**Metode 1 — Cloud (Mudah):**\n"
             . "• **Google Drive** (15GB gratis) — instal aplikasi, sinkronisasi otomatis\n"
             . "• **OneDrive** (5GB gratis, sudah built-in Windows) — Settings → OneDrive\n"
             . "• **Dropbox** — cocok untuk kolaborasi file\n\n"
             . "**Metode 2 — Hard Disk Eksternal (Paling Aman):**\n"
             . "• Hubungkan HDD/SSD eksternal → salin folder penting (Documents, Pictures, Desktop)\n"
             . "• Gunakan Windows Backup: Settings → Update & Security → Backup → Add a Drive\n\n"
             . "**Metode 3 — Windows Backup & Restore:**\n"
             . "• Control Panel → Backup and Restore (Windows 7) → Set up backup\n"
             . "• Buat System Image untuk backup penuh (termasuk Windows)\n\n"
             . "**⚡ PRIORITAS BACKUP (jika laptop bermasalah):**\n"
             . "1. Folder Documents, Downloads, Desktop\n"
             . "2. Foto & video penting\n"
             . "3. Data kerja/kuliah\n"
             . "4. Password manager atau file penting lainnya\n\n"
             . "_Aturan **3-2-1**: 3 salinan data, di 2 media berbeda, 1 di luar lokasi (cloud)._";
        return $this->jsonReply($msg, 'info', $this->buildDetailButtons());
    }

    private function faqReset(): \Illuminate\Http\JsonResponse
    {
        $msg = "**🔄 Cara Reset / Reinstall Windows Laptop**\n\n"
             . "**Opsi 1 — Reset via Windows (Tanpa USB, Mudah):**\n"
             . "1. Settings → System → Recovery → Reset this PC\n"
             . "2. Pilih 'Keep my files' (data aman) atau 'Remove everything' (bersih total)\n"
             . "3. Ikuti instruksi — proses ±1-2 jam\n\n"
             . "**Opsi 2 — Reinstall via USB Bootable:**\n"
             . "1. Buat USB bootable Windows 10/11 menggunakan **Media Creation Tool** (download gratis dari microsoft.com)\n"
             . "2. Masuk BIOS (F2/Del/F10 saat startup) → atur boot dari USB\n"
             . "3. Ikuti wizard instalasi Windows\n\n"
             . "**⚠️ SEBELUM RESET — WAJIB BACKUP:**\n"
             . "• Salin semua data ke cloud atau HDD eksternal\n"
             . "• Catat software yang terinstall (untuk reinstall)\n"
             . "• Catat lisensi software berbayar\n"
             . "• Backup driver via DriverBackup atau Double Driver\n\n"
             . "**Kapan perlu reinstall?** Virus parah, Windows corrupt, laptop sangat lambat meski sudah dibersihkan.";
        return $this->jsonReply($msg, 'info', $this->buildDetailButtons());
    }

    private function faqKenaAir(): \Illuminate\Http\JsonResponse
    {
        $msg = "**💧 Laptop Kena Air / Cairan — Panduan Darurat!**\n\n"
             . "**🚨 LAKUKAN SEGERA (urutan penting!):**\n"
             . "1. **JANGAN PANIK** — jangan langsung nyalakan untuk 'tes' apakah masih hidup!\n"
             . "2. **Matikan segera** — tahan tombol Power sampai mati paksa\n"
             . "3. **Cabut charger** dari stopkontak\n"
             . "4. **Lepas baterai** (jika bisa dilepas dari luar)\n"
             . "5. **Balikkan laptop** — posisi keyboard menghadap bawah agar cairan mengalir keluar\n"
             . "6. **Lap cairan** di permukaan dengan kain kering\n"
             . "7. **Jangan gunakan hairdryer panas** — suhu tinggi merusak komponen\n\n"
             . "**Setelah cairan dikuras:**\n"
             . "• Biarkan kering di udara (kipas angin ruangan) minimal **48-72 jam**\n"
             . "• Tempatkan di wadah tertutup berisi silica gel (penyerap kelembaban)\n"
             . "• Jangan nyalakan sebelum YAKIN benar-benar kering\n\n"
             . "**🔧 Langkah Profesional:**\n"
             . "• Bawa ke teknisi untuk dibersihkan dengan **alkohol isopropil 90%+** (melarutkan mineral dari air)\n"
             . "• Minta teknisi bersihkan PCB dengan ultrasonic cleaner jika tersedia\n\n"
             . "**Peluang selamat?** Jika air bersih + dimatikan cepat + dikeringkan benar: 70-80%. Air minuman manis/kopi: lebih rendah karena meninggalkan residu gula yang korosif.";
        return $this->jsonReply($msg, 'warning', [
            ['label' => '🔧 Masalah Motherboard', 'action' => 'send', 'text' => 'laptop tidak menyala'],
            ['label' => '💬 Hubungi Admin Segera', 'action' => 'admin'],
        ]);
    }

    private function faqLaptopTua(): \Illuminate\Http\JsonResponse
    {
        $msg = "**🖥️ Tips Upgrade Laptop Lama agar Tetap Kencang**\n\n"
             . "**Upgrade terbaik dengan biaya efisien:**\n\n"
             . "**1. 💾 Ganti ke SSD** ← dampak terbesar!\n"
             . "• Booting dari 2-3 menit → 15-20 detik\n"
             . "• Buka aplikasi 3-5x lebih cepat\n"
             . "• Biaya: Rp 300.000–700.000 (sudah termasuk kloning data)\n\n"
             . "**2. 🧠 Tambah RAM**\n"
             . "• 4GB → 8GB: perbedaan drastis untuk multitasking\n"
             . "• 8GB → 16GB: untuk kerja kreatif/developer\n"
             . "• Biaya: Rp 250.000–850.000\n\n"
             . "**3. 🔋 Ganti Baterai**\n"
             . "• Baterai baru = mobilitas kembali maksimal\n"
             . "• Biaya: Rp 350.000–850.000\n\n"
             . "**4. 🌀 Servis Thermal (Cleaning + Pasta)**\n"
             . "• Performa kembali optimal karena tidak throttling\n"
             . "• Biaya: Rp 100.000–200.000\n\n"
             . "**5. 🔄 Reinstall Windows + Optimasi**\n"
             . "• Hapus bloatware, atur startup, defrag (HDD)\n"
             . "• Bisa dilakukan sendiri atau bayar jasa Rp 100.000\n\n"
             . "**💡 Rekomendasi urutan:** SSD dulu → RAM → Thermal service → Baterai.";
        return $this->jsonReply($msg, 'info', [
            ['label' => '💾 Info Upgrade SSD',    'action' => 'send', 'text' => 'laptop lambat booting lama'],
            ['label' => '🧠 Info Tambah RAM',     'action' => 'send', 'text' => 'masalah ram memory'],
            ['label' => '💰 Lihat Semua Biaya',   'action' => 'send', 'text' => 'berapa biaya servis'],
        ]);
    }

    // =========================================================================
    // MATCHING HELPERS
    // =========================================================================
    private function findKnowledgeBase(string $message): ?string
    {
        // Cari di index dengan frase terpanjang dulu (prioritas lebih spesifik)
        $found = [];
        foreach ($this->keywordIndex as $phrase => $kbKey) {
            if (str_contains($message, $phrase)) {
                $found[$kbKey] = ($found[$kbKey] ?? 0) + strlen($phrase);
            }
        }
        if (!empty($found)) {
            arsort($found);
            return array_key_first($found);
        }

        // Cari di triggers masing-masing knowledge base
        foreach ($this->knowledgeBase as $key => $kb) {
            foreach ($kb['triggers'] as $trigger) {
                if (str_contains($message, $trigger)) {
                    return $key;
                }
            }
        }

        return null;
    }

    private function fuzzyMatch(string $message): ?string
    {
        // Daftar kata kunci tunggal sederhana dengan bobot
        $singleKeywords = [
            'layar' => 'lcd_gelap', 'monitor' => 'lcd_gelap', 'lcd' => 'lcd_gelap',
            'screen' => 'lcd_gelap', 'display' => 'lcd_gelap',
            'keyboard' => 'keyboard_mati', 'tombol' => 'keyboard_mati', 'ketik' => 'keyboard_mati',
            'ram' => 'ram_masalah', 'memori' => 'ram_masalah', 'memory' => 'ram_masalah',
            'charger' => 'charger_tidak_ngecas', 'cas' => 'charger_tidak_ngecas', 'adaptor' => 'charger_tidak_ngecas',
            'harddisk' => 'hdd_lambat', 'hardisk' => 'hdd_lambat', 'hdd' => 'hdd_lambat',
            'ssd' => 'hdd_lambat', 'disk' => 'hdd_lambat', 'storage' => 'hdd_lambat',
            'touchpad' => 'touchpad_mati', 'mouse' => 'touchpad_mati', 'pointer' => 'touchpad_mati',
            'panas' => 'cooling_panas', 'kipas' => 'cooling_panas', 'fan' => 'cooling_panas',
            'overheat' => 'cooling_panas', 'thermal' => 'cooling_panas',
            'webcam' => 'webcam_mati', 'kamera' => 'webcam_mati', 'camera' => 'webcam_mati',
            'baterai' => 'baterai_cepat_habis', 'battery' => 'baterai_cepat_habis', 'batere' => 'baterai_cepat_habis',
            'motherboard' => 'mobo_mati_total', 'mainboard' => 'mobo_mati_total', 'mobo' => 'mobo_mati_total',
            'speaker' => 'speaker_mati', 'suara' => 'speaker_mati', 'audio' => 'speaker_mati', 'sound' => 'speaker_mati',
            'lambat' => 'hdd_lambat', 'lemot' => 'hdd_lambat', 'lelet' => 'hdd_lambat',
            'hang' => 'ram_hang', 'freeze' => 'ram_hang',
            'biru' => 'hdd_bluescreen', 'crash' => 'hdd_bluescreen',
            'nyetrum' => 'charger_nyetrum', 'setrum' => 'charger_nyetrum',
            'restart' => 'mobo_restart', 'mati' => 'mobo_mati_total',
            'pecah' => 'speaker_pecah', 'serak' => 'speaker_pecah', 'kemresek' => 'speaker_pecah',
            'garis' => 'lcd_garis', 'blok' => 'lcd_garis',
        ];

        $scores = [];
        foreach ($singleKeywords as $kw => $kbKey) {
            if (str_contains($message, $kw)) {
                $scores[$kbKey] = ($scores[$kbKey] ?? 0) + strlen($kw);
            }
        }

        if (!empty($scores)) {
            arsort($scores);
            return array_key_first($scores);
        }

        return null;
    }

    private function matchesAny(string $message, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (str_contains($message, $pattern)) return true;
        }
        return false;
    }

    // =========================================================================
    // BUILDERS: Pesan Statis
    // =========================================================================
    private function buildGreeting(): string
    {
        $hour = (int) now()->addHours(7)->format('H');
        $sapa = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 19 ? 'Selamat sore' : 'Selamat malam'));

        return "{$sapa}! 👋 Saya **LaptopBot**, asisten virtual berbasis Sistem Pakar Diagnosa Laptop.\n\n"
            . "Saya dapat memberikan informasi **mendalam** tentang:\n"
            . "• Penyebab spesifik setiap kerusakan laptop\n"
            . "• Cara identifikasi gejala yang tepat\n"
            . "• Langkah penanganan mandiri di rumah\n"
            . "• Kapan harus dibawa ke teknisi\n"
            . "• Tips pencegahan agar tidak rusak lagi\n"
            . "• Estimasi biaya servis & sparepart\n\n"
            . "**Contoh pertanyaan:** _\"layar laptop gelap\"_, _\"baterai cepat habis\"_, _\"laptop sering blue screen\"_, _\"cara backup data\"_\n\n"
            . "Pilih topik atau ceritakan masalahmu:";
    }

    private function buildHelpMessage(): string
    {
        return "Saya bisa membantu dengan pertanyaan mendalam seputar **kerusakan laptop**! 🤖\n\n"
            . "**Topik yang bisa saya jelaskan:**\n"
            . "🖥️ Layar (gelap, bergaris, putih, berkedip)\n"
            . "⌨️ Keyboard (tidak berfungsi, mengetik sendiri)\n"
            . "🧠 RAM (hang, blue screen, tidak terbaca)\n"
            . "🔌 Charger (tidak mengisi, nyetrum, overheat)\n"
            . "💾 Harddisk (lambat, bunyi aneh, blue screen)\n"
            . "🖱️ Touchpad (mati, kursor gerak sendiri)\n"
            . "🌀 Cooling Fan (panas, kipas mati)\n"
            . "📷 Webcam (tidak terdeteksi)\n"
            . "🔋 Baterai (boros, tidak mengisi)\n"
            . "🔧 Motherboard (mati total, restart sendiri)\n"
            . "🔊 Speaker (bisu, suara pecah)\n\n"
            . "**FAQ yang bisa saya jawab:**\n"
            . "• _\"berapa biaya servis ...\"_\n"
            . "• _\"cara cek suhu laptop\"_\n"
            . "• _\"cara backup data\"_\n"
            . "• _\"laptop kena air\"_\n"
            . "• _\"cara upgrade laptop tua\"_\n\n"
            . "Pilih topik atau ketik pertanyaanmu:";
    }

    private function buildUnknownResponse(string $raw): string
    {
        return "Maaf, saya belum menemukan informasi untuk: _\"{$raw}\"_ 🤔\n\n"
            . "Saya khusus menangani pertanyaan **seputar kerusakan laptop**.\n\n"
            . "Coba tanyakan dengan lebih spesifik, contoh:\n"
            . "• _\"layar laptop gelap bagaimana cara mengatasinya\"_\n"
            . "• _\"kenapa baterai laptop cepat habis\"_\n"
            . "• _\"laptop saya berbunyi klik-klik dari dalam\"_\n"
            . "• _\"cara cek suhu laptop\"_\n\n"
            . "Atau hubungi **Admin** untuk pertanyaan di luar topik ini.";
    }

    // =========================================================================
    // BUTTON HELPERS
    // =========================================================================
    private function topicButtons(): array
    {
        return [
            ['label' => '🖥️ Layar / LCD',    'action' => 'send', 'text' => 'layar laptop gelap'],
            ['label' => '⌨️ Keyboard',        'action' => 'send', 'text' => 'keyboard tidak berfungsi'],
            ['label' => '🧠 RAM / Memory',    'action' => 'send', 'text' => 'ram bermasalah hang'],
            ['label' => '🔌 Charger',         'action' => 'send', 'text' => 'charger tidak mengisi'],
            ['label' => '💾 Harddisk / SSD',  'action' => 'send', 'text' => 'laptop lambat booting lama'],
            ['label' => '🖱️ Touchpad',        'action' => 'send', 'text' => 'touchpad tidak berfungsi'],
            ['label' => '🌀 Kipas / Panas',   'action' => 'send', 'text' => 'laptop panas overheat'],
            ['label' => '📷 Webcam',          'action' => 'send', 'text' => 'webcam tidak berfungsi'],
            ['label' => '🔋 Baterai',         'action' => 'send', 'text' => 'baterai cepat habis'],
            ['label' => '🔧 Motherboard',     'action' => 'send', 'text' => 'laptop tidak menyala'],
            ['label' => '🔊 Speaker',         'action' => 'send', 'text' => 'tidak ada suara speaker'],
            ['label' => '💰 Estimasi Biaya',  'action' => 'send', 'text' => 'berapa biaya servis'],
        ];
    }

    private function quickMenuButtons(): array
    {
        return [
            ['label' => '🔍 Diagnosa Laptop',  'action' => 'link', 'url' => '/diagnosa'],
            ['label' => '📋 Topik Kerusakan',  'action' => 'send', 'text' => 'bantuan'],
            ['label' => '💬 Hubungi Admin',    'action' => 'admin'],
        ];
    }

    private function buildDetailButtons(): array
    {
        return [
            ['label' => '🔍 Diagnosa Akurat',    'action' => 'link', 'url' => '/diagnosa'],
            ['label' => '📋 Topik Lain',          'action' => 'send', 'text' => 'bantuan'],
            ['label' => '💰 Estimasi Biaya',      'action' => 'send', 'text' => 'berapa biaya servis'],
            ['label' => '💬 Tanya Admin',         'action' => 'admin'],
        ];
    }

    private function buildAdminButtons(): array
    {
        return [
            ['label' => '💬 Chat dengan Admin', 'action' => 'admin'],
            ['label' => '🔍 Coba Diagnosa',     'action' => 'link', 'url' => '/diagnosa'],
            ['label' => '📋 Topik Kerusakan',   'action' => 'send', 'text' => 'bantuan'],
        ];
    }

    private function jsonReply(string $message, string $type = 'info', array $buttons = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'type'    => $type,
            'message' => $message,
            'buttons' => $buttons,
        ]);
    }

    // =========================================================================
    // ADMIN CONTACT
    // =========================================================================
    public function adminContact()
    {
        $waNumber = env('ADMIN_WA_NUMBER', '6281234567890');
        $waText   = urlencode('Halo Admin, saya ingin berkonsultasi tentang kerusakan laptop saya.');

        return response()->json([
            'success'    => true,
            'wa_number'  => $waNumber,
            'wa_url'     => "https://wa.me/{$waNumber}?text={$waText}",
            'admin_name' => env('CHATBOT_ADMIN_NAME', env('ADMIN_NAME', 'Admin LaptopExpert')),
        ]);
    }
}
