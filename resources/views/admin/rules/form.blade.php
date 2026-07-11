@extends('layouts.admin')

@section('title', $rule ? 'Edit Rule' : 'Tambah Rule Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.rules.index') }}"
           class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:text-white transition-colors"
           style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-white">
                {{ $rule ? 'Edit Rule #'.$rule->id : 'Tambah Rule Baru' }}
            </h1>
            <p class="text-slate-500 text-xs mt-0.5">
                Satu rule berisi beberapa gejala dengan nilai CF pakar masing-masing.
            </p>
        </div>
    </div>

    <form method="POST"
          action="{{ $rule ? route('admin.rules.update', $rule) : route('admin.rules.store') }}"
          id="rule-form">
        @csrf
        @if($rule) @method('PUT') @endif

        {{-- Errors --}}
        @if($errors->any())
        <div class="p-4 rounded-xl text-sm text-red-400"
             style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
            <ul class="space-y-1">
                @foreach($errors->all() as $err)
                <li>• {{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="glass rounded-2xl p-6 space-y-5" style="border:1px solid rgba(255,255,255,0.07);">

            {{-- Kerusakan --}}
            <div>
                <label class="text-xs text-slate-400 block mb-2 font-medium uppercase tracking-wider">
                    Kerusakan (Konklusi Rule) <span class="text-red-400">*</span>
                </label>
                <select name="kerusakan_id"
                        class="w-full px-4 py-3 rounded-xl text-sm text-white bg-white/5 border border-white/10 focus:border-indigo-500/50 focus:outline-none focus:ring-1 focus:ring-indigo-500/30 transition-all"
                        {{ $rule ? 'disabled' : '' }}>
                    <option value="">— Pilih Kerusakan —</option>
                    @foreach($kerusakanList as $k)
                    <option value="{{ $k->id }}"
                        {{ old('kerusakan_id', $rule?->kerusakan_id) == $k->id ? 'selected' : '' }}>
                        {{ $k->kode }} — {{ $k->nama }}
                    </option>
                    @endforeach
                </select>
                @if($rule)
                <input type="hidden" name="kerusakan_id" value="{{ $rule->kerusakan_id }}">
                <p class="text-[10px] text-slate-600 mt-1">Kerusakan tidak dapat diubah. Hapus & buat rule baru jika perlu.</p>
                @endif
            </div>

            {{-- Nama Rule (opsional) --}}
            <div>
                <label class="text-xs text-slate-400 block mb-2 font-medium uppercase tracking-wider">
                    Nama / Label Rule <span class="text-slate-600">(Opsional)</span>
                </label>
                <input type="text" name="nama_rule"
                       value="{{ old('nama_rule', $rule?->nama_rule) }}"
                       placeholder="cth: R001 - LCD Mati Total"
                       class="w-full px-4 py-3 rounded-xl text-sm text-white placeholder-slate-600 bg-white/5 border border-white/10 focus:border-indigo-500/50 focus:outline-none focus:ring-1 focus:ring-indigo-500/30 transition-all">
            </div>

            {{-- Divider --}}
            <div class="h-px" style="background:rgba(255,255,255,0.06);"></div>

            {{-- Gejala + CF --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <label class="text-xs text-slate-400 font-medium uppercase tracking-wider">
                        Gejala (Premis Rule) <span class="text-red-400">*</span>
                    </label>
                    <button type="button" onclick="tambahBariGejala()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-300 transition-all"
                            style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);"
                            onmouseover="this.style.background='rgba(16,185,129,0.2)'"
                            onmouseout="this.style.background='rgba(16,185,129,0.1)'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Tambah Gejala
                    </button>
                </div>

                {{-- Keterangan CF --}}
                <div class="p-3 rounded-xl mb-4 text-[10px] text-slate-500"
                     style="background:rgba(99,102,241,0.05);border:1px solid rgba(99,102,241,0.15);">
                    <strong class="text-indigo-400">Panduan Nilai CF Pakar:</strong>
                    &nbsp; 0.2 = Tidak Yakin &nbsp;|&nbsp;
                    0.4 = Kurang Yakin &nbsp;|&nbsp;
                    0.6 = Cukup Yakin &nbsp;|&nbsp;
                    0.8 = Yakin &nbsp;|&nbsp;
                    1.0 = Sangat Yakin
                </div>

                {{-- Baris Gejala --}}
                <div id="gejala-container" class="space-y-2">
                    @php
                        $existingGejala = $rule
                            ? $rule->gejala->map(fn($g) => [
                                'gejala_id' => $g->id,
                                'cf_nilai'  => $g->pivot->cf_nilai,
                              ])->toArray()
                            : (old('gejala') ?? [['gejala_id'=>'','cf_nilai'=>'0.8']]);
                    @endphp

                    @foreach($existingGejala as $i => $eg)
                    <div class="gejala-row flex items-center gap-3 p-3 rounded-xl"
                         style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);">
                        {{-- Nomor --}}
                        <span class="gejala-num w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold flex-shrink-0 text-indigo-300"
                              style="background:rgba(99,102,241,0.2);">{{ $i + 1 }}</span>

                        {{-- Select Gejala --}}
                        <select name="gejala[{{ $i }}][gejala_id]"
                                class="gejala-select flex-1 px-3 py-2 rounded-lg text-sm text-white bg-white/5 border border-white/10 focus:border-indigo-500/50 focus:outline-none transition-all">
                            <option value="">— Pilih Gejala —</option>
                            @foreach($gejalaList as $g)
                            <option value="{{ $g->id }}"
                                {{ $eg['gejala_id'] == $g->id ? 'selected' : '' }}>
                                {{ $g->kode }} — {{ $g->deskripsi }}
                            </option>
                            @endforeach
                        </select>

                        {{-- CF Nilai --}}
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="text-xs text-slate-500">CF =</span>
                            <input type="number"
                                   name="gejala[{{ $i }}][cf_nilai]"
                                   value="{{ $eg['cf_nilai'] }}"
                                   step="0.05" min="0.01" max="1.00"
                                   class="w-20 px-2 py-2 rounded-lg text-sm text-center text-white font-mono bg-white/5 border border-white/10 focus:border-emerald-500/50 focus:outline-none transition-all">
                        </div>

                        {{-- Hapus baris --}}
                        <button type="button" onclick="hapusBaris(this)"
                                class="w-7 h-7 rounded-lg flex items-center justify-center text-red-400 flex-shrink-0 transition-all"
                                style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);"
                                onmouseover="this.style.background='rgba(239,68,68,0.25)'"
                                onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex gap-3">
            <button type="submit"
                    class="flex-1 py-3 rounded-xl text-sm font-semibold text-white transition-all"
                    style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                {{ $rule ? 'Simpan Perubahan' : 'Tambah Rule' }}
            </button>
            <a href="{{ route('admin.rules.index') }}"
               class="px-6 py-3 rounded-xl text-sm font-medium text-slate-400 border border-white/10 hover:border-white/20 transition-all">
                Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Template gejala list (semua opsi)
    const gejalaOptions = `
        <option value="">— Pilih Gejala —</option>
        @foreach($gejalaList as $g)
        <option value="{{ $g->id }}">{{ $g->kode }} — {{ addslashes($g->deskripsi) }}</option>
        @endforeach
    `;

    let rowIndex = {{ count($existingGejala) }};

    function tambahBariGejala() {
        const container = document.getElementById('gejala-container');
        const div = document.createElement('div');
        div.className = 'gejala-row flex items-center gap-3 p-3 rounded-xl';
        div.style.cssText = 'background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);';
        div.innerHTML = `
            <span class="gejala-num w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold flex-shrink-0 text-indigo-300" style="background:rgba(99,102,241,0.2);">${rowIndex + 1}</span>
            <select name="gejala[${rowIndex}][gejala_id]"
                    class="gejala-select flex-1 px-3 py-2 rounded-lg text-sm text-white bg-white/5 border border-white/10 focus:border-indigo-500/50 focus:outline-none transition-all">
                ${gejalaOptions}
            </select>
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="text-xs text-slate-500">CF =</span>
                <input type="number" name="gejala[${rowIndex}][cf_nilai]"
                       value="0.8" step="0.05" min="0.01" max="1.00"
                       class="w-20 px-2 py-2 rounded-lg text-sm text-center text-white font-mono bg-white/5 border border-white/10 focus:border-emerald-500/50 focus:outline-none transition-all">
            </div>
            <button type="button" onclick="hapusBaris(this)"
                    class="w-7 h-7 rounded-lg flex items-center justify-center text-red-400 flex-shrink-0 transition-all"
                    style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);"
                    onmouseover="this.style.background='rgba(239,68,68,0.25)'"
                    onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        `;
        container.appendChild(div);
        rowIndex++;
        renumberRows();
    }

    function hapusBaris(btn) {
        const rows = document.querySelectorAll('.gejala-row');
        if (rows.length <= 1) {
            alert('Minimal harus ada 1 gejala dalam rule.');
            return;
        }
        btn.closest('.gejala-row').remove();
        renumberRows();
        reindexInputs();
    }

    function renumberRows() {
        document.querySelectorAll('.gejala-num').forEach((el, i) => {
            el.textContent = i + 1;
        });
    }

    function reindexInputs() {
        document.querySelectorAll('.gejala-row').forEach((row, i) => {
            row.querySelector('select').name = `gejala[${i}][gejala_id]`;
            row.querySelector('input[type=number]').name = `gejala[${i}][cf_nilai]`;
        });
    }
</script>
@endpush

@endsection
