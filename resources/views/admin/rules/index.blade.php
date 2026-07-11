@extends('layouts.admin')

@section('title', 'Manajemen Rules CF')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Rules CF</h1>
            <p class="text-slate-400 text-sm mt-1">
                Setiap rule berisi kumpulan gejala (premis) dan nilai CF pakar per gejala.
            </p>
        </div>
        <a href="{{ route('admin.rules.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-white transition-all"
           style="background: linear-gradient(135deg,#6366f1,#8b5cf6);">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Rule Baru
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="p-4 rounded-xl text-sm text-emerald-400 flex items-center gap-2"
         style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Filter --}}
    <form method="GET" class="flex gap-3 flex-wrap">
        <select name="kerusakan_id" onchange="this.form.submit()"
                class="px-3 py-2 rounded-xl text-sm text-white bg-white/5 border border-white/10 focus:outline-none focus:border-indigo-500/50">
            <option value="">— Semua Kerusakan —</option>
            @foreach($kerusakanList as $k)
            <option value="{{ $k->id }}" {{ request('kerusakan_id') == $k->id ? 'selected' : '' }}>
                {{ $k->kode }} — {{ $k->nama }}
            </option>
            @endforeach
        </select>
        @if(request('kerusakan_id'))
        <a href="{{ route('admin.rules.index') }}"
           class="px-3 py-2 rounded-xl text-sm text-slate-400 border border-white/10 hover:border-white/20 transition">
            Reset Filter
        </a>
        @endif
    </form>

    {{-- Rules List --}}
    <div class="space-y-4">
        @forelse($rules as $rule)
        @php
            $gejalaList = $rule->gejala;
        @endphp
        <div class="glass rounded-2xl p-5" style="border:1px solid rgba(255,255,255,0.07);">
            {{-- Rule Header --}}
            <div class="flex items-start justify-between gap-4 mb-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs font-mono px-2 py-0.5 rounded-lg text-indigo-300"
                              style="background:rgba(99,102,241,0.2);">
                            Rule #{{ $rule->id }}
                        </span>
                        <span class="text-xs font-mono px-2 py-0.5 rounded-lg text-amber-300"
                              style="background:rgba(251,191,36,0.15);">
                            {{ $rule->kerusakan->kode }}
                        </span>
                    </div>
                    <h3 class="font-semibold text-white text-sm">
                        IF [kondisi] THEN
                        <span class="text-indigo-300">{{ $rule->kerusakan->nama }}</span>
                    </h3>
                    @if($rule->nama_rule)
                    <p class="text-xs text-slate-500 mt-0.5">{{ $rule->nama_rule }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('admin.rules.edit', $rule) }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-300 transition-all"
                       style="background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);"
                       onmouseover="this.style.background='rgba(99,102,241,0.3)'"
                       onmouseout="this.style.background='rgba(99,102,241,0.15)'">Edit</a>
                    <form method="POST" action="{{ route('admin.rules.destroy', $rule) }}"
                          onsubmit="return confirm('Hapus rule ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1.5 rounded-lg text-xs font-medium text-red-400 transition-all"
                                style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);"
                                onmouseover="this.style.background='rgba(239,68,68,0.22)'"
                                onmouseout="this.style.background='rgba(239,68,68,0.1)'">Hapus</button>
                    </form>
                </div>
            </div>

            {{-- Gejala Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.06);">
                            <th class="text-left py-2 text-slate-500 font-medium pr-4">Kode</th>
                            <th class="text-left py-2 text-slate-500 font-medium">Deskripsi Gejala</th>
                            <th class="text-center py-2 text-slate-500 font-medium w-24">CF Pakar</th>
                            <th class="text-center py-2 text-slate-500 font-medium w-24">Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gejalaList as $g)
                        @php $cf = (float)$g->pivot->cf_nilai; @endphp
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.03);">
                            <td class="py-2 font-mono text-indigo-300 pr-4">{{ $g->kode }}</td>
                            <td class="py-2 text-slate-300">{{ $g->deskripsi }}</td>
                            <td class="py-2 text-center font-mono font-bold
                                @if($cf >= 0.8) text-red-400
                                @elseif($cf >= 0.6) text-orange-400
                                @elseif($cf >= 0.4) text-yellow-400
                                @else text-slate-400 @endif">
                                {{ number_format($cf, 2) }}
                            </td>
                            <td class="py-2">
                                <div class="w-full rounded-full h-1.5" style="background:rgba(255,255,255,0.07);">
                                    <div class="h-1.5 rounded-full transition-all"
                                         style="width:{{ $cf * 100 }}%;
                                                background:{{ $cf >= 0.8 ? '#f87171' : ($cf >= 0.6 ? '#fb923c' : ($cf >= 0.4 ? '#facc15' : '#6366f1')) }};">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3 flex items-center gap-3">
                <span class="text-[10px] text-slate-500">
                    {{ $gejalaList->count() }} gejala dalam rule ini
                </span>
                <span class="text-[10px] text-slate-600">•</span>
                <span class="text-[10px] text-slate-500">
                    Rule aktif jika ≥50% gejala dipilih pengguna
                </span>
            </div>
        </div>
        @empty
        <div class="glass rounded-2xl p-10 text-center" style="border:1px solid rgba(255,255,255,0.07);">
            <p class="text-slate-500 text-sm mb-3">Belum ada rule. Tambahkan rule pertama.</p>
            <a href="{{ route('admin.rules.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-white"
               style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                Tambah Rule
            </a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($rules->hasPages())
    <div>{{ $rules->links() }}</div>
    @endif

</div>
@endsection
