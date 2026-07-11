@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<!-- Page Header -->
<div class="flex items-center justify-between mb-7">
    <div>
        <h1 class="font-display font-bold text-2xl text-white mb-1">Dashboard</h1>
        <p class="text-slate-500 text-sm">Selamat datang di panel administrasi LaptopExpert AI.</p>
    </div>
    <a href="{{ route('diagnosa.form') }}" target="_blank" class="btn-admin-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/>
        </svg>
        Lihat Situs
    </a>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-7">
    @php
        $statCards = [
            [
                'label' => 'Total Kerusakan',
                'value' => $stats['total_kerusakan'],
                'color' => '#6366f1',
                'bg'    => 'rgba(99,102,241,0.12)',
                'border'=> 'rgba(99,102,241,0.25)',
                'link'  => route('admin.kerusakan.index'),
                'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="12" x="3" y="4" rx="2"/><line x1="2" x2="22" y1="20" y2="20"/></svg>',
            ],
            [
                'label' => 'Total Gejala',
                'value' => $stats['total_gejala'],
                'color' => '#8b5cf6',
                'bg'    => 'rgba(139,92,246,0.12)',
                'border'=> 'rgba(139,92,246,0.25)',
                'link'  => route('admin.gejala.index'),
                'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18h8"/><path d="M3 22h18"/><path d="M14 22a7 7 0 1 0 0-14h-1"/><path d="M9 14h2"/><path d="M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z"/><path d="M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"/></svg>',
            ],
            [
                'label' => 'Total Rules CF',
                'value' => $stats['total_rules'],
                'color' => '#ec4899',
                'bg'    => 'rgba(236,72,153,0.12)',
                'border'=> 'rgba(236,72,153,0.25)',
                'link'  => route('admin.rules.index'),
                'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
            ],
            [
                'label' => 'Sesi Diagnosa',
                'value' => $stats['total_sesi'],
                'color' => '#22c55e',
                'bg'    => 'rgba(34,197,94,0.12)',
                'border'=> 'rgba(34,197,94,0.25)',
                'link'  => route('diagnosa.riwayat'),
                'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>',
            ],
        ];
    @endphp

    @foreach($statCards as $card)
    <a href="{{ $card['link'] }}" class="admin-card hover:scale-[1.02] transition-all cursor-pointer block"
       style="background: {{ $card['bg'] }}; border-color: {{ $card['border'] }};">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background: rgba(0,0,0,0.2); color: {{ $card['color'] }};">
                {!! $card['icon'] !!}
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="{{ $card['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.5;">
                <path d="m9 18 6-6-6-6"/>
            </svg>
        </div>
        <div class="font-display font-bold text-3xl text-white mb-1">{{ $card['value'] }}</div>
        <div class="text-xs" style="color: {{ $card['color'] }}; opacity: 0.8;">{{ $card['label'] }}</div>
    </a>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Quick Actions -->
    <div class="admin-card">
        <h2 class="font-semibold text-white mb-4 flex items-center gap-2 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
            </svg>
            Aksi Cepat
        </h2>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('admin.kerusakan.create') }}" class="btn-admin-primary justify-center text-sm py-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14"/><path d="M5 12h14"/>
                </svg>
                Tambah Kerusakan
            </a>
            <a href="{{ route('admin.gejala.create') }}" class="btn-admin-secondary justify-center text-sm py-3"
               style="border-color: rgba(139,92,246,0.3); color: #c4b5fd;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14"/><path d="M5 12h14"/>
                </svg>
                Tambah Gejala
            </a>
            <a href="{{ route('admin.rules.create') }}" class="btn-admin-secondary justify-center text-sm py-3"
               style="border-color: rgba(236,72,153,0.3); color: #f9a8d4;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14"/><path d="M5 12h14"/>
                </svg>
                Tambah Rule CF
            </a>
            <a href="{{ route('diagnosa.form') }}" target="_blank" class="btn-admin-secondary justify-center text-sm py-3"
               style="border-color: rgba(34,197,94,0.3); color: #86efac;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                </svg>
                Coba Diagnosa
            </a>
        </div>
    </div>

    <!-- Top Kerusakan -->
    <div class="admin-card">
        <h2 class="font-semibold text-white mb-4 flex items-center gap-2 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/>
                <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/>
                <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/>
                <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/>
            </svg>
            Kerusakan Paling Sering Didiagnosa
        </h2>
        @if(empty($kerusakanPopuler))
        <div class="text-center py-8">
            <svg class="mx-auto text-slate-700 mb-3" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                <rect width="8" height="4" x="8" y="2" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
            </svg>
            <p class="text-slate-600 text-sm">Belum ada data diagnosa</p>
        </div>
        @else
        <div class="space-y-3">
            @foreach($kerusakanPopuler as $kode => $data)
            <div class="flex items-center gap-3">
                <span class="font-mono text-xs text-indigo-400 w-10 flex-shrink-0">{{ $kode }}</span>
                <div class="flex-1 min-w-0">
                    <div class="text-sm text-slate-300 mb-1 truncate">{{ $data['nama'] }}</div>
                    <div class="cf-bar-container" style="height: 5px;">
                        @php $maxCount = max(array_column($kerusakanPopuler, 'count')); @endphp
                        <div class="cf-bar-fill cf-bar-low" style="width: {{ ($data['count'] / $maxCount) * 100 }}%;"></div>
                    </div>
                </div>
                <span class="text-xs font-bold text-slate-400 flex-shrink-0">{{ $data['count'] }}x</span>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Recent Sessions -->
    <div class="admin-card lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-white flex items-center gap-2 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                Diagnosa Terbaru
            </h2>
            <a href="{{ route('diagnosa.riwayat') }}" class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors">
                Lihat semua →
            </a>
        </div>

        @if($recentSesi->isEmpty())
        <p class="text-center text-slate-600 py-8 text-sm">Belum ada sesi diagnosa</p>
        @else
        <div class="overflow-x-auto">
            <table class="w-full admin-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Laptop</th>
                        <th>Diagnosa Utama</th>
                        <th>CF</th>
                        <th>Gejala</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentSesi as $sesi)
                    @php
                        $hasil = $sesi->hasil_diagnosa ?? [];
                        $top   = $hasil[0] ?? null;
                    @endphp
                    <tr>
                        <td class="text-slate-300 text-sm font-medium">{{ $sesi->nama_pengguna ?? 'Anonim' }}</td>
                        <td class="text-slate-500 text-xs">{{ $sesi->nama_laptop ?? '—' }}</td>
                        <td>
                            @if($top)
                            <span class="text-sm text-white">{{ $top['nama'] }}</span>
                            @else
                            <span class="text-slate-600 text-xs">Tidak teridentifikasi</span>
                            @endif
                        </td>
                        <td>
                            @if($top)
                            <span class="font-mono text-xs font-bold"
                                  style="color: {{ $top['persentase'] >= 60 ? '#f87171' : ($top['persentase'] >= 40 ? '#fbbf24' : '#818cf8') }};">
                                {{ number_format($top['persentase'], 1) }}%
                            </span>
                            @else <span class="text-slate-600">—</span> @endif
                        </td>
                        <td class="text-slate-500 text-xs">{{ count($sesi->gejala_dipilih ?? []) }} gejala</td>
                        <td class="text-slate-600 text-xs whitespace-nowrap">{{ $sesi->created_at->format('d M, H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

@endsection
