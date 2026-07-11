@extends('layouts.app')

@section('title', 'Riwayat Diagnosa — Sistem Pakar Laptop')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
            <a href="{{ route('home') }}" class="hover:text-indigo-400 transition-colors">Beranda</a>
            <span>/</span>
            <span class="text-slate-300">Riwayat</span>
        </div>
        <h1 class="font-display font-bold text-3xl text-white mb-2 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-400"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
            Riwayat <span class="gradient-text">Diagnosa</span>
        </h1>
        <p class="text-slate-400">Daftar semua sesi diagnosa yang pernah dilakukan.</p>
    </div>

    @if($sesiList->isEmpty())
    <div class="text-center py-20">
        <div class="flex justify-center mb-6 text-slate-600 floating">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/><path d="M16 19h6"/><path d="M19 16v6"/></svg>
        </div>
        <h2 class="font-display font-bold text-2xl text-white mb-4">Belum Ada Riwayat Diagnosa</h2>
        <p class="text-slate-400 mb-8">Mulai diagnosa laptop Anda sekarang!</p>
        <a href="{{ route('diagnosa.form') }}" class="btn-primary inline-flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18h8"/><path d="M3 22h18"/><path d="M14 22a7 7 0 1 0 0-14h-1"/><path d="M9 14h2"/><path d="M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z"/><path d="M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"/></svg>
            Mulai Diagnosa
        </a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($sesiList as $sesi)
        @php
            $hasil = $sesi->hasil_diagnosa;
            $topHasil = !empty($hasil) ? $hasil[0] : null;
            $topPersen = $topHasil ? number_format($topHasil['persentase'], 1) : 0;
            $topNama = $topHasil ? $topHasil['nama'] : 'Tidak teridentifikasi';
            $topIconEmoji = $topHasil['icon'] ?? '🔧';
            $iconSvgMapRiwayat = [
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
            $topIconSvg = $iconSvgMapRiwayat[$topIconEmoji] ?? $iconSvgMapRiwayat['🔧'];
        @endphp
        <a href="{{ route('diagnosa.detail', $sesi->id) }}"
           class="glass rounded-2xl p-5 block transition-all duration-200 group"
           style="border: 1px solid rgba(255,255,255,0.07);"
           onmouseover="this.style.borderColor='rgba(99,102,241,0.35)'; this.style.background='rgba(99,102,241,0.05)'"
           onmouseout="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background=''">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex items-center gap-4 flex-1">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 text-indigo-400 transition-all duration-200 group-hover:scale-105"
                         style="background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.25);">
                        {!! $topIconSvg !!}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-semibold text-white">{{ $sesi->nama_pengguna ?? 'Anonim' }}</span>
                            @if($sesi->nama_laptop)
                            <span class="text-xs text-slate-500">— {{ $sesi->nama_laptop }}</span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-400">
                            Diagnosa Utama: <span class="text-indigo-300 font-medium">{{ $topNama }}</span>
                            @if($topHasil)
                            <span class="text-slate-600 mx-1">·</span>
                            <span class="text-slate-400">CF: {{ $topPersen }}%</span>
                            @endif
                        </p>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="text-xs text-slate-600 inline-flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $sesi->created_at->format('d M Y, H:i') }}
                            </span>
                            <span class="text-xs text-slate-600 inline-flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                {{ count($sesi->gejala_dipilih ?? []) }} gejala
                            </span>
                            <span class="text-xs text-slate-600 inline-flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                                {{ count($sesi->hasil_diagnosa ?? []) }} kerusakan
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if(!empty($hasil))
                    <div class="text-right">
                        <div class="font-display font-bold text-2xl text-indigo-400">{{ $topPersen }}%</div>
                        <div class="text-xs text-slate-500">CF Tertinggi</div>
                    </div>
                    @endif
                    {{-- Chevron indicator --}}
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 transition-all duration-200 group-hover:translate-x-0.5"
                         style="background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.25);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="#818cf8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $sesiList->links() }}
    </div>
    @endif
</div>

@endsection
