@extends('layouts.app')

@section('title', 'Detail Riwayat Diagnosa #' . $sesi->id . ' — Sistem Pakar Laptop')
@section('description', 'Detail lengkap sesi diagnosa kerusakan laptop untuk ' . ($sesi->nama_pengguna ?? 'Anonim') . ' menggunakan metode Forward Chaining dan Certainty Factor.')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-slate-500 text-sm mb-6">
        <a href="{{ route('home') }}" class="hover:text-indigo-400 transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('diagnosa.riwayat') }}" class="hover:text-indigo-400 transition-colors">Riwayat</a>
        <span>/</span>
        <span class="text-slate-300">Detail #{{ $sesi->id }}</span>
    </div>

    {{-- ── Header Card ── --}}
    <div class="glass rounded-3xl p-6 md:p-8 mb-8 relative overflow-hidden"
         style="border: 1px solid rgba(99,102,241,0.25);">
        {{-- Top gradient stripe --}}
        <div class="absolute top-0 left-0 right-0 h-1 rounded-t-3xl"
             style="background: linear-gradient(90deg, #4f46e5, #7c3aed, #ec4899);"></div>

        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
            <div class="flex-1">
                {{-- Icon + Title --}}
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                         style="background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="#818cf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/>
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                            <path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-display font-bold text-2xl md:text-3xl text-white">
                            Detail Riwayat Diagnosa
                        </h1>
                        <p class="text-slate-400 text-sm mt-0.5">
                            Sesi #{{ $sesi->id }} &mdash; {{ $sesi->created_at->format('d M Y, H:i') }} WIB
                        </p>
                    </div>
                </div>

                {{-- Meta badges --}}
                <div class="flex flex-wrap gap-2">
                    @if($namaUser && $namaUser !== 'Anonim')
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs"
                         style="background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                             fill="none" stroke="#818cf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/>
                        </svg>
                        <span class="text-slate-300">{{ $namaUser }}</span>
                    </div>
                    @endif

                    @if($namaLaptop && $namaLaptop !== 'Tidak diketahui')
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs"
                         style="background: rgba(124,58,237,0.15); border: 1px solid rgba(124,58,237,0.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                             fill="none" stroke="#a78bfa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="12" x="3" y="4" rx="2"/><line x1="2" x2="22" y1="20" y2="20"/>
                        </svg>
                        <span class="text-slate-300">{{ $namaLaptop }}</span>
                    </div>
                    @endif

                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs"
                         style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                             fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                        </svg>
                        <span class="text-slate-300">{{ count($kodeGejala) }} gejala dianalisa</span>
                    </div>

                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs"
                         style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                             fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/>
                            <line x1="6" x2="6" y1="20" y2="14"/>
                        </svg>
                        <span class="text-slate-300">{{ count($hasilDiagnosa) }} kerusakan teridentifikasi</span>
                    </div>

                    @if($sesi->ip_address)
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs"
                         style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                             fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                            <path d="M2 12h20"/>
                        </svg>
                        <span class="text-slate-300">{{ $sesi->ip_address }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="flex flex-wrap gap-2">
                <button onclick="window.print()"
                        class="btn-outline text-sm inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect width="12" height="8" x="6" y="14"/>
                    </svg>
                    Cetak
                </button>
                <a href="{{ route('diagnosa.riwayat') }}"
                   class="btn-outline text-sm inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5"/><path d="m12 19-7-7 7-7"/>
                    </svg>
                    Kembali ke Riwayat
                </a>
                <a href="{{ route('diagnosa.form') }}"
                   class="btn-primary text-sm inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                        <path d="M21 3v5h-5"/>
                        <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                        <path d="M8 16H3v5"/>
                    </svg>
                    Diagnosa Ulang
                </a>
            </div>
        </div>
    </div>

    @if(empty($hasilDiagnosa))
    {{-- ── No Result State ── --}}
    <div class="text-center py-20">
        <div class="flex justify-center mb-6 text-slate-600 floating">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                <path d="M11 8v3"/><path d="M11 14h.01"/>
            </svg>
        </div>
        <h2 class="font-display font-bold text-2xl text-white mb-4">Tidak Ada Hasil Diagnosa</h2>
        <p class="text-slate-400 mb-8">Data sesi ini tidak memiliki hasil diagnosa yang tersimpan.</p>
        <a href="{{ route('diagnosa.form') }}" class="btn-primary inline-flex items-center gap-2">
            Coba Diagnosa Baru
        </a>
    </div>
    @else

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── LEFT: Hasil Diagnosa ── --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="flex items-center justify-between mb-2">
                <h2 class="font-display font-bold text-xl text-white">
                    Hasil Analisa
                    <span class="gradient-text">({{ count($hasilDiagnosa) }} Kerusakan)</span>
                </h2>
                <div class="text-xs text-slate-500">Diurutkan: CF Tertinggi</div>
            </div>

            @php
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
            @endphp

            @foreach($hasilDiagnosa as $index => $hasil)
            @php
                $interpret     = $hasil['interpretasi'];
                $persen        = $hasil['persentase'];
                $cfBarClass    = match($interpret['label']) {
                    'Sangat Yakin' => 'cf-bar-critical',
                    'Yakin'        => 'cf-bar-high',
                    'Cukup Yakin'  => 'cf-bar-medium',
                    'Kurang Yakin' => 'cf-bar-low',
                    default        => 'cf-bar-minor',
                };
                $badgeBg     = match($interpret['label']) {
                    'Sangat Yakin' => 'rgba(239,68,68,0.2)',
                    'Yakin'        => 'rgba(249,115,22,0.2)',
                    'Cukup Yakin'  => 'rgba(234,179,8,0.2)',
                    'Kurang Yakin' => 'rgba(99,102,241,0.2)',
                    default        => 'rgba(100,116,139,0.2)',
                };
                $badgeBorder = match($interpret['label']) {
                    'Sangat Yakin' => 'rgba(239,68,68,0.4)',
                    'Yakin'        => 'rgba(249,115,22,0.4)',
                    'Cukup Yakin'  => 'rgba(234,179,8,0.4)',
                    'Kurang Yakin' => 'rgba(99,102,241,0.4)',
                    default        => 'rgba(100,116,139,0.4)',
                };
                $badgeColor  = match($interpret['label']) {
                    'Sangat Yakin' => '#f87171',
                    'Yakin'        => '#fb923c',
                    'Cukup Yakin'  => '#facc15',
                    'Kurang Yakin' => '#818cf8',
                    default        => '#94a3b8',
                };
                $iconSvg = $iconSvgMap[$hasil['icon'] ?? '🔧'] ?? $iconSvgMap['🔧'];
            @endphp

            <div class="result-card glass animate-fadeInUp"
                 style="border: 1px solid {{ $badgeBorder }}; animation-delay: {{ $index * 0.1 }}s;"
                 id="result-{{ $index }}">

                <div class="p-5 md:p-6">
                    {{-- Card Header --}}
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
                                 style="background:{{ $badgeBg }}; border:1px solid {{ $badgeBorder }}; color:{{ $badgeColor }};">
                                {!! $iconSvg !!}
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-mono text-slate-500">{{ $hasil['kode'] }}</span>
                                    @if($index === 0)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold inline-flex items-center gap-1"
                                          style="background:rgba(99,102,241,0.2); color:#a5b4fc; border:1px solid rgba(99,102,241,0.3);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/>
                                            <path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/>
                                            <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/>
                                            <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/>
                                        </svg>
                                        DIAGNOSA UTAMA
                                    </span>
                                    @endif
                                </div>
                                <h3 class="font-display font-bold text-xl text-white">{{ $hasil['nama'] }}</h3>
                                <p class="text-slate-400 text-xs mt-1">{{ $hasil['total_gejala'] }} gejala cocok terdeteksi</p>
                            </div>
                        </div>

                        {{-- CF Badge --}}
                        <div class="text-right flex-shrink-0">
                            <div class="result-card-badge mb-1"
                                 style="background:{{ $badgeBg }}; border:1px solid {{ $badgeBorder }}; color:{{ $badgeColor }};">
                                {{ $interpret['icon'] }} {{ $interpret['badge'] }}
                            </div>
                            <div class="font-display font-bold text-2xl" style="color:{{ $badgeColor }};">
                                {{ number_format($persen, 1) }}%
                            </div>
                            <div class="text-xs text-slate-500">Certainty Factor</div>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-slate-500 mb-1.5">
                            <span>Tingkat Keyakinan</span>
                            <span class="font-medium" style="color:{{ $badgeColor }};">{{ $interpret['label'] }}</span>
                        </div>
                        <div class="cf-bar-container">
                            <div class="cf-bar-fill {{ $cfBarClass }}"
                                 data-width="{{ $persen }}"
                                 style="width: 0%;"></div>
                        </div>
                    </div>

                    {{-- Gejala Cocok --}}
                    <div class="mb-4">
                        <p class="text-xs text-slate-500 mb-2">Gejala yang Cocok:</p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($hasil['gejala_cocok'] as $gc)
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium"
                                  style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); color:#94a3b8;">
                                <span class="font-mono text-[10px] mr-1 opacity-60">{{ $gc['kode'] }}</span>
                                CF: {{ number_format($gc['cf_nilai'] * 100, 0) }}%
                            </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Komponen & Biaya --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                        <div class="p-3 rounded-xl"
                             style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06);">
                            <p class="text-[10px] text-slate-500 mb-1 uppercase tracking-wider">Komponen Pengganti</p>
                            <p class="text-xs text-slate-300 leading-relaxed">{{ $hasil['komponen_pengganti'] }}</p>
                        </div>
                        <div class="p-3 rounded-xl"
                             style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06);">
                            <p class="text-[10px] text-slate-500 mb-1 uppercase tracking-wider">Estimasi Biaya Total</p>
                            <p class="text-sm font-semibold text-white">
                                Rp {{ number_format($hasil['estimasi_total_min'], 0, ',', '.') }}
                                <span class="text-slate-500 text-xs font-normal"> – </span>
                                Rp {{ number_format($hasil['estimasi_total_max'], 0, ',', '.') }}
                            </p>
                            @if($hasil['service_fee'] > 0)
                            <p class="text-[10px] text-slate-600 mt-0.5">
                                Part: Rp {{ number_format($hasil['est_part_min'], 0, ',', '.') }}–{{ number_format($hasil['est_part_max'], 0, ',', '.') }}
                                + Jasa: Rp {{ number_format($hasil['service_fee'], 0, ',', '.') }}
                            </p>
                            @endif
                        </div>
                    </div>

                    {{-- Solusi / Langkah Penanganan --}}
                    @if(!empty($hasil['solutions']))
                    <div>
                        <button type="button"
                                onclick="toggleSolutions('sol-{{ $index }}')"
                                class="flex items-center gap-2 text-xs text-indigo-400 hover:text-indigo-300 transition-colors mb-2 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                                <path d="M12 16v-4"/><path d="M12 8h.01"/>
                            </svg>
                            <span id="sol-label-{{ $index }}">Tampilkan Langkah Penanganan</span>
                            <svg id="sol-chevron-{{ $index }}" xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                 class="transition-transform duration-200">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>
                        <div id="sol-{{ $index }}" class="hidden">
                            <ol class="space-y-2">
                                @foreach($hasil['solutions'] as $step => $sol)
                                <li class="flex gap-3 text-xs text-slate-400">
                                    <span class="flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold mt-0.5"
                                          style="background:{{ $badgeBg }}; color:{{ $badgeColor }}; border:1px solid {{ $badgeBorder }};">
                                        {{ $step + 1 }}
                                    </span>
                                    <span class="leading-relaxed">{{ $sol }}</span>
                                </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- ── RIGHT SIDEBAR ── --}}
        <div class="space-y-5">

            {{-- Ringkasan Sesi --}}
            <div class="glass rounded-2xl p-5" style="border:1px solid rgba(255,255,255,0.07);">
                <h3 class="font-display font-semibold text-white text-sm mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="#818cf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="8" height="4" x="8" y="2" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                        <path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/>
                    </svg>
                    Ringkasan Sesi
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">ID Sesi</span>
                        <span class="text-slate-300 font-mono">#{{ $sesi->id }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Tanggal</span>
                        <span class="text-slate-300">{{ $sesi->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Waktu</span>
                        <span class="text-slate-300">{{ $sesi->created_at->format('H:i') }} WIB</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Nama Pengguna</span>
                        <span class="text-slate-300">{{ $namaUser }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Laptop</span>
                        <span class="text-slate-300 text-right max-w-[120px] truncate">{{ $namaLaptop }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Gejala Dipilih</span>
                        <span class="text-slate-300">{{ count($kodeGejala) }} gejala</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Kerusakan Ditemukan</span>
                        <span class="text-slate-300">{{ count($hasilDiagnosa) }}</span>
                    </div>
                    @if(count($hasilDiagnosa) > 0)
                    <div class="section-divider my-1"></div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">CF Tertinggi</span>
                        <span class="text-indigo-400 font-bold">{{ number_format($hasilDiagnosa[0]['persentase'], 1) }}%</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Diagnosa Utama</span>
                        <span class="text-slate-200 font-medium text-right max-w-[120px]">{{ $hasilDiagnosa[0]['nama'] }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Gejala yang Dipilih --}}
            <div class="glass rounded-2xl p-5" style="border:1px solid rgba(255,255,255,0.07);">
                <h3 class="font-display font-semibold text-white text-sm mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="#818cf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                    </svg>
                    Gejala yang Dilaporkan
                    <span class="ml-auto text-xs font-normal text-slate-500">{{ count($kodeGejala) }}</span>
                </h3>

                @if($gejalaDipilih->isNotEmpty())
                <div class="space-y-2 max-h-72 overflow-y-auto pr-1"
                     style="scrollbar-width: thin; scrollbar-color: rgba(99,102,241,0.3) transparent;">
                    @foreach($gejalaDipilih as $g)
                    <div class="flex items-start gap-2 p-2.5 rounded-xl"
                         style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06);">
                        <div class="w-1.5 h-1.5 rounded-full mt-1.5 flex-shrink-0"
                             style="background: #818cf8;"></div>
                        <div class="flex-1 min-w-0">
                            <span class="font-mono text-[10px] text-slate-600">{{ $g->kode }}</span>
                            <p class="text-xs text-slate-300 leading-relaxed mt-0.5">{{ $g->nama }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                {{-- Fallback jika gejala tidak ada di DB, tampilkan kode saja --}}
                <div class="space-y-1.5">
                    @foreach($kodeGejala as $kode)
                    <div class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg"
                         style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06);">
                        <div class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#818cf8;"></div>
                        <span class="font-mono text-xs text-slate-400">{{ $kode }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Perbandingan CF semua hasil --}}
            @if(count($hasilDiagnosa) > 1)
            <div class="glass rounded-2xl p-5" style="border:1px solid rgba(255,255,255,0.07);">
                <h3 class="font-display font-semibold text-white text-sm mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="#818cf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/>
                        <line x1="6" x2="6" y1="20" y2="14"/>
                    </svg>
                    Perbandingan CF
                </h3>
                <div class="space-y-3">
                    @foreach($hasilDiagnosa as $idx => $h)
                    @php
                        $barColor = match(true) {
                            $h['persentase'] >= 75 => '#ef4444',
                            $h['persentase'] >= 50 => '#f97316',
                            $h['persentase'] >= 25 => '#eab308',
                            default                => '#6366f1',
                        };
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-400 truncate max-w-[140px]">
                                {{ $h['icon'] ?? '' }} {{ $h['nama'] }}
                            </span>
                            <span class="font-bold ml-2 flex-shrink-0" style="color:{{ $barColor }};">
                                {{ number_format($h['persentase'], 1) }}%
                            </span>
                        </div>
                        <div class="h-1.5 rounded-full overflow-hidden" style="background:rgba(255,255,255,0.06);">
                            <div class="h-full rounded-full transition-all duration-700 ease-out"
                                 data-width="{{ $h['persentase'] }}"
                                 style="width:0%; background:{{ $barColor }};"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Action Buttons --}}
            <div class="space-y-2">
                <a href="{{ route('diagnosa.form') }}"
                   class="btn-primary w-full flex items-center justify-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                        <path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                        <path d="M8 16H3v5"/>
                    </svg>
                    Diagnosa Ulang
                </a>

                {{-- Tanya Chatbot --}}
                @if(!empty($hasilDiagnosa))
                <button onclick="chatbotSendText('{{ $hasilDiagnosa[0]['nama'] ?? 'kerusakan laptop' }}')"
                        class="w-full flex items-center justify-center gap-2 text-sm font-medium py-2 px-4 rounded-xl transition-all duration-200"
                        style="background:rgba(99,102,241,0.15); border:1px solid rgba(99,102,241,0.35); color:#a5b4fc;"
                        onmouseover="this.style.background='rgba(99,102,241,0.28)'"
                        onmouseout="this.style.background='rgba(99,102,241,0.15)'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    Tanya LaptopBot
                </button>
                @endif

                {{-- Hubungi Admin --}}
                <button onclick="chatbotOpenAdmin()"
                        class="w-full flex items-center justify-center gap-2 text-sm font-medium py-2 px-4 rounded-xl transition-all duration-200"
                        style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); color:#4ade80;"
                        onmouseover="this.style.background='rgba(34,197,94,0.22)'"
                        onmouseout="this.style.background='rgba(34,197,94,0.1)'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.115.549 4.099 1.51 5.826L.057 23.571 6 22.105A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.846 0-3.575-.493-5.072-1.355l-.359-.214-3.749.984.999-3.648-.235-.374A9.934 9.934 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                    </svg>
                    Hubungi Admin via WhatsApp
                </button>

                <a href="{{ route('diagnosa.riwayat') }}"
                   class="btn-outline w-full flex items-center justify-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5"/><path d="m12 19-7-7 7-7"/>
                    </svg>
                    Kembali ke Riwayat
                </a>
            </div>

        </div>{{-- end right sidebar --}}
    </div>{{-- end grid --}}
    @endif

</div>

@endsection

@push('scripts')
<script>
    // Animate CF bars on load
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-width]').forEach(el => {
            const w = el.getAttribute('data-width');
            setTimeout(() => {
                el.style.transition = 'width 0.9s cubic-bezier(0.4,0,0.2,1)';
                el.style.width = Math.min(parseFloat(w), 100) + '%';
            }, 200);
        });
    });

    // Toggle solusi panel
    function toggleSolutions(id) {
        const panel   = document.getElementById(id);
        const idx     = id.split('-')[1];
        const label   = document.getElementById('sol-label-' + idx);
        const chevron = document.getElementById('sol-chevron-' + idx);
        const isHidden = panel.classList.contains('hidden');

        panel.classList.toggle('hidden', !isHidden);
        panel.classList.toggle('block', isHidden);
        chevron.style.transform = isHidden ? 'rotate(180deg)' : '';
        label.textContent = isHidden ? 'Sembunyikan Langkah Penanganan' : 'Tampilkan Langkah Penanganan';
    }
</script>
@endpush
