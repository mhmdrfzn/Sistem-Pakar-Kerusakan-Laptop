@extends('layouts.admin')

@section('title', 'Detail: '.$kerusakan->nama)
@section('breadcrumb')
<a href="{{ route('admin.kerusakan.index') }}" class="text-slate-400 hover:text-white transition-colors">Kerusakan</a>
<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
<span class="text-slate-300">{{ $kerusakan->nama }}</span>
@endsection

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display font-bold text-2xl text-white mb-1">{{ $kerusakan->kode }} — {{ $kerusakan->nama }}</h1>
        <p class="text-slate-500 text-sm">Detail komponen dan manajemen rules CF.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.kerusakan.edit', $kerusakan) }}" class="btn-admin-edit">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Edit Komponen
        </a>
        <a href="{{ route('admin.kerusakan.index') }}" class="btn-admin-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    <!-- Detail Info -->
    <div class="space-y-4">
        <div class="admin-card">
            <h3 class="font-semibold text-white text-sm mb-3 pb-3 border-b border-white/5">Informasi Komponen</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-[10px] text-slate-600 uppercase tracking-wider mb-1">Komponen Pengganti</p>
                    <p class="text-sm text-slate-300">{{ $kerusakan->komponen_pengganti }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-slate-600 uppercase tracking-wider mb-1">Kategori</p>
                    <span class="px-2 py-0.5 rounded text-xs text-indigo-300" style="background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.2);">{{ $kerusakan->kategori }}</span>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <h3 class="font-semibold text-white text-sm mb-3 pb-3 border-b border-white/5 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
                Estimasi Biaya
            </h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Part (Min)</span>
                    <span class="text-slate-300">Rp {{ number_format($kerusakan->est_part_min, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Part (Max)</span>
                    <span class="text-slate-300">Rp {{ number_format($kerusakan->est_part_max, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Jasa Servis</span>
                    <span class="text-slate-300">Rp {{ number_format($kerusakan->service_fee, 0, ',', '.') }}</span>
                </div>
                <div class="section-divider my-2"></div>
                <div class="flex justify-between font-semibold">
                    <span class="text-slate-300">Total Estimasi</span>
                    <span class="text-green-400">
                        Rp {{ number_format($kerusakan->est_part_min + $kerusakan->service_fee, 0, ',', '.') }} –
                        Rp {{ number_format($kerusakan->est_part_max + $kerusakan->service_fee, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Solutions -->
        <div class="admin-card">
            <h3 class="font-semibold text-white text-sm mb-3 pb-3 border-b border-white/5">Langkah Solusi</h3>
            <ol class="space-y-2">
                @foreach($kerusakan->solutions as $si => $sol)
                <li class="flex items-start gap-2">
                    <span class="w-5 h-5 rounded flex items-center justify-center text-[10px] font-bold flex-shrink-0 mt-0.5"
                          style="background: rgba(99,102,241,0.2); color: #a5b4fc;">{{ $si + 1 }}</span>
                    <span class="text-xs text-slate-400 leading-relaxed">{{ $sol }}</span>
                </li>
                @endforeach
            </ol>
        </div>
    </div>

    <!-- Rules Management -->
    <div class="lg:col-span-2">
        <div class="admin-card">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/5">
                <h3 class="font-semibold text-white text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ec4899" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                    </svg>
                    Rules & Certainty Factor
                    <span class="text-[10px] text-slate-600 font-normal">({{ $kerusakan->rules->count() }} rules)</span>
                </h3>
                <a href="{{ route('admin.kerusakan.rules', $kerusakan) }}" class="btn-admin-primary text-xs py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Kelola Semua Rules
                </a>
            </div>

            @if($kerusakan->rules->isEmpty())
            <div class="text-center py-10">
                <svg class="mx-auto text-slate-700 mb-3" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                </svg>
                <p class="text-slate-600 text-sm mb-3">Belum ada rules untuk komponen ini.</p>
                <a href="{{ route('admin.kerusakan.rules', $kerusakan) }}" class="btn-admin-primary text-sm">
                    Tambah Rules Sekarang
                </a>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full admin-table">
                    <thead>
                        <tr>
                            <th>Kode Gejala</th>
                            <th>Deskripsi Gejala</th>
                            <th>Nilai CF</th>
                            <th>Persentase</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kerusakan->rules->sortByDesc('cf_nilai') as $rule)
                        <tr>
                            <td><span class="font-mono text-xs text-indigo-400">{{ $rule->gejala->kode }}</span></td>
                            <td class="max-w-xs">
                                <p class="text-xs text-slate-300 leading-relaxed line-clamp-2">{{ $rule->gejala->deskripsi }}</p>
                            </td>
                            <td>
                                <span class="font-mono text-sm font-bold text-pink-400">{{ number_format($rule->cf_nilai, 2) }}</span>
                            </td>
                            <td>
                                @php $pct = $rule->cf_nilai * 100; @endphp
                                <div class="flex items-center gap-2">
                                    <div class="cf-bar-container flex-1" style="height: 6px; min-width: 60px;">
                                        <div class="cf-bar-fill {{ $pct >= 80 ? 'cf-bar-critical' : ($pct >= 60 ? 'cf-bar-high' : ($pct >= 40 ? 'cf-bar-medium' : 'cf-bar-low')) }}"
                                             style="width: {{ $pct }}%;"></div>
                                    </div>
                                    <span class="text-xs text-slate-400">{{ number_format($pct, 0) }}%</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="{{ route('admin.rules.edit', $rule) }}" class="btn-admin-edit text-xs py-1 px-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.rules.destroy', $rule) }}" method="POST"
                                          onsubmit="return confirm('Hapus rule ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-admin-danger text-xs py-1 px-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/><path d="m19 6-.867 12.142A2 2 0 0 1 16.138 20H7.862a2 2 0 0 1-1.995-1.858L5 6m5 0V4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
