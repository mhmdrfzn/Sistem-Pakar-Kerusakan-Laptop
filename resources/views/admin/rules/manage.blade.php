@extends('layouts.admin')

@section('title', 'Rules untuk '.$kerusakan->nama)

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.kerusakan.show', $kerusakan) }}"
           class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:text-white transition-colors"
           style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-white">
                Rules: <span class="text-indigo-300">{{ $kerusakan->nama }}</span>
            </h1>
            <p class="text-slate-500 text-xs mt-0.5">
                {{ $kerusakan->kode }} — Kelola semua rule beserta gejala-gejalanya
            </p>
        </div>
    </div>

    @if(session('success'))
    <div class="p-3 rounded-xl text-sm text-emerald-400 flex items-center gap-2"
         style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Rule Cards --}}
    @forelse($kerusakan->rules as $rule)
    <div class="glass rounded-2xl p-5" style="border:1px solid rgba(99,102,241,0.2);">
        <div class="flex items-start justify-between gap-4 mb-4">
            <div>
                <span class="text-xs font-mono px-2 py-0.5 rounded-lg text-indigo-300 mr-2"
                      style="background:rgba(99,102,241,0.2);">Rule #{{ $rule->id }}</span>
                @if($rule->nama_rule)
                <span class="text-xs text-slate-400">{{ $rule->nama_rule }}</span>
                @endif
                <p class="text-xs text-slate-500 mt-1">{{ $rule->gejala->count() }} gejala</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.rules.edit', $rule) }}"
                   class="px-3 py-1.5 rounded-lg text-xs text-indigo-300 transition"
                   style="background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);">Edit</a>
                <form method="POST" action="{{ route('admin.rules.destroy', $rule) }}"
                      onsubmit="return confirm('Hapus rule ini?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1.5 rounded-lg text-xs text-red-400 transition"
                            style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);">Hapus</button>
                </form>
            </div>
        </div>

        <table class="w-full text-xs">
            <thead>
                <tr style="border-bottom:1px solid rgba(255,255,255,0.06);">
                    <th class="text-left py-2 text-slate-500 font-medium pr-3">Kode</th>
                    <th class="text-left py-2 text-slate-500 font-medium">Gejala</th>
                    <th class="text-center py-2 text-slate-500 font-medium w-20">CF Pakar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rule->gejala as $g)
                @php $cf = (float)$g->pivot->cf_nilai; @endphp
                <tr style="border-bottom:1px solid rgba(255,255,255,0.03);">
                    <td class="py-1.5 font-mono text-indigo-300 pr-3">{{ $g->kode }}</td>
                    <td class="py-1.5 text-slate-300">{{ $g->deskripsi }}</td>
                    <td class="py-1.5 text-center font-mono font-bold
                        @if($cf>=0.8) text-red-400
                        @elseif($cf>=0.6) text-orange-400
                        @elseif($cf>=0.4) text-yellow-400
                        @else text-slate-400 @endif">
                        {{ number_format($cf,2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @empty
    <div class="glass rounded-2xl p-8 text-center" style="border:1px solid rgba(255,255,255,0.07);">
        <p class="text-slate-500 text-sm mb-3">Belum ada rule untuk kerusakan ini.</p>
    </div>
    @endforelse

    {{-- Tambah Rule Baru (tombol) --}}
    <a href="{{ route('admin.rules.create') }}?kerusakan_id={{ $kerusakan->id }}"
       class="flex items-center justify-center gap-2 p-4 rounded-2xl text-sm font-medium text-emerald-300 transition-all"
       style="background:rgba(16,185,129,0.07);border:2px dashed rgba(16,185,129,0.3);"
       onmouseover="this.style.background='rgba(16,185,129,0.14)'"
       onmouseout="this.style.background='rgba(16,185,129,0.07)'">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        Tambah Rule Baru untuk {{ $kerusakan->nama }}
    </a>

</div>
@endsection
