@extends('layouts.admin')

@section('title', $kerusakan ? 'Edit Kerusakan' : 'Tambah Kerusakan')
@section('breadcrumb')
<a href="{{ route('admin.kerusakan.index') }}" class="text-slate-400 hover:text-white transition-colors">Kerusakan</a>
<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
<span class="text-slate-300">{{ $kerusakan ? 'Edit: '.$kerusakan->nama : 'Tambah Baru' }}</span>
@endsection

@section('content')

<div class="max-w-3xl">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="font-display font-bold text-2xl text-white mb-1">
                {{ $kerusakan ? 'Edit Kerusakan' : 'Tambah Kerusakan Baru' }}
            </h1>
            <p class="text-slate-500 text-sm">{{ $kerusakan ? 'Perbarui data komponen kerusakan dan estimasi biaya.' : 'Tambahkan komponen kerusakan baru ke basis pengetahuan.' }}</p>
        </div>
        <a href="{{ route('admin.kerusakan.index') }}" class="btn-admin-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Kembali
        </a>
    </div>

    <form action="{{ $kerusakan ? route('admin.kerusakan.update', $kerusakan) : route('admin.kerusakan.store') }}"
          method="POST" id="kerusakan-form">
        @csrf
        @if($kerusakan) @method('PUT') @endif

        <div class="space-y-5">

            <!-- Identitas -->
            <div class="admin-card">
                <h2 class="font-semibold text-white text-sm mb-4 pb-3 border-b border-white/5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="12" x="3" y="4" rx="2"/><line x1="2" x2="22" y1="20" y2="20"/>
                    </svg>
                    Identitas Komponen
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Kode Kerusakan <span class="text-red-400">*</span></label>
                        <input type="text" name="kode" value="{{ old('kode', $kerusakan?->kode) }}"
                               placeholder="Contoh: K001" maxlength="10"
                               class="admin-input font-mono uppercase" style="text-transform: uppercase;">
                        @error('kode') <p class="form-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                            {{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="admin-label">Nama Komponen <span class="text-red-400">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $kerusakan?->nama) }}"
                               placeholder="Contoh: LCD, Keyboard, RAM..."
                               class="admin-input">
                        @error('nama') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="col-span-2">
                        <label class="admin-label">Kategori <span class="text-red-400">*</span></label>
                        <select name="kategori" class="admin-input">
                            @php
                                $kategoriOptions = ['display', 'input', 'hardware', 'power', 'storage', 'cooling', 'peripheral', 'audio'];
                                $selectedKategori = old('kategori', $kerusakan?->kategori ?? 'hardware');
                            @endphp
                            @foreach($kategoriOptions as $k)
                            <option value="{{ $k }}" {{ $selectedKategori === $k ? 'selected' : '' }}>
                                {{ ucfirst($k) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="admin-label">Nama Komponen Pengganti <span class="text-red-400">*</span></label>
                        <textarea name="komponen_pengganti" rows="2" placeholder="Deskripsi part yang perlu diganti..."
                                  class="admin-input resize-none">{{ old('komponen_pengganti', $kerusakan?->komponen_pengganti) }}</textarea>
                        @error('komponen_pengganti') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Estimasi Biaya -->
            <div class="admin-card">
                <h2 class="font-semibold text-white text-sm mb-4 pb-3 border-b border-white/5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                    Estimasi Biaya
                </h2>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="admin-label">Harga Part Minimum (Rp) <span class="text-red-400">*</span></label>
                        <input type="number" name="est_part_min"
                               value="{{ old('est_part_min', $kerusakan?->est_part_min) }}"
                               placeholder="650000" min="0" step="1000"
                               class="admin-input">
                        @error('est_part_min') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="admin-label">Harga Part Maksimum (Rp) <span class="text-red-400">*</span></label>
                        <input type="number" name="est_part_max"
                               value="{{ old('est_part_max', $kerusakan?->est_part_max) }}"
                               placeholder="1250000" min="0" step="1000"
                               class="admin-input">
                        @error('est_part_max') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="admin-label">Biaya Jasa Servis (Rp) <span class="text-red-400">*</span></label>
                        <input type="number" name="service_fee"
                               value="{{ old('service_fee', $kerusakan?->service_fee ?? 0) }}"
                               placeholder="0" min="0" step="10000"
                               class="admin-input">
                        @error('service_fee') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
                <!-- Preview Total -->
                <div class="mt-4 p-3 rounded-xl flex items-center justify-between"
                     style="background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.15);">
                    <span class="text-xs text-slate-500">Estimasi Total Biaya:</span>
                    <span class="text-sm font-semibold text-green-400" id="total-preview">Rp 0 – Rp 0</span>
                </div>
            </div>

            <!-- Solusi Perbaikan -->
            <div class="admin-card">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/5">
                    <h2 class="font-semibold text-white text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                            <path d="M12 2v2"/><path d="M12 22v-2"/>
                        </svg>
                        Langkah Solusi Perbaikan
                    </h2>
                    <button type="button" onclick="addSolution()" class="btn-admin-secondary text-xs py-1.5 px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14"/><path d="M5 12h14"/>
                        </svg>
                        Tambah Langkah
                    </button>
                </div>

                <div id="solutions-container" class="space-y-3">
                    @php
                        $solutions = old('solutions', $kerusakan?->solutions ?? ['']);
                    @endphp
                    @foreach($solutions as $si => $sol)
                    <div class="solution-item flex items-start gap-3">
                        <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0 mt-1.5"
                              style="background: rgba(99,102,241,0.2); color: #a5b4fc;">{{ $si + 1 }}</span>
                        <input type="text" name="solutions[]" value="{{ $sol }}"
                               placeholder="Langkah perbaikan {{ $si + 1 }}..."
                               class="admin-input flex-1">
                        <button type="button" onclick="removeSolution(this)"
                                class="mt-1.5 p-1.5 rounded-lg text-slate-600 hover:text-red-400 hover:bg-red-400/10 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                            </svg>
                        </button>
                    </div>
                    @endforeach
                </div>
                @error('solutions') <p class="form-error mt-2">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div class="flex gap-3">
                <button type="submit" class="btn-admin-primary px-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    {{ $kerusakan ? 'Simpan Perubahan' : 'Tambah Kerusakan' }}
                </button>
                <a href="{{ route('admin.kerusakan.index') }}" class="btn-admin-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let solutionCount = {{ count($solutions) }};

    function addSolution() {
        solutionCount++;
        const container = document.getElementById('solutions-container');
        const div = document.createElement('div');
        div.className = 'solution-item flex items-start gap-3';
        div.innerHTML = `
            <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0 mt-1.5"
                  style="background: rgba(99,102,241,0.2); color: #a5b4fc;">${solutionCount}</span>
            <input type="text" name="solutions[]" placeholder="Langkah perbaikan ${solutionCount}..."
                   class="admin-input flex-1">
            <button type="button" onclick="removeSolution(this)"
                    class="mt-1.5 p-1.5 rounded-lg text-slate-600 hover:text-red-400 hover:bg-red-400/10 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                </svg>
            </button>
        `;
        container.appendChild(div);
        updateNumbers();
    }

    function removeSolution(btn) {
        const items = document.querySelectorAll('.solution-item');
        if (items.length <= 1) return;
        btn.closest('.solution-item').remove();
        updateNumbers();
    }

    function updateNumbers() {
        document.querySelectorAll('.solution-item').forEach((item, i) => {
            const badge = item.querySelector('span');
            if (badge) badge.textContent = i + 1;
        });
        solutionCount = document.querySelectorAll('.solution-item').length;
    }

    // Live price preview
    function updatePricePreview() {
        const min = parseInt(document.querySelector('[name=est_part_min]').value) || 0;
        const max = parseInt(document.querySelector('[name=est_part_max]').value) || 0;
        const fee = parseInt(document.querySelector('[name=service_fee]').value) || 0;
        const fmt = n => 'Rp ' + n.toLocaleString('id-ID');
        document.getElementById('total-preview').textContent = `${fmt(min + fee)} – ${fmt(max + fee)}`;
    }

    ['est_part_min', 'est_part_max', 'service_fee'].forEach(name => {
        document.querySelector(`[name=${name}]`)?.addEventListener('input', updatePricePreview);
    });

    // Init
    updatePricePreview();
</script>
@endpush

@endsection
