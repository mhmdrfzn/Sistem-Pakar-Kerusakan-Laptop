@extends('layouts.app')

@section('title', 'Beranda — Sistem Pakar Diagnosa Laptop')
@section('description', 'Sistem Pakar Diagnosa Laptop menggunakan Forward Chaining dan Certainty Factor. Identifikasi kerusakan laptop Anda dengan akurasi tinggi.')

@section('content')

<!-- Hero Section -->
<section class="relative overflow-hidden">
    <!-- Background decorations -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full opacity-20 blur-3xl"
             style="background: radial-gradient(circle, #4f46e5, transparent 70%);"></div>
        <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full opacity-15 blur-3xl"
             style="background: radial-gradient(circle, #7c3aed, transparent 70%);"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full opacity-5 blur-3xl"
             style="background: radial-gradient(circle, #6366f1, transparent 70%);"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 pt-20 pb-16 relative">
        <div class="text-center max-w-4xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-8 text-xs font-medium text-indigo-300"
                 style="background: rgba(79, 70, 229, 0.15); border: 1px solid rgba(99, 102, 241, 0.3);">
                <div class="w-2 h-2 rounded-full bg-green-400 pulse-glow"></div>
                Sistem Pakar Aktif — AI-Powered Laptop Diagnostics
            </div>

            <!-- Main Heading -->
            <h1 class="font-display font-bold text-5xl md:text-7xl text-white leading-tight mb-6">
                Diagnosa Kerusakan
                <span class="block gradient-text mt-1">Laptop Anda</span>
            </h1>

            <p class="text-slate-400 text-lg md:text-xl leading-relaxed mb-10 max-w-2xl mx-auto">
                Identifikasi masalah laptop secara cerdas menggunakan metode 
                <span class="text-indigo-400 font-medium">Forward Chaining</span> &amp; 
                <span class="text-violet-400 font-medium">Certainty Factor</span>. 
                Dapatkan rekomendasi solusi dan estimasi biaya perbaikan secara instan.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('diagnosa.form') }}" class="btn-primary inline-flex items-center justify-center gap-2 text-base px-8 py-4">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline mr-1"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        Mulai Diagnosa Sekarang
                    </span>
                </a>
                <a href="{{ route('diagnosa.riwayat') }}" class="btn-outline inline-flex items-center justify-center gap-2 text-base px-8 py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
                    Lihat Riwayat
                </a>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $stats = [
                    ['value' => '11', 'label' => 'Jenis Kerusakan', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M12 2v2"/><path d="M12 22v-2"/><path d="m17 20.66-1-1.73"/><path d="M11 10.27 7 3.34"/><path d="m20.66 17-1.73-1"/><path d="m3.34 7 1.73 1"/><path d="M14 12h8"/><path d="M2 12h2"/><path d="m20.66 7-1.73 1"/><path d="m3.34 17 1.73-1"/><path d="m17 3.34-1 1.73"/><path d="m11 13.73-4 6.93"/></svg>', 'color' => '#6366f1'],
                    ['value' => $totalGejala ?? '63', 'label' => 'Gejala Terdaftar', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>', 'color' => '#8b5cf6'],
                    ['value' => '100%', 'label' => 'Basis Pengetahuan', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5a3 3 0 1 0-5.997.125 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588A4 4 0 1 0 12 18Z"/><path d="M12 5a3 3 0 1 1 5.997.125 4 4 0 0 1 2.526 5.77 4 4 0 0 1-.556 6.588A4 4 0 1 1 12 18Z"/><path d="M15 13a4.5 4.5 0 0 1-3-4 4.5 4.5 0 0 1-3 4"/><path d="M17.599 6.5a3 3 0 0 0 .399-1.375"/><path d="M6.003 5.125A3 3 0 0 0 6.401 6.5"/><path d="M3.477 10.896a4 4 0 0 1 .585-.396"/><path d="M19.938 10.5a4 4 0 0 1 .585.396"/><path d="M6 18a4 4 0 0 1-1.967-.516"/><path d="M19.967 17.484A4 4 0 0 1 18 18"/></svg>', 'color' => '#a78bfa'],
                    ['value' => 'CF', 'label' => 'Metode Certainty Factor', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>', 'color' => '#c4b5fd'],
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="glass rounded-2xl p-6 text-center glass-hover">
                <div class="flex justify-center mb-3" style="color: {{ $stat['color'] }};">{!! $stat['svg'] !!}</div>
                <div class="stat-value mb-1" style="color: {{ $stat['color'] }};">{{ $stat['value'] }}</div>
                <div class="text-slate-500 text-xs mt-1">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="text-indigo-400 text-sm font-medium uppercase tracking-wider mb-3">Cara Kerja Sistem</p>
            <h2 class="font-display font-bold text-3xl md:text-4xl text-white mb-4">
                Proses Diagnosa yang 
                <span class="gradient-text">Cerdas &amp; Akurat</span>
            </h2>
            <p class="text-slate-400 max-w-xl mx-auto">Tiga langkah sederhana untuk mendapatkan diagnosa kerusakan laptop yang akurat.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $steps = [
                    [
                        'num' => '01',
                        'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>',
                        'title' => 'Pilih Gejala',
                        'desc' => 'Pilih gejala yang sesuai dengan kondisi laptop Anda dari lebih dari 60 gejala yang tersedia, dikelompokkan berdasarkan kategori.',
                        'color' => 'from-indigo-500/20 to-indigo-600/10',
                        'border' => 'border-indigo-500/20',
                    ],
                    [
                        'num' => '02',
                        'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
                        'title' => 'Proses AI Inference',
                        'desc' => 'Mesin inferensi Forward Chaining akan mencocokkan gejala dengan basis pengetahuan, lalu menghitung tingkat keyakinan menggunakan Certainty Factor.',
                        'color' => 'from-violet-500/20 to-violet-600/10',
                        'border' => 'border-violet-500/20',
                    ],
                    [
                        'num' => '03',
                        'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>',
                        'title' => 'Terima Hasil Diagnosa',
                        'desc' => 'Dapatkan hasil diagnosa lengkap dengan persentase keyakinan, rekomendasi solusi perbaikan, dan estimasi biaya servis.',
                        'color' => 'from-purple-500/20 to-purple-600/10',
                        'border' => 'border-purple-500/20',
                    ],
                ];
            @endphp

            @foreach($steps as $step)
            <div class="feature-card relative overflow-hidden bg-gradient-to-br {{ $step['color'] }} border {{ $step['border'] }}">
                <div class="absolute top-4 right-4 font-display font-bold text-5xl text-white/5">{{ $step['num'] }}</div>
                <div class="mb-4 text-indigo-300">{!! $step['svg'] !!}</div>
                <h3 class="font-display font-bold text-xl text-white mb-3">{{ $step['title'] }}</h3>
                <p class="text-slate-400 text-sm leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Komponen Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="text-violet-400 text-sm font-medium uppercase tracking-wider mb-3">Basis Pengetahuan</p>
            <h2 class="font-display font-bold text-3xl md:text-4xl text-white mb-4">
                11 Komponen Laptop
                <span class="gradient-text">yang Didiagnosa</span>
            </h2>
            <p class="text-slate-400 max-w-xl mx-auto">Sistem kami mampu mendiagnosa kerusakan pada komponen-komponen utama laptop.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
            @php
                $komponen = [
                    ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>', 'nama' => 'LCD', 'kode' => 'K001', 'color' => 'from-blue-500/20'],
                    ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="M6 8h.001"/><path d="M10 8h.001"/><path d="M14 8h.001"/><path d="M18 8h.001"/><path d="M8 12h.001"/><path d="M12 12h.001"/><path d="M16 12h.001"/><path d="M7 16h10"/></svg>', 'nama' => 'Keyboard', 'kode' => 'K002', 'color' => 'from-violet-500/20'],
                    ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="8" width="16" height="8" rx="2"/><path d="M8 8V6a2 2 0 0 1 4 0v2"/><path d="M12 8V6a2 2 0 0 1 4 0v2"/><path d="M8 16v2a2 2 0 0 0 4 0v-2"/><path d="M12 16v2a2 2 0 0 0 4 0v-2"/></svg>', 'nama' => 'Memory RAM', 'kode' => 'K003', 'color' => 'from-green-500/20'],
                    ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 3v4"/><path d="M19 3v4"/><path d="M5 7h14"/><path d="M12 7v10"/><path d="M9 17h6"/></svg>', 'nama' => 'Charger', 'kode' => 'K004', 'color' => 'from-yellow-500/20'],
                    ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14a9 3 0 0 0 18 0V5"/><path d="M3 12a9 3 0 0 0 18 0"/></svg>', 'nama' => 'Harddisk', 'kode' => 'K005', 'color' => 'from-orange-500/20'],
                    ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="7"/><path d="M12 2v8"/><path d="M5 10h14"/></svg>', 'nama' => 'Touchpad', 'kode' => 'K006', 'color' => 'from-pink-500/20'],
                    ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M12 2a10 10 0 0 1 7.38 16.75"/><path d="M12 22a10 10 0 0 1 -7.38 -16.75"/></svg>', 'nama' => 'Cooling Fan', 'kode' => 'K007', 'color' => 'from-cyan-500/20'],
                    ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>', 'nama' => 'Webcam', 'kode' => 'K008', 'color' => 'from-teal-500/20'],
                    ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="10" x="2" y="7" rx="2"/><line x1="22" x2="22" y1="11" y2="13"/><line x1="6" x2="6" y1="11" y2="13"/></svg>', 'nama' => 'Baterai', 'kode' => 'K009', 'color' => 'from-emerald-500/20'],
                    ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M12 2v2"/><path d="M12 22v-2"/><path d="m17 20.66-1-1.73"/><path d="M11 10.27 7 3.34"/><path d="m20.66 17-1.73-1"/><path d="m3.34 7 1.73 1"/><path d="M14 12h8"/><path d="M2 12h2"/><path d="m20.66 7-1.73 1"/><path d="m3.34 17 1.73-1"/><path d="m17 3.34-1 1.73"/><path d="m11 13.73-4 6.93"/></svg>', 'nama' => 'Motherboard', 'kode' => 'K010', 'color' => 'from-red-500/20'],
                    ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>', 'nama' => 'Speaker', 'kode' => 'K011', 'color' => 'from-indigo-500/20'],
                ];
            @endphp

            @foreach($komponen as $item)
            <a href="{{ route('diagnosa.form') }}" 
               class="glass rounded-2xl p-4 text-center glass-hover bg-gradient-to-b {{ $item['color'] }} to-transparent cursor-pointer block">
                <div class="flex justify-center mb-3 text-slate-300 floating" style="animation-delay: {{ $loop->index * 0.2 }}s;">{!! $item['svg'] !!}</div>
                <div class="text-xs font-semibold text-white">{{ $item['nama'] }}</div>
                <div class="text-[10px] text-slate-600 mt-1">{{ $item['kode'] }}</div>
            </a>
            @endforeach

            <!-- Start Diagnosis Card -->
            <a href="{{ route('diagnosa.form') }}" 
               class="glass rounded-2xl p-4 text-center glass-hover border-dashed cursor-pointer block"
               style="border: 1px dashed rgba(99, 102, 241, 0.3); background: rgba(99, 102, 241, 0.05);">
                <div class="flex justify-center mb-3 text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                </div>
                <div class="text-xs font-semibold text-indigo-400">Mulai<br>Diagnosa</div>
            </a>
        </div>
    </div>
</section>

<!-- Algorithm Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="glass rounded-3xl overflow-hidden" style="border: 1px solid rgba(99, 102, 241, 0.2);">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <!-- Left: Forward Chaining -->
                <div class="p-8 md:p-12">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium text-indigo-300 mb-6"
                         style="background: rgba(79, 70, 229, 0.2); border: 1px solid rgba(99, 102, 241, 0.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Forward Chaining
                    </div>
                    <h3 class="font-display font-bold text-2xl text-white mb-4">Inferensi Maju</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">
                        Mesin inferensi dimulai dari <strong class="text-indigo-300">fakta (gejala)</strong> yang diberikan oleh pengguna, 
                        kemudian menelusuri aturan-aturan dalam basis pengetahuan untuk mencapai kesimpulan berupa kerusakan yang teridentifikasi.
                    </p>
                    <div class="space-y-3">
                        @php
                            $fcSteps = [
                                ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/><path d="M16 19h6"/><path d="M19 16v6"/></svg>', 'text' => 'Fakta input: Gejala yang dipilih pengguna'],
                                ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>', 'text' => 'Pencarian rule yang sesuai dalam rule base'],
                                ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>', 'text' => 'Aktivasi rule jika kondisi terpenuhi'],
                                ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>', 'text' => 'Kesimpulan: Kerusakan yang terdiagnosa'],
                            ];
                        @endphp
                        @foreach($fcSteps as $i => $step)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-indigo-400"
                                 style="background: rgba(99, 102, 241, 0.15);">{!! $step['svg'] !!}</div>
                            <p class="text-slate-300 text-sm">{{ $step['text'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right: Certainty Factor -->
                <div class="p-8 md:p-12 border-t lg:border-t-0 lg:border-l border-white/5">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium text-violet-300 mb-6"
                         style="background: rgba(124, 58, 237, 0.2); border: 1px solid rgba(139, 92, 246, 0.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                        Certainty Factor
                    </div>
                    <h3 class="font-display font-bold text-2xl text-white mb-4">Faktor Kepastian</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">
                        Setiap gejala memiliki nilai CF (Certainty Factor) yang menunjukkan tingkat keyakinan terhadap suatu kerusakan. 
                        Nilai CF digabungkan menggunakan formula khusus untuk menghasilkan persentase keyakinan akhir.
                    </p>
                    <!-- Formula -->
                    <div class="rounded-xl p-4 mb-4" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(139, 92, 246, 0.2);">
                        <p class="text-xs text-slate-500 mb-2 font-mono">// Formula Certainty Factor Combine</p>
                        <p class="font-mono text-sm text-violet-300">CF(A,B) = CF<sub>A</sub> + CF<sub>B</sub> × (1 - CF<sub>A</sub>)</p>
                    </div>
                    <!-- CF Scale -->
                    <div class="space-y-2">
                        @php
                            $cfScale = [
                                ['range' => '80%–100%', 'label' => 'Sangat Yakin', 'color' => '#ef4444', 'bg' => 'rgba(239,68,68,0.15)'],
                                ['range' => '60%–79%', 'label' => 'Yakin', 'color' => '#f97316', 'bg' => 'rgba(249,115,22,0.15)'],
                                ['range' => '40%–59%', 'label' => 'Cukup Yakin', 'color' => '#eab308', 'bg' => 'rgba(234,179,8,0.15)'],
                                ['range' => '20%–39%', 'label' => 'Kurang Yakin', 'color' => '#6366f1', 'bg' => 'rgba(99,102,241,0.15)'],
                            ];
                        @endphp
                        @foreach($cfScale as $scale)
                        <div class="flex items-center justify-between px-3 py-2 rounded-lg text-xs"
                             style="background: {{ $scale['bg'] }}; border: 1px solid {{ $scale['color'] }}30;">
                            <span style="color: {{ $scale['color'] }};" class="font-semibold">{{ $scale['label'] }}</span>
                            <span class="text-slate-400 font-mono">{{ $scale['range'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="glass rounded-3xl p-12 relative overflow-hidden"
             style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.2) 0%, rgba(124, 58, 237, 0.15) 100%); border: 1px solid rgba(99, 102, 241, 0.3);">
            <div class="absolute top-0 left-0 right-0 h-1 rounded-t-3xl"
                 style="background: linear-gradient(90deg, #4f46e5, #7c3aed, #ec4899);"></div>
            
            <div class="flex justify-center mb-6 text-indigo-300 floating">
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18h8"/><path d="M3 22h18"/><path d="M14 22a7 7 0 1 0 0-14h-1"/><path d="M9 14h2"/><path d="M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z"/><path d="M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"/></svg>
            </div>
            <h2 class="font-display font-bold text-3xl md:text-4xl text-white mb-4">
                Siap Mendiagnosa Laptop Anda?
            </h2>
            <p class="text-slate-400 mb-8 max-w-lg mx-auto">
                Mulai proses diagnosa sekarang. Pilih gejala yang Anda alami dan dapatkan analisa kerusakan secara instan.
            </p>
            <a href="{{ route('diagnosa.form') }}" 
               class="btn-primary inline-flex items-center justify-center gap-2 text-base px-10 py-4">
                <span class="inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                    Mulai Diagnosa Gratis
                </span>
            </a>
        </div>
    </div>
</section>

@endsection
