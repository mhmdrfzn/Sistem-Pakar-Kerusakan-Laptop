# 🔬 LaptopExpert AI — Sistem Pakar Diagnosa Kerusakan Laptop

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

**Sistem pakar berbasis web untuk mendiagnosa kerusakan laptop secara otomatis menggunakan metode Forward Chaining dan Certainty Factor (CF)**

</div>

---

## 📋 Daftar Isi

- [Tentang Sistem](#-tentang-sistem)
- [Fitur Utama](#-fitur-utama)
- [Metode yang Digunakan](#-metode-yang-digunakan)
- [Tech Stack](#-tech-stack)
- [Struktur Database](#-struktur-database)
- [Cara Instalasi](#-cara-instalasi)
- [Struktur Direktori](#-struktur-direktori)
- [Cara Penggunaan](#-cara-penggunaan)
- [Basis Pengetahuan](#-basis-pengetahuan)
- [Contoh Perhitungan CF](#-contoh-perhitungan-cf)
- [Panel Admin](#-panel-admin)

---

## 🎯 Tentang Sistem

**LaptopExpert AI** adalah sistem pakar berbasis web yang membantu pengguna awam mendiagnosa kerusakan laptop secara mandiri tanpa harus langsung membawa ke teknisi. Sistem ini menggunakan pendekatan **kecerdasan buatan** dengan dua metode utama:

1. **Forward Chaining** — Mesin inferensi yang mencocokkan gejala yang dipilih pengguna dengan basis aturan (rules) yang telah diisi oleh pakar teknisi laptop.
2. **Certainty Factor (CF)** — Mengukur tingkat keyakinan diagnosa berdasarkan bobot keyakinan pakar (CF Pakar) dan tingkat keyakinan pengguna (CF User) terhadap setiap gejala.

Sistem menghasilkan **satu kesimpulan diagnosa pasti** beserta detail perhitungan yang transparan, solusi perbaikan, estimasi biaya komponen, dan biaya jasa servis.

---

## ✨ Fitur Utama

### 👤 Fitur Pengguna
| Fitur | Deskripsi |
|-------|-----------|
| 🔍 **Form Diagnosa** | Pilih gejala dari 45 gejala yang dikelompokkan dalam 7 kategori komponen |
| ⚖️ **Input CF User** | Setiap gejala bisa diberi tingkat keyakinan: Tidak Yakin (0.2) hingga Sangat Yakin (1.0) |
| 📊 **Hasil Diagnosa** | Satu kesimpulan pasti dengan persentase keyakinan dan badge interpretasi |
| 🔍 **Detail CF** | Penjelasan transparan: tabel CF Pakar × CF User, proses kombinasi iteratif per langkah |
| 🛠️ **Solusi Perbaikan** | Langkah-langkah perbaikan, komponen pengganti, estimasi biaya part dan jasa servis |
| 📜 **Riwayat Diagnosa** | Simpan dan lihat kembali history diagnosa sebelumnya |
| 🤖 **LaptopBot** | Chatbot AI untuk konsultasi kerusakan laptop secara interaktif |

### 🔐 Fitur Admin
| Fitur | Deskripsi |
|-------|-----------|
| 🗂️ **Kelola Gejala** | CRUD gejala (kode, deskripsi, kategori komponen) |
| 🩺 **Kelola Kerusakan** | CRUD kerusakan (nama, solusi, estimasi biaya, kode) |
| 📏 **Kelola Rules** | CRUD rules multi-gejala — satu kerusakan bisa punya banyak gejala dengan CF Pakar berbeda |
| 👥 **Manajemen User** | Kelola akun pengguna sistem |
| 📈 **Dashboard** | Statistik diagnosa, jumlah gejala, kerusakan, dan rules |

---

## 🧠 Metode yang Digunakan

### 1. Forward Chaining (Inferensi Maju)

Sistem bekerja dari **fakta → kesimpulan** (*data-driven*):

```
Fakta (Gejala Pengguna) → Pencocokan Rules → Conflict Resolution → 1 Kesimpulan
```

**Partial Matching** — Rule dianggap aktif jika minimal **50%** gejalanya cocok dengan fakta pengguna:

```
Match Ratio = jumlah_gejala_cocok / total_gejala_dalam_rule ≥ 0.5
```

### 2. Certainty Factor (CF)

**CF Final per Gejala:**
```
CF_final = CF_pakar × CF_user
```

**Kombinasi CF Iteratif (untuk semua gejala yang cocok dalam satu rule):**
```
CF_combine = CF_lama + CF_baru × (1 − CF_lama)
```

**Interpretasi Hasil:**

| Nilai CF | Persentase | Interpretasi |
|----------|-----------|--------------|
| 0.81 – 1.00 | 81% – 100% | 🔴 Sangat Yakin |
| 0.61 – 0.80 | 61% – 80%  | 🟠 Yakin |
| 0.41 – 0.60 | 41% – 60%  | 🟡 Cukup Yakin |
| 0.21 – 0.40 | 21% – 40%  | 🔵 Kurang Yakin |
| 0.00 – 0.20 | 0% – 20%   | ⚪ Tidak Yakin |

### 3. Conflict Resolution

Ketika beberapa rule aktif bersamaan (conflict set), sistem memilih **satu rule dengan CF gabungan tertinggi** sebagai kesimpulan akhir.

---

## 🛠️ Tech Stack

```
Backend  : PHP 8.x + Laravel 12.x (MVC Architecture)
Database : MySQL 8.0
Frontend : HTML5 + Vanilla CSS (Glassmorphism Dark Theme) + JavaScript
Server   : Apache (Laragon - local development)
ORM      : Eloquent (belongsToMany + withPivot)
Template : Blade PHP
```

---

## 🗄️ Struktur Database

```
┌──────────────┐         ┌──────────────┐         ┌──────────────┐
│  kerusakan   │         │    rules     │         │    gejala    │
├──────────────┤  1    N ├──────────────┤  N    1 ├──────────────┤
│ id           │◄────────│ id           │         │ id           │
│ kode         │         │ kerusakan_id │         │ kode         │
│ nama         │         │ nama_rule    │         │ deskripsi    │
│ komponen_    │         └──────┬───────┘         │ kategori     │
│  pengganti   │                │ 1               └──────┬───────┘
│ est_part_min │                │                        │
│ est_part_max │         ┌──────▼───────┐                │
│ service_fee  │         │ rule_gejala  │ N              │
│ solutions    │         ├──────────────┤◄───────────────┘
└──────────────┘         │ id           │
                         │ rule_id (FK) │
                         │ gejala_id(FK)│
                         │ cf_nilai     │  ← CF Pakar (0.01 – 1.00)
                         └──────────────┘

Tabel tambahan:
┌──────────────────────────────────────────┐
│             sesi_diagnosa                │
├──────────────────────────────────────────┤
│ id, nama_pengguna, nama_laptop           │
│ gejala_dipilih (JSON)                    │
│ hasil_diagnosa (JSON)                    │
│ ip_address, created_at                   │
└──────────────────────────────────────────┘
```

**Basis Pengetahuan saat ini:**
- 🩺 **11 Jenis Kerusakan**
- 📋 **45 Gejala** dalam 7 kategori komponen
- 📏 **11 Rules** dengan total **51 pasangan gejala–rule**

---

## 🚀 Cara Instalasi

### Prasyarat
- PHP >= 8.0
- Composer
- MySQL / MariaDB
- Laragon / XAMPP / WAMP

### Langkah-langkah

**1. Clone repository**
```bash
git clone https://github.com/mhmdrfzn/Sistem-Pakar-Kerusakan-Laptop.git
cd Sistem-Pakar-Kerusakan-Laptop
```

**2. Install dependencies**
```bash
composer install
```

**3. Salin file environment**
```bash
cp .env.example .env
```

**4. Konfigurasi `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_pakar
DB_USERNAME=root
DB_PASSWORD=
```

**5. Generate application key**
```bash
php artisan key:generate
```

**6. Jalankan migrasi & seeder**
```bash
php artisan migrate
php artisan db:seed
```

**7. Jalankan server**
```bash
php artisan serve
```

**8. Akses aplikasi**
```
Aplikasi : http://localhost:8000
Admin    : http://localhost:8000/admin
```

> **Login Admin Default:**
> - Email: `admin@sistempakar.com`
> - Password: `password`

---

## 📁 Struktur Direktori

```
SistemPakar/
├── app/
│   ├── Http/Controllers/
│   │   ├── DiagnosaController.php          # Logika utama diagnosa
│   │   └── Admin/
│   │       ├── GejalaController.php
│   │       ├── KerusakanController.php
│   │       └── RuleController.php          # CRUD rules multi-gejala
│   ├── Models/
│   │   ├── Gejala.php
│   │   ├── Kerusakan.php
│   │   ├── Rule.php                        # belongsToMany via rule_gejala
│   │   └── SesiDiagnosa.php
│   └── Services/
│       ├── ForwardChainingService.php      # Mesin inferensi utama
│       └── CertaintyFactorService.php      # Logika kombinasi CF
├── database/
│   ├── migrations/
│   │   ├── create_gejala_table.php
│   │   ├── create_kerusakan_table.php
│   │   ├── create_rules_table.php
│   │   ├── restructure_rules_multi_gejala  # Pivot CF per gejala
│   │   └── create_sesi_diagnosa_table.php
│   └── seeders/
│       ├── GejalaSeeder.php
│       ├── KerusakanSeeder.php
│       └── RuleSeeder.php
└── resources/views/
    ├── diagnosa/
    │   ├── index.blade.php                 # Form diagnosa + slider CF User
    │   ├── hasil.blade.php                 # Hasil + detail perhitungan CF
    │   └── riwayat.blade.php
    ├── admin/
    │   ├── rules/form.blade.php            # Form multi-gejala dinamis
    │   ├── gejala/
    │   └── kerusakan/
    └── layouts/
        ├── app.blade.php
        └── admin.blade.php
```

---

## 📖 Cara Penggunaan

### Melakukan Diagnosa
1. Buka halaman **Diagnosa** (`/diagnosa`)
2. Pilih **gejala** yang dialami laptop dari daftar yang tersedia
3. Tentukan **tingkat keyakinan (CF User)** untuk setiap gejala:

   | Pilihan | Nilai | Keterangan |
   |---------|-------|------------|
   | Tidak Yakin | 0.2 | Gejala hanya sesekali muncul |
   | Kurang Yakin | 0.4 | Gejala tidak konsisten |
   | Cukup Yakin | 0.6 | Gejala sering muncul |
   | Yakin | 0.8 | Gejala selalu ada *(default)* |
   | Sangat Yakin | 1.0 | Gejala pasti/sangat jelas |

4. Klik tombol **Diagnosa Sekarang**
5. Lihat hasil lengkap beserta detail perhitungan CF

---

## 📚 Basis Pengetahuan

| No | Kode | Kerusakan | Jumlah Gejala |
|----|------|-----------|---------------|
| 1  | K001 | LCD / Layar | 5 |
| 2  | K002 | Keyboard | 3 |
| 3  | K003 | Memory RAM | 5 |
| 4  | K004 | Charger / Adaptor | 4 |
| 5  | K005 | Harddisk / SSD | 10 |
| 6  | K006 | Touchpad | 4 |
| 7  | K007 | Cooling Fan | 3 |
| 8  | K008 | Webcam / Kamera | 3 |
| 9  | K009 | Baterai | 3 |
| 10 | K010 | Motherboard | 7 |
| 11 | K011 | Speaker / Audio | 4 |

---

## 🧮 Contoh Perhitungan CF

**Kasus:** Pengguna memilih 3 gejala kerusakan LCD

| Gejala | CF Pakar | CF User | CF Final |
|--------|----------|---------|----------|
| G001 – Layar gelap/mati total | 0.8 | 0.8 | 0.64 |
| G003 – Pixel mati / bercak hitam | 0.9 | 1.0 | 0.90 |
| G004 – Backlight mati | 0.8 | 0.6 | 0.48 |

**Proses Kombinasi Iteratif:**
```
Iterasi 1: 0.0000 + 0.64 × (1 − 0.0000) = 0.6400
Iterasi 2: 0.6400 + 0.90 × (1 − 0.6400) = 0.9640
Iterasi 3: 0.9640 + 0.48 × (1 − 0.9640) = 0.9813
```

**Hasil:** CF = `0.9813` → **98.13%** → 🔴 **SANGAT YAKIN — Kerusakan LCD**

---

## 🔐 Panel Admin

```
/admin/dashboard     → Statistik & ringkasan sistem
/admin/gejala        → Kelola 45 gejala
/admin/kerusakan     → Kelola 11 jenis kerusakan + solusi + biaya
/admin/rules         → Kelola rules multi-gejala + CF Pakar per gejala
/admin/users         → Manajemen pengguna
```

**Menambah Rule baru:**
1. Pilih kerusakan → bagian **THEN** dari rule
2. Klik `+ Tambah Gejala` → pilih gejala dari dropdown
3. Isi **CF Pakar** (0.01 – 1.00) per gejala
4. Ulangi untuk semua gejala relevan
5. Klik **Simpan** → tersimpan otomatis ke tabel pivot `rule_gejala`

---

## 👥 Tim Pengembang

| Nama | NIM | Peran |
|------|-----|-------|
| *(nama)* | *(NIM)* | *(peran)* |

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan **Tugas Akhir / Proyek Sistem Pakar**.  
Dibuat dengan ❤️ menggunakan **Laravel + Vanilla CSS**.
