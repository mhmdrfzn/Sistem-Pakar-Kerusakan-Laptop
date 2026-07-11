@extends('layouts.admin')

@section('title', 'Manajemen Kerusakan')
@section('breadcrumb')
<span class="text-slate-300">Kerusakan</span>
@endsection

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display font-bold text-2xl text-white mb-1">Manajemen Kerusakan</h1>
        <p class="text-slate-500 text-sm">Kelola {{ $kerusakanList->count() }} komponen kerusakan laptop dalam basis pengetahuan.</p>
    </div>
    <a href="{{ route('admin.kerusakan.create') }}" class="btn-admin-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14"/><path d="M5 12h14"/>
        </svg>
        Tambah Kerusakan
    </a>
</div>

<!-- Kerusakan Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
    @foreach($kerusakanList as $kerusakan)
    @php
        $iconMap = [
            'K001' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>',
            'K002' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="M6 8h.001"/><path d="M10 8h.001"/><path d="M14 8h.001"/><path d="M18 8h.001"/><path d="M8 12h.001"/><path d="M12 12h.001"/><path d="M16 12h.001"/><path d="M7 16h10"/></svg>',
            'K003' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="8" width="16" height="8" rx="2"/><path d="M8 8V6a2 2 0 0 1 4 0v2"/><path d="M12 8V6a2 2 0 0 1 4 0v2"/><path d="M8 16v2a2 2 0 0 0 4 0v-2"/><path d="M12 16v2a2 2 0 0 0 4 0v-2"/></svg>',
            'K004' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M5 3v4"/><path d="M19 3v4"/><path d="M5 7h14"/><path d="M12 7v10"/><path d="M9 17h6"/></svg>',
            'K005' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14a9 3 0 0 0 18 0V5"/><path d="M3 12a9 3 0 0 0 18 0"/></svg>',
            'K006' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="7"/><path d="M12 2v8"/><path d="M5 10h14"/></svg>',
            'K007' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M6.343 17.657A8 8 0 1 1 17.657 6.343"/></svg>',
            'K008' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>',
            'K009' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="10" x="2" y="7" rx="2"/><line x1="22" x2="22" y1="11" y2="13"/><line x1="6" x2="6" y1="11" y2="13"/><line x1="10" x2="10" y1="11" y2="13"/></svg>',
            'K010' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M12 2v2"/><path d="M12 22v-2"/><path d="m17 20.66-1-1.73"/><path d="m20.66 17-1.73-1"/><path d="M14 12h8"/><path d="M2 12h2"/></svg>',
            'K011' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>',
        ];
        $colors = [
            'K001' => ['bg' => 'rgba(99,102,241,0.15)', 'color' => '#818cf8', 'border' => 'rgba(99,102,241,0.25)'],
            'K002' => ['bg' => 'rgba(139,92,246,0.15)', 'color' => '#a78bfa', 'border' => 'rgba(139,92,246,0.25)'],
            'K003' => ['bg' => 'rgba(34,197,94,0.15)',  'color' => '#4ade80', 'border' => 'rgba(34,197,94,0.25)'],
            'K004' => ['bg' => 'rgba(234,179,8,0.15)',  'color' => '#facc15', 'border' => 'rgba(234,179,8,0.25)'],
            'K005' => ['bg' => 'rgba(249,115,22,0.15)', 'color' => '#fb923c', 'border' => 'rgba(249,115,22,0.25)'],
            'K006' => ['bg' => 'rgba(236,72,153,0.15)', 'color' => '#f472b6', 'border' => 'rgba(236,72,153,0.25)'],
            'K007' => ['bg' => 'rgba(6,182,212,0.15)',  'color' => '#22d3ee', 'border' => 'rgba(6,182,212,0.25)'],
            'K008' => ['bg' => 'rgba(20,184,166,0.15)', 'color' => '#2dd4bf', 'border' => 'rgba(20,184,166,0.25)'],
            'K009' => ['bg' => 'rgba(16,185,129,0.15)', 'color' => '#34d399', 'border' => 'rgba(16,185,129,0.25)'],
            'K010' => ['bg' => 'rgba(239,68,68,0.15)',  'color' => '#f87171', 'border' => 'rgba(239,68,68,0.25)'],
            'K011' => ['bg' => 'rgba(99,102,241,0.15)', 'color' => '#818cf8', 'border' => 'rgba(99,102,241,0.25)'],
        ];
        $c = $colors[$kerusakan->kode] ?? $colors['K001'];
    @endphp

    <div class="admin-card glass-hover" style="border-color: {{ $c['border'] }};">
        <!-- Card Header -->
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background: {{ $c['bg'] }}; color: {{ $c['color'] }};">
                    {!! $iconMap[$kerusakan->kode] ?? $iconMap['K010'] !!}
                </div>
                <div>
                    <span class="text-[10px] font-mono font-bold" style="color: {{ $c['color'] }}; opacity: 0.7;">{{ $kerusakan->kode }}</span>
                    <h3 class="font-display font-bold text-white text-base leading-tight">{{ $kerusakan->nama }}</h3>
                </div>
            </div>
        </div>

        <!-- Rules & Gejala Count -->
        <div class="flex gap-3 mb-4">
            <div class="flex-1 p-2.5 rounded-lg text-center" style="background: rgba(0,0,0,0.2);">
                <div class="font-bold text-white text-lg">{{ $kerusakan->rules_count }}</div>
                <div class="text-[10px] text-slate-500">Rules CF</div>
            </div>
            <div class="flex-1 p-2.5 rounded-lg text-center" style="background: rgba(0,0,0,0.2);">
                <div class="font-bold text-white text-lg">{{ $kerusakan->gejala_count }}</div>
                <div class="text-[10px] text-slate-500">Gejala</div>
            </div>
        </div>

        <!-- Harga -->
        <div class="mb-4 p-3 rounded-xl" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
            <p class="text-[10px] text-slate-600 uppercase tracking-wider mb-1">Estimasi Biaya (Part + Jasa)</p>
            <p class="text-sm font-semibold text-white">
                Rp {{ number_format($kerusakan->est_part_min + $kerusakan->service_fee, 0, ',', '.') }}
                <span class="text-slate-500 font-normal text-xs"> – </span>
                Rp {{ number_format($kerusakan->est_part_max + $kerusakan->service_fee, 0, ',', '.') }}
            </p>
            @if($kerusakan->service_fee > 0)
            <p class="text-[10px] text-slate-600 mt-0.5">Jasa servis: Rp {{ number_format($kerusakan->service_fee, 0, ',', '.') }}</p>
            @else
            <p class="text-[10px] text-slate-600 mt-0.5">Tanpa biaya jasa</p>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex gap-2">
            <a href="{{ route('admin.kerusakan.show', $kerusakan) }}" class="btn-admin-secondary flex-1 justify-center text-xs py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>
                </svg>
                Detail
            </a>
            <a href="{{ route('admin.kerusakan.edit', $kerusakan) }}" class="btn-admin-edit flex-1 justify-center text-xs py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
            <form action="{{ route('admin.kerusakan.destroy', $kerusakan) }}" method="POST"
                  onsubmit="return confirm('Hapus kerusakan {{ $kerusakan->nama }}? Semua rules terkait juga akan dihapus.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-admin-danger py-2 px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/><path d="m19 6-.867 12.142A2 2 0 0 1 16.138 20H7.862a2 2 0 0 1-1.995-1.858L5 6m5 0V4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

@endsection
