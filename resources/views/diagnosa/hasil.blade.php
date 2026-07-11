@extends('layouts.app')

@section('title', 'Hasil Diagnosa — Sistem Pakar Laptop')
@section('description', 'Hasil diagnosa kerusakan laptop berdasarkan gejala yang dipilih menggunakan metode Forward Chaining dan Certainty Factor.')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-slate-500 text-sm mb-6">
        <a href="{{ route('home') }}" class="hover:text-indigo-400 transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('diagnosa.form') }}" class="hover:text-indigo-400 transition-colors">Diagnosa</a>
        <span>/</span>
        <span class="text-slate-300">Hasil</span>
    </div>

    <!-- Result Header -->
    <div class="glass rounded-3xl p-6 md:p-8 mb-8 relative overflow-hidden"
         style="border: 1px solid rgba(99, 102, 241, 0.25);">
        <div class="absolute top-0 left-0 right-0 h-1 rounded-t-3xl"
             style="background: linear-gradient(90deg, #4f46e5, #7c3aed, #ec4899);"></div>
        
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18h8"/><path d="M3 22h18"/><path d="M14 22a7 7 0 1 0 0-14h-1"/><path d="M9 14h2"/><path d="M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z"/><path d="M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"/></svg>
                    </span>
                    <div>
                        <h1 class="font-display font-bold text-2xl md:text-3xl text-white">Hasil Diagnosa Laptop</h1>
                        <p class="text-slate-400 text-sm mt-1">
                            Didiagnosa pada {{ $sesi->created_at->format('d M Y, H:i') }} WIB
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 mt-4">
                    @if($namaUser && $namaUser !== 'Anonim')
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs"
                         style="background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3);">
                        <span class="text-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
                        </span>
                        <span class="text-slate-300">{{ $namaUser }}</span>
                    </div>
                    @endif
                    @if($namaLaptop && $namaLaptop !== 'Tidak diketahui')
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs"
                         style="background: rgba(124, 58, 237, 0.15); border: 1px solid rgba(124, 58, 237, 0.3);">
                        <span class="text-violet-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="12" x="3" y="4" rx="2"/><line x1="2" x2="22" y1="20" y2="20"/></svg>
                        </span>
                        <span class="text-slate-300">{{ $namaLaptop }}</span>
                    </div>
                    @endif
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs"
                         style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <span class="text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        </span>
                        <span class="text-slate-300">{{ count($kodeGejala) }} gejala dianalisa</span>
                    </div>
                    @if(!empty($hasilDiagnosa))
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs"
                         style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3);">
                        <span class="text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span class="text-emerald-300 font-semibold">1 Kesimpulan Pasti</span>
                    </div>
                    @if(!empty($hasilDiagnosa[0]['conflict_set']) && count($hasilDiagnosa[0]['conflict_set']) > 1)
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs"
                         style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <span class="text-slate-400">{{ count($hasilDiagnosa[0]['conflict_set']) }} rule dipertimbangkan</span>
                    </div>
                    @endif
                    @endif
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('diagnosa.form') }}" class="btn-outline text-sm inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
                    Diagnosa Ulang
                </a>
                <button onclick="window.print()" class="btn-outline text-sm inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                    Cetak
                </button>
            </div>
        </div>
    </div>

    @if(empty($hasilDiagnosa))
    <!-- No Result -->
    <div class="text-center py-20">
        <div class="flex justify-center mb-6 text-slate-600 floating">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="M11 8v3"/><path d="M11 14h.01"/></svg>
        </div>
        <h2 class="font-display font-bold text-2xl text-white mb-4">Tidak Ada Kerusakan Teridentifikasi</h2>
        <p class="text-slate-400 mb-8 max-w-md mx-auto">
            Gejala yang Anda pilih tidak cocok dengan pola kerusakan dalam basis pengetahuan kami. 
            Coba pilih lebih banyak gejala atau konsultasikan ke teknisi langsung.
        </p>
        <a href="{{ route('diagnosa.form') }}" class="btn-primary inline-flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
            Coba Diagnosa Ulang
        </a>
    </div>
    @else

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT: Diagnosis Results -->
        <div class="lg:col-span-2 space-y-5">
            <div class="flex items-center justify-between mb-2">
                <h2 class="font-display font-bold text-xl text-white">
                    Kesimpulan Diagnosa
                    <span class="gradient-text">— Satu Hasil Pasti</span>
                </h2>
                <div class="text-xs text-slate-500">Metode: Forward Chaining + CF</div>
            </div>

            @foreach($hasilDiagnosa as $index => $hasil)
            @php
                $interpret = $hasil['interpretasi'];
                $persen = $hasil['persentase'];
                $cfBarClass = match($interpret['label']) {
                    'Sangat Yakin' => 'cf-bar-critical',
                    'Yakin' => 'cf-bar-high',
                    'Cukup Yakin' => 'cf-bar-medium',
                    'Kurang Yakin' => 'cf-bar-low',
                    default => 'cf-bar-minor',
                };
                $badgeBg = match($interpret['label']) {
                    'Sangat Yakin' => 'rgba(239,68,68,0.2)',
                    'Yakin' => 'rgba(249,115,22,0.2)',
                    'Cukup Yakin' => 'rgba(234,179,8,0.2)',
                    'Kurang Yakin' => 'rgba(99,102,241,0.2)',
                    default => 'rgba(100,116,139,0.2)',
                };
                $badgeBorder = match($interpret['label']) {
                    'Sangat Yakin' => 'rgba(239,68,68,0.4)',
                    'Yakin' => 'rgba(249,115,22,0.4)',
                    'Cukup Yakin' => 'rgba(234,179,8,0.4)',
                    'Kurang Yakin' => 'rgba(99,102,241,0.4)',
                    default => 'rgba(100,116,139,0.4)',
                };
                $badgeColor = match($interpret['label']) {
                    'Sangat Yakin' => '#f87171',
                    'Yakin' => '#fb923c',
                    'Cukup Yakin' => '#facc15',
                    'Kurang Yakin' => '#818cf8',
                    default => '#94a3b8',
                };
                // SVG icons for each component type
                $iconSvgMap = [
                    '🖥️' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>',
                    '⌨️' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="M6 8h.001"/><path d="M10 8h.001"/><path d="M14 8h.001"/><path d="M18 8h.001"/><path d="M8 12h.001"/><path d="M12 12h.001"/><path d="M16 12h.001"/><path d="M7 16h10"/></svg>',
                    '🧠' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="8" width="16" height="8" rx="2"/><path d="M8 8V6a2 2 0 0 1 4 0v2"/><path d="M12 8V6a2 2 0 0 1 4 0v2"/><path d="M8 16v2a2 2 0 0 0 4 0v-2"/><path d="M12 16v2a2 2 0 0 0 4 0v-2"/></svg>',
                    '🔌' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 3v4"/><path d="M19 3v4"/><path d="M5 7h14"/><path d="M12 7v10"/><path d="M9 17h6"/></svg>',
                    '💾' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14a9 3 0 0 0 18 0V5"/><path d="M3 12a9 3 0 0 0 18 0"/></svg>',
                    '🖱️' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="7"/><path d="M12 2v8"/><path d="M5 10h14"/></svg>',
                    '🌀' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M12 2a10 10 0 0 1 7.38 16.75"/><path d="M12 22a10 10 0 0 1 -7.38 -16.75"/></svg>',
                    '📷' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>',
                    '🔋' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="10" x="2" y="7" rx="2"/><line x1="22" x2="22" y1="11" y2="13"/><line x1="6" x2="6" y1="11" y2="13"/></svg>',
                    '🔧' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M12 2v2"/><path d="M12 22v-2"/><path d="m17 20.66-1-1.73"/><path d="M11 10.27 7 3.34"/><path d="m20.66 17-1.73-1"/><path d="m3.34 7 1.73 1"/><path d="M14 12h8"/><path d="M2 12h2"/><path d="m20.66 7-1.73 1"/><path d="m3.34 17 1.73-1"/><path d="m17 3.34-1 1.73"/><path d="m11 13.73-4 6.93"/></svg>',
                    '🔊' => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>',
                ];
                $iconSvg = $iconSvgMap[$hasil['icon'] ?? '🔧'] ?? $iconSvgMap['🔧'];
            @endphp

            <div class="result-card glass animate-fadeInUp" 
                 style="border: 1px solid {{ $badgeBorder }}; animation-delay: {{ $index * 0.1 }}s;"
                 id="result-{{ $index }}">
                <!-- Card Header -->
                <div class="p-5 md:p-6">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
                                 style="background: {{ $badgeBg }}; border: 1px solid {{ $badgeBorder }}; color: {{ $badgeColor }};">
                                {!! $iconSvg !!}
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-mono text-slate-500">{{ $hasil['kode'] }}</span>
                                    @if($index === 0)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold inline-flex items-center gap-1"
                                          style="background: rgba(99,102,241,0.2); color: #a5b4fc; border: 1px solid rgba(99,102,241,0.3);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>
                                        DIAGNOSA UTAMA
                                    </span>
                                    @endif
                                </div>
                                <h3 class="font-display font-bold text-xl text-white">{{ $hasil['nama'] }}</h3>
                                <p class="text-slate-400 text-xs mt-1">{{ $hasil['total_gejala'] }} gejala cocok terdeteksi</p>
                            </div>
                        </div>

                        <!-- CF Badge -->
                        <div class="text-right flex-shrink-0">
                            <div class="result-card-badge mb-1" style="background: {{ $badgeBg }}; border: 1px solid {{ $badgeBorder }}; color: {{ $badgeColor }};">
                                {{ $interpret['icon'] }} {{ $interpret['badge'] }}
                            </div>
                            <div class="font-display font-bold text-2xl" style="color: {{ $badgeColor }};">
                                {{ number_format($persen, 1) }}%
                            </div>
                            <div class="text-xs text-slate-500">Certainty Factor</div>
                        </div>
                    </div>

                    <!-- CF Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-slate-500 mb-1.5">
                            <span>Tingkat Keyakinan</span>
                            <span class="font-medium" style="color: {{ $badgeColor }};">{{ $interpret['label'] }}</span>
                        </div>
                        <div class="cf-bar-container">
                            <div class="cf-bar-fill {{ $cfBarClass }}" 
                                 data-width="{{ $persen }}"
                                 style="width: 0%;"></div>
                        </div>
                    </div>

                    <!-- Gejala Cocok -->
                    <div class="mb-4">
                        <p class="text-xs text-slate-500 mb-2">Gejala yang Cocok:</p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($hasil['gejala_cocok'] as $gc)
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium"
                                  style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); color: #94a3b8;">
                                <span class="font-mono text-[10px] mr-1 opacity-60">{{ $gc['kode'] }}</span>
                                CF: {{ number_format($gc['cf_nilai'] * 100, 0) }}%
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Komponen & Biaya -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                        <div class="p-3 rounded-xl" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                            <p class="text-[10px] text-slate-500 mb-1 uppercase tracking-wider">Komponen Pengganti</p>
                            <p class="text-xs text-slate-300 leading-relaxed">{{ $hasil['komponen_pengganti'] }}</p>
                        </div>
                        <div class="p-3 rounded-xl" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                            <p class="text-[10px] text-slate-500 mb-1 uppercase tracking-wider">Estimasi Biaya Total</p>
                            <p class="text-sm font-semibold text-white">
                                Rp {{ number_format($hasil['estimasi_total_min'], 0, ',', '.') }}
                                <span class="text-slate-500 text-xs font-normal"> – </span>
                                Rp {{ number_format($hasil['estimasi_total_max'], 0, ',', '.') }}
                            </p>
                            @if($hasil['service_fee'] > 0)
                            <p class="text-[10px] text-slate-600 mt-0.5">
                                (Part: Rp {{ number_format($hasil['est_part_min'], 0, ',', '.') }}–{{ number_format($hasil['est_part_max'], 0, ',', '.') }} + Jasa: Rp {{ number_format($hasil['service_fee'], 0, ',', '.') }})
                            </p>
                            @else
                            <p class="text-[10px] text-slate-600 mt-0.5">(Tanpa biaya jasa)</p>
                            @endif
                        </div>
                    </div>

                    <!-- Solutions (Collapsible) -->
                    <div x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }">
                        <button type="button" 
                                onclick="toggleSolution(this, 'sol-{{ $index }}')"
                                class="w-full flex items-center justify-between p-3 rounded-xl text-left transition-all"
                                style="background: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99, 102, 241, 0.15);">
                            <span class="text-sm font-medium text-indigo-300 inline-flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M12 2v2"/><path d="M12 22v-2"/><path d="m17 20.66-1-1.73"/><path d="M11 10.27 7 3.34"/><path d="m20.66 17-1.73-1"/><path d="m3.34 7 1.73 1"/><path d="M14 12h8"/><path d="M2 12h2"/><path d="m20.66 7-1.73 1"/><path d="m3.34 17 1.73-1"/><path d="m17 3.34-1 1.73"/><path d="m11 13.73-4 6.93"/></svg>
                                Langkah Solusi Perbaikan
                            </span>
                            <svg id="arrow-{{ $index }}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform {{ $index === 0 ? 'rotate-180' : '' }}">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </button>
                        <div id="sol-{{ $index }}" class="{{ $index === 0 ? '' : 'hidden' }} mt-3">
                            <ol class="space-y-2">
                                @foreach($hasil['solutions'] as $si => $solution)
                                <li class="flex items-start gap-3 p-3 rounded-xl"
                                    style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5"
                                          style="background: rgba(99, 102, 241, 0.2); color: #a5b4fc;">{{ $si + 1 }}</span>
                                    <p class="text-sm text-slate-300 leading-relaxed">{{ $solution }}</p>
                                </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>

                    {{-- ⬇️ DETAIL PERHITUNGAN CF (collapsible) --}}
                    <div class="mt-3">
                        <button type="button"
                                onclick="toggleCFDetail('cfdetail-{{ $index }}')"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-left transition-all duration-200"
                                style="background: rgba(16,185,129,0.07); border: 1px solid rgba(16,185,129,0.2);">
                            <span class="text-xs font-medium text-emerald-400 inline-flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12h10"/><path d="m9 4 8 8-8 8"/>
                                    <path d="M21 12h-5"/>
                                </svg>
                                Lihat Detail Perhitungan Certainty Factor
                            </span>
                            <svg id="cf-chev-{{ $index }}" xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                 viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5"
                                 class="transition-transform duration-200">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>

                        <div id="cfdetail-{{ $index }}" class="hidden mt-3">
                            @php
                                /* Hitung ulang langkah-langkah kombinasi CF secara iteratif */
                                $cfSteps = [];
                                $cfAcc   = 0.0;
                                foreach ($hasil['gejala_cocok'] as $stepIdx => $gc) {
                                    $cfNew   = (float) $gc['cf_nilai']; // CF Final = pakar × user
                                    $cfOld   = $cfAcc;
                                    if ($cfOld >= 0 && $cfNew >= 0) {
                                        $cfAcc = $cfOld + $cfNew * (1 - $cfOld);
                                    } elseif ($cfOld < 0 && $cfNew < 0) {
                                        $cfAcc = $cfOld + $cfNew * (1 + $cfOld);
                                    } else {
                                        $cfAcc = ($cfOld + $cfNew) / (1 - min(abs($cfOld), abs($cfNew)));
                                    }
                                    $cfAcc = round($cfAcc, 4);
                                    $cfSteps[] = [
                                        'step'     => $stepIdx + 1,
                                        'kode'     => $gc['kode'],
                                        'cf_pakar' => $gc['cf_pakar'] ?? $cfNew,
                                        'cf_user'  => $gc['cf_user']  ?? 1.0,
                                        'cf_final' => $cfNew,
                                        'cf_old'   => round($cfOld, 4),
                                        'cf_acc'   => $cfAcc,
                                    ];
                                }
                            @endphp

                            {{-- TAHAP 1: CF Final per gejala = CF Pakar × CF User --}}
                            <div class="p-3 rounded-xl mb-3"
                                 style="background: rgba(99,102,241,0.06); border: 1px solid rgba(99,102,241,0.15);">
                                <p class="text-[10px] uppercase tracking-widest text-indigo-400 mb-2 font-bold">
                                    Tahap 1 — CF Final per Gejala = CF<sub>pakar</sub> × CF<sub>user</sub>
                                </p>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-[10px]">
                                        <thead>
                                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                                                <th class="text-left py-1.5 text-slate-500 font-medium pr-3">Kode</th>
                                                <th class="text-center py-1.5 text-slate-500 font-medium px-2">CF Pakar</th>
                                                <th class="text-center py-1.5 text-slate-500 font-medium px-2">× CF User</th>
                                                <th class="text-center py-1.5 text-slate-500 font-medium px-2">=</th>
                                                <th class="text-center py-1.5 text-emerald-500 font-bold px-2">CF Final</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cfSteps as $step)
                                            @php
                                                $cfUserLabel = match(true) {
                                                    $step['cf_user'] >= 1.0  => ['label' => 'Sangat Yakin', 'color' => '#ef4444'],
                                                    $step['cf_user'] >= 0.8  => ['label' => 'Yakin',        'color' => '#f97316'],
                                                    $step['cf_user'] >= 0.6  => ['label' => 'Cukup Yakin',  'color' => '#eab308'],
                                                    $step['cf_user'] >= 0.4  => ['label' => 'Kurang Yakin', 'color' => '#6366f1'],
                                                    default                  => ['label' => 'Tidak Yakin',  'color' => '#64748b'],
                                                };
                                            @endphp
                                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                                                <td class="py-2 font-mono text-indigo-300 pr-3">{{ $step['kode'] }}</td>
                                                <td class="py-2 text-center font-mono text-slate-300 px-2">{{ $step['cf_pakar'] }}</td>
                                                <td class="py-2 text-center px-2">
                                                    <span class="font-mono font-bold" style="color:{{ $cfUserLabel['color'] }};">
                                                        {{ $step['cf_user'] }}
                                                    </span>
                                                    <span class="text-slate-600 ml-1">({{ $cfUserLabel['label'] }})</span>
                                                </td>
                                                <td class="py-2 text-center text-slate-600 px-2">=</td>
                                                <td class="py-2 text-center font-mono font-bold text-emerald-400 px-2">{{ $step['cf_final'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- TAHAP 2: Kombinasi iteratif --}}
                            <div class="p-3 rounded-xl mb-3"
                                 style="background: rgba(16,185,129,0.06); border: 1px solid rgba(16,185,129,0.15);">
                                <p class="text-[10px] uppercase tracking-widest text-emerald-500 mb-2 font-bold">
                                    Tahap 2 — Kombinasi CF Iteratif
                                </p>
                                <p class="font-mono text-[10px] text-emerald-300 mb-3">
                                    CF<sub>combine</sub> = CF<sub>lama</sub> + CF<sub>final</sub> × (1 − CF<sub>lama</sub>)
                                </p>

                                <div class="space-y-2">
                                    @foreach($cfSteps as $step)
                                    <div class="p-2.5 rounded-xl"
                                         style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold flex-shrink-0"
                                                  style="background:rgba(16,185,129,0.2); color:#34d399;">{{ $step['step'] }}</span>
                                            <span class="font-mono text-[10px] text-indigo-300">{{ $step['kode'] }}</span>
                                            <span class="text-[10px] text-slate-600 ml-auto">
                                                CF<sub>final</sub> = <strong class="text-emerald-400">{{ $step['cf_final'] }}</strong>
                                            </span>
                                        </div>
                                        <div class="font-mono text-[10px] leading-relaxed pl-7" style="color:#94a3b8;">
                                            @if($step['step'] === 1)
                                            <span class="text-slate-600">CF<sub>lama</sub> = 0 (nilai awal)</span><br>
                                            @endif
                                            CF = {{ $step['cf_old'] }} + {{ $step['cf_final'] }} &times; (1 &minus; {{ $step['cf_old'] }})<br>
                                            CF = {{ $step['cf_old'] }} + {{ round($step['cf_final'] * (1 - $step['cf_old']), 4) }}<br>
                                            <span class="text-emerald-400 font-bold">CF = {{ $step['cf_acc'] }}</span>
                                            <span class="text-slate-600 ml-2">({{ round($step['cf_acc'] * 100, 2) }}%)</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Hasil akhir --}}
                            <div class="p-3 rounded-xl flex items-center justify-between gap-3"
                                 style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3);">
                                <div>
                                    <p class="text-[10px] text-emerald-600 uppercase tracking-wider mb-0.5">CF Akhir</p>
                                    <p class="font-mono text-base font-bold text-emerald-400">{{ $hasil['cf_gabungan'] }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] text-emerald-600 uppercase tracking-wider mb-0.5">Persentase</p>
                                    <p class="font-display font-bold text-2xl" style="color:{{ $badgeColor }};">{{ number_format($persen, 1) }}%</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-emerald-600 uppercase tracking-wider mb-0.5">Interpretasi</p>
                                    <p class="text-sm font-semibold" style="color:{{ $badgeColor }};">{{ $interpret['icon'] }} {{ $interpret['label'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- ⬆️ end detail CF --}}

            </div>
            @endforeach
        </div>

        <!-- RIGHT: Sidebar -->
        <div class="space-y-5">

            <!-- Summary Donut / Top Result -->
            @if(!empty($hasilDiagnosa))
            @php $topResult = $hasilDiagnosa[0]; 
                $topIconSvgMap = [
                    '🖥️' => '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>',
                    '⌨️' => '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="M6 8h.001"/><path d="M10 8h.001"/><path d="M14 8h.001"/><path d="M18 8h.001"/><path d="M8 12h.001"/><path d="M12 12h.001"/><path d="M16 12h.001"/><path d="M7 16h10"/></svg>',
                    '🧠' => '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="8" width="16" height="8" rx="2"/><path d="M8 8V6a2 2 0 0 1 4 0v2"/><path d="M12 8V6a2 2 0 0 1 4 0v2"/><path d="M8 16v2a2 2 0 0 0 4 0v-2"/><path d="M12 16v2a2 2 0 0 0 4 0v-2"/></svg>',
                    '🔌' => '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 3v4"/><path d="M19 3v4"/><path d="M5 7h14"/><path d="M12 7v10"/><path d="M9 17h6"/></svg>',
                    '💾' => '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14a9 3 0 0 0 18 0V5"/><path d="M3 12a9 3 0 0 0 18 0"/></svg>',
                    '🖱️' => '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="7"/><path d="M12 2v8"/><path d="M5 10h14"/></svg>',
                    '🌀' => '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M12 2a10 10 0 0 1 7.38 16.75"/><path d="M12 22a10 10 0 0 1 -7.38 -16.75"/></svg>',
                    '📷' => '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>',
                    '🔋' => '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="10" x="2" y="7" rx="2"/><line x1="22" x2="22" y1="11" y2="13"/><line x1="6" x2="6" y1="11" y2="13"/></svg>',
                    '🔧' => '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M12 2v2"/><path d="M12 22v-2"/><path d="m17 20.66-1-1.73"/><path d="M11 10.27 7 3.34"/><path d="m20.66 17-1.73-1"/><path d="m3.34 7 1.73 1"/><path d="M14 12h8"/><path d="M2 12h2"/><path d="m20.66 7-1.73 1"/><path d="m3.34 17 1.73-1"/><path d="m17 3.34-1 1.73"/><path d="m11 13.73-4 6.93"/></svg>',
                    '🔊' => '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>',
                ];
                $topIconSvg = $topIconSvgMap[$topResult['icon'] ?? '🔧'] ?? $topIconSvgMap['🔧'];
            @endphp
            <div class="glass rounded-2xl p-5" style="border: 1px solid rgba(99, 102, 241, 0.25);">
                <h3 class="font-semibold text-white text-sm mb-4 inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>
                    Diagnosa Terkuat
                </h3>
                <div class="text-center py-4">
                    <div class="flex justify-center mb-3 text-indigo-400">{!! $topIconSvg !!}</div>
                    <div class="font-display font-bold text-xl text-white mb-1">{{ $topResult['nama'] }}</div>
                    <div class="font-display font-bold text-4xl mb-1"
                         style="background: linear-gradient(135deg, #f87171, #fb923c); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">
                        {{ number_format($topResult['persentase'], 1) }}%
                    </div>
                    <div class="text-slate-500 text-xs">Tingkat Keyakinan CF</div>
                </div>
                <div class="section-divider my-4"></div>
                <div class="space-y-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Kode Kerusakan</span>
                        <span class="font-mono text-indigo-400">{{ $topResult['kode'] }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Status</span>
                        <span class="text-red-400 font-medium">{{ $topResult['interpretasi']['label'] }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Est. Biaya</span>
                        <span class="text-white font-medium">Rp {{ number_format($topResult['estimasi_total_min'], 0, ',', '.') }}+</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- All Results CF Summary -->
            <div class="glass rounded-2xl p-5" style="border: 1px solid rgba(255,255,255,0.07);">
                <h3 class="font-semibold text-white text-sm mb-4 inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                    Ringkasan CF Semua Kerusakan
                </h3>
                <div class="space-y-3">
                    @foreach($hasilDiagnosa as $idx => $h)
                    @php
                        $bc = match($h['interpretasi']['label']) {
                            'Sangat Yakin' => '#ef4444',
                            'Yakin' => '#f97316',
                            'Cukup Yakin' => '#eab308',
                            'Kurang Yakin' => '#6366f1',
                            default => '#64748b',
                        };
                        $cfBarCls = match($h['interpretasi']['label']) {
                            'Sangat Yakin' => 'cf-bar-critical',
                            'Yakin' => 'cf-bar-high',
                            'Cukup Yakin' => 'cf-bar-medium',
                            'Kurang Yakin' => 'cf-bar-low',
                            default => 'cf-bar-minor',
                        };
                        $hIconSvgMap = [
                            '🖥️' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>',
                            '⌨️' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="M6 8h.001"/><path d="M10 8h.001"/><path d="M14 8h.001"/><path d="M18 8h.001"/><path d="M8 12h.001"/><path d="M12 12h.001"/><path d="M16 12h.001"/><path d="M7 16h10"/></svg>',
                            '🧠' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="8" width="16" height="8" rx="2"/><path d="M8 8V6a2 2 0 0 1 4 0v2"/><path d="M12 8V6a2 2 0 0 1 4 0v2"/><path d="M8 16v2a2 2 0 0 0 4 0v-2"/><path d="M12 16v2a2 2 0 0 0 4 0v-2"/></svg>',
                            '🔌' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 3v4"/><path d="M19 3v4"/><path d="M5 7h14"/><path d="M12 7v10"/><path d="M9 17h6"/></svg>',
                            '💾' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14a9 3 0 0 0 18 0V5"/><path d="M3 12a9 3 0 0 0 18 0"/></svg>',
                            '🖱️' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="7"/><path d="M12 2v8"/><path d="M5 10h14"/></svg>',
                            '🌀' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M12 2a10 10 0 0 1 7.38 16.75"/><path d="M12 22a10 10 0 0 1 -7.38 -16.75"/></svg>',
                            '📷' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>',
                            '🔋' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="10" x="2" y="7" rx="2"/><line x1="22" x2="22" y1="11" y2="13"/><line x1="6" x2="6" y1="11" y2="13"/></svg>',
                            '🔧' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M12 2v2"/><path d="M12 22v-2"/><path d="m17 20.66-1-1.73"/><path d="M11 10.27 7 3.34"/><path d="m20.66 17-1.73-1"/><path d="m3.34 7 1.73 1"/><path d="M14 12h8"/><path d="M2 12h2"/><path d="m20.66 7-1.73 1"/><path d="m3.34 17 1.73-1"/><path d="m17 3.34-1 1.73"/><path d="m11 13.73-4 6.93"/></svg>',
                            '🔊' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>',
                        ];
                        $hIconSvg = $hIconSvgMap[$h['icon'] ?? '🔧'] ?? $hIconSvgMap['🔧'];
                    @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400" style="color: {{ $bc }};">{!! $hIconSvg !!}</span>
                                <span class="text-xs text-slate-300">{{ $h['nama'] }}</span>
                            </div>
                            <span class="text-xs font-semibold" style="color: {{ $bc }};">
                                {{ number_format($h['persentase'], 1) }}%
                            </span>
                        </div>
                        <div class="cf-bar-container" style="height: 6px;">
                            <div class="cf-bar-fill {{ $cfBarCls }}" 
                                 data-width="{{ $h['persentase'] }}"
                                 style="width: 0%;"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Gejala Dipilih -->
            <div class="glass rounded-2xl p-5" style="border: 1px solid rgba(255,255,255,0.07);">
                <h3 class="font-semibold text-white text-sm mb-4 inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    Gejala yang Dianalisa
                    <span class="text-slate-500 font-normal">({{ count($kodeGejala) }})</span>
                </h3>
                <div class="space-y-2 max-h-64 overflow-y-auto">
                    @foreach($gejalaDipilih as $g)
                    <div class="flex items-start gap-2 p-2 rounded-lg" style="background: rgba(255,255,255,0.03);">
                        <span class="text-indigo-400 text-xs flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span class="text-xs text-slate-400 leading-relaxed">{{ $g->deskripsi }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2">
                <a href="{{ route('diagnosa.form') }}" 
                   class="btn-primary w-full flex items-center justify-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
                    Diagnosa Ulang
                </a>

                {{-- Tombol Tanya Chatbot --}}
                <button onclick="chatbotSendText('{{ $hasilDiagnosa[0]['nama'] ?? 'kerusakan laptop' }}')"
                        class="w-full flex items-center justify-center gap-2 text-sm font-medium py-2 px-4 rounded-xl transition-all duration-200"
                        style="background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.35); color: #a5b4fc;"
                        onmouseover="this.style.background='rgba(99,102,241,0.28)'"
                        onmouseout="this.style.background='rgba(99,102,241,0.15)'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Tanya LaptopBot
                </button>

                {{-- Tombol Hubungi Admin --}}
                <button onclick="chatbotOpenAdmin()"
                        class="w-full flex items-center justify-center gap-2 text-sm font-medium py-2 px-4 rounded-xl transition-all duration-200"
                        style="background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #4ade80;"
                        onmouseover="this.style.background='rgba(34,197,94,0.22)'"
                        onmouseout="this.style.background='rgba(34,197,94,0.1)'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.115.549 4.099 1.51 5.826L.057 23.571 6 22.105A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.846 0-3.575-.493-5.072-1.355l-.359-.214-3.749.984.999-3.648-.235-.374A9.934 9.934 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                    Hubungi Admin via WhatsApp
                </button>

                {{-- Tombol Cara Kerja Mesin Inferensi --}}
                <button onclick="openInferenceModal()"
                        class="w-full flex items-center justify-center gap-2 text-sm font-medium py-2 px-4 rounded-xl transition-all duration-200"
                        style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #34d399;"
                        onmouseover="this.style.background='rgba(16,185,129,0.2)'"
                        onmouseout="this.style.background='rgba(16,185,129,0.1)'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                        <path d="M12 16v-4"/><path d="M12 8h.01"/>
                    </svg>
                    Cara Kerja Mesin Inferensi
                </button>

                <a href="{{ route('home') }}" 
                   class="btn-outline w-full flex items-center justify-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- ============================================================
     MODAL: CARA KERJA MESIN INFERENSI
     ============================================================ --}}
<div id="inference-modal"
     class="fixed inset-0 z-[9000] flex items-center justify-center p-4 hidden"
     onclick="if(event.target===this) closeInferenceModal()">
    {{-- Backdrop --}}
    <div class="absolute inset-0" style="background: rgba(0,0,0,0.75); backdrop-filter: blur(6px);"></div>

    {{-- Modal Box --}}
    <div class="relative w-full max-w-2xl max-h-[85vh] overflow-y-auto rounded-3xl"
         style="background: #0f172a; border: 1px solid rgba(99,102,241,0.3);"
         onclick="event.stopPropagation()">

        {{-- Header stripe --}}
        <div class="h-1 rounded-t-3xl" style="background: linear-gradient(90deg, #10b981, #6366f1, #ec4899);"></div>

        <div class="p-6 md:p-8">
            {{-- Title --}}
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <h2 class="font-display font-bold text-xl text-white mb-1">
                        Cara Kerja Mesin Inferensi
                    </h2>
                    <p class="text-slate-400 text-sm">Forward Chaining + Certainty Factor</p>
                </div>
                <button onclick="closeInferenceModal()"
                        class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center transition-colors"
                        style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);"
                        onmouseover="this.style.background='rgba(255,255,255,0.12)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.06)'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                         fill="none" stroke="#94a3b8" stroke-width="2.5">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Alur Forward Chaining --}}
            <div class="mb-5">
                <p class="text-xs font-bold uppercase tracking-widest text-indigo-400 mb-3">① Alur Forward Chaining</p>
                <div class="space-y-2">
                    @php
                    $steps = [
                        ['icon' => '📝', 'label' => 'Input Fakta', 'desc' => 'Pengguna memilih '.count($kodeGejala).' gejala yang dialami sebagai fakta awal.'],
                        ['icon' => '🔍', 'label' => 'Pencocokan Aturan (Matching)', 'desc' => 'Sistem memeriksa seluruh rule di basis pengetahuan — aturan mana yang premisnya (gejala) cocok dengan fakta.'],
                        ['icon' => '⚡', 'label' => 'Eksekusi Aturan (Firing)', 'desc' => 'Setiap aturan yang cocok dieksekusi — kerusakan yang menjadi konklusi aturan tersebut diaktifkan.'],
                        ['icon' => '🧮', 'label' => 'Hitung CF per Kerusakan', 'desc' => 'Nilai Certainty Factor dari semua gejala yang cocok dikombinasikan secara iteratif menggunakan rumus CF.'],
                        ['icon' => '📊', 'label' => 'Peringkat Hasil', 'desc' => 'Semua kerusakan yang teridentifikasi diurutkan berdasarkan nilai CF gabungan tertinggi.'],
                    ];
                    @endphp
                    @foreach($steps as $si => $s)
                    <div class="flex gap-3 p-3 rounded-xl"
                         style="background: rgba(99,102,241,0.06); border: 1px solid rgba(99,102,241,0.1);">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold"
                             style="background: rgba(99,102,241,0.2); color: #a5b4fc;">{{ $si+1 }}</div>
                        <div>
                            <p class="text-xs font-semibold text-slate-200 mb-0.5">{{ $s['icon'] }} {{ $s['label'] }}</p>
                            <p class="text-xs text-slate-500">{{ $s['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Rumus CF --}}
            <div class="mb-5">
                <p class="text-xs font-bold uppercase tracking-widest text-emerald-400 mb-3">② Rumus Certainty Factor</p>

                <div class="p-4 rounded-xl mb-3"
                     style="background: rgba(16,185,129,0.07); border: 1px solid rgba(16,185,129,0.2);">
                    <p class="text-xs text-slate-400 mb-2">Formula kombinasi (keduanya positif — kasus umum):</p>
                    <p class="font-mono text-sm text-emerald-300 font-bold text-center py-2">
                        CF<sub>combine</sub> = CF<sub>lama</sub> + CF<sub>baru</sub> &times; (1 &minus; CF<sub>lama</sub>)
                    </p>
                    <div class="mt-3 grid grid-cols-2 gap-2 text-[10px]">
                        <div class="p-2 rounded-lg" style="background: rgba(255,255,255,0.04);">
                            <p class="text-slate-500 mb-0.5">Keduanya negatif:</p>
                            <p class="font-mono text-emerald-400">CF = CF₁ + CF₂ × (1 + CF₁)</p>
                        </div>
                        <div class="p-2 rounded-lg" style="background: rgba(255,255,255,0.04);">
                            <p class="text-slate-500 mb-0.5">Campuran:</p>
                            <p class="font-mono text-emerald-400">CF = (CF₁ + CF₂) / (1 − min|CF|)</p>
                        </div>
                    </div>
                </div>

                {{-- Contoh Ilustrasi Numerik --}}
                <p class="text-xs text-slate-500 mb-2">Contoh iterasi dengan 3 gejala:</p>
                <div class="space-y-1.5">
                    <div class="flex items-center gap-2 font-mono text-xs p-2 rounded-lg"
                         style="background:rgba(255,255,255,0.03);">
                        <span class="text-slate-600 w-6 text-center">1</span>
                        <span class="text-slate-500">combine(0.00, 0.80)</span>
                        <span class="text-slate-600">=</span>
                        <span class="text-slate-500">0.00 + 0.80×(1−0.00)</span>
                        <span class="text-slate-600">=</span>
                        <span class="text-emerald-400 font-bold">0.80</span>
                    </div>
                    <div class="flex items-center gap-2 font-mono text-xs p-2 rounded-lg"
                         style="background:rgba(255,255,255,0.03);">
                        <span class="text-slate-600 w-6 text-center">2</span>
                        <span class="text-slate-500">combine(0.80, 0.70)</span>
                        <span class="text-slate-600">=</span>
                        <span class="text-slate-500">0.80 + 0.70×(1−0.80)</span>
                        <span class="text-slate-600">=</span>
                        <span class="text-emerald-400 font-bold">0.94</span>
                    </div>
                    <div class="flex items-center gap-2 font-mono text-xs p-2 rounded-lg"
                         style="background:rgba(255,255,255,0.03);">
                        <span class="text-slate-600 w-6 text-center">3</span>
                        <span class="text-slate-500">combine(0.94, 0.60)</span>
                        <span class="text-slate-600">=</span>
                        <span class="text-slate-500">0.94 + 0.60×(1−0.94)</span>
                        <span class="text-slate-600">=</span>
                        <span class="text-emerald-400 font-bold">0.976</span>
                    </div>
                    <div class="text-right font-mono text-xs text-emerald-300 pr-2">
                        → Keyakinan: <strong>97.6%</strong> (Sangat Yakin 🔴)
                    </div>
                </div>
            </div>

            {{-- Tabel Interpretasi CF --}}
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-violet-400 mb-3">③ Tabel Interpretasi Nilai CF</p>
                <table class="w-full text-xs">
                    <thead>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                            <th class="text-left py-2 text-slate-500 font-medium">Rentang CF</th>
                            <th class="text-left py-2 text-slate-500 font-medium">Persentase</th>
                            <th class="text-left py-2 text-slate-500 font-medium">Label</th>
                            <th class="text-left py-2 text-slate-500 font-medium">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="space-y-1">
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                            <td class="py-2 font-mono text-slate-300">0.80 – 1.00</td>
                            <td class="py-2 text-red-400 font-bold">80% – 100%</td>
                            <td class="py-2"><span class="px-2 py-0.5 rounded-full text-[10px]" style="background:rgba(239,68,68,0.2);color:#f87171;">🔴 Sangat Yakin</span></td>
                            <td class="py-2 text-slate-500">Segera servis</td>
                        </tr>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                            <td class="py-2 font-mono text-slate-300">0.60 – 0.79</td>
                            <td class="py-2 text-orange-400 font-bold">60% – 79%</td>
                            <td class="py-2"><span class="px-2 py-0.5 rounded-full text-[10px]" style="background:rgba(249,115,22,0.2);color:#fb923c;">🟠 Yakin</span></td>
                            <td class="py-2 text-slate-500">Direkomendasikan servis</td>
                        </tr>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                            <td class="py-2 font-mono text-slate-300">0.40 – 0.59</td>
                            <td class="py-2 text-yellow-400 font-bold">40% – 59%</td>
                            <td class="py-2"><span class="px-2 py-0.5 rounded-full text-[10px]" style="background:rgba(234,179,8,0.2);color:#facc15;">🟡 Cukup Yakin</span></td>
                            <td class="py-2 text-slate-500">Perlu observasi lanjut</td>
                        </tr>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                            <td class="py-2 font-mono text-slate-300">0.20 – 0.39</td>
                            <td class="py-2 text-indigo-400 font-bold">20% – 39%</td>
                            <td class="py-2"><span class="px-2 py-0.5 rounded-full text-[10px]" style="background:rgba(99,102,241,0.2);color:#818cf8;">🔵 Kurang Yakin</span></td>
                            <td class="py-2 text-slate-500">Cek gejala lebih detail</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-mono text-slate-300">0.00 – 0.19</td>
                            <td class="py-2 text-slate-400 font-bold">&lt; 20%</td>
                            <td class="py-2"><span class="px-2 py-0.5 rounded-full text-[10px]" style="background:rgba(100,116,139,0.2);color:#94a3b8;">⚪ Tidak Yakin</span></td>
                            <td class="py-2 text-slate-500">Diabaikan</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Close button --}}
            <div class="mt-6 text-center">
                <button onclick="closeInferenceModal()"
                        class="btn-primary px-8 text-sm">
                    Mengerti, Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Animate CF bars on load
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.querySelectorAll('.cf-bar-fill[data-width]').forEach(bar => {
                const width = bar.getAttribute('data-width');
                bar.style.width = Math.min(parseFloat(width), 100) + '%';
            });
        }, 300);
    });

    function toggleSolution(btn, targetId) {
        const el = document.getElementById(targetId);
        const index = targetId.replace('sol-', '');
        const arrow = document.getElementById(`arrow-${index}`);
        el.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    /* ---- Toggle Detail CF ---- */
    function toggleCFDetail(id) {
        const panel = document.getElementById(id);
        const idx   = id.replace('cfdetail-', '');
        const chev  = document.getElementById('cf-chev-' + idx);
        const hidden = panel.classList.contains('hidden');
        panel.classList.toggle('hidden', !hidden);
        chev.style.transform = hidden ? 'rotate(180deg)' : '';
    }

    /* ---- Modal Mesin Inferensi ---- */
    function openInferenceModal() {
        const m = document.getElementById('inference-modal');
        m.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // small entrance animation
        m.querySelector('[onclick="event.stopPropagation()"]').style.opacity = '0';
        m.querySelector('[onclick="event.stopPropagation()"]').style.transform = 'scale(0.95) translateY(16px)';
        setTimeout(() => {
            m.querySelector('[onclick="event.stopPropagation()"]').style.transition = 'all 0.25s cubic-bezier(0.4,0,0.2,1)';
            m.querySelector('[onclick="event.stopPropagation()"]').style.opacity = '1';
            m.querySelector('[onclick="event.stopPropagation()"]').style.transform = 'scale(1) translateY(0)';
        }, 10);
    }
    function closeInferenceModal() {
        const m = document.getElementById('inference-modal');
        m.classList.add('hidden');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeInferenceModal();
    });
</script>
@endpush

@endsection
