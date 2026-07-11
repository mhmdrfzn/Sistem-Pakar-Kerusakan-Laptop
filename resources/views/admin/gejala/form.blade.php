@extends('layouts.admin')

@section('title', $gejala ? 'Edit Gejala' : 'Tambah Gejala')
@section('breadcrumb')
<a href="{{ route('admin.gejala.index') }}" class="text-slate-400 hover:text-white transition-colors">Gejala</a>
<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
<span class="text-slate-300">{{ $gejala ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')

<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="font-display font-bold text-2xl text-white mb-1">{{ $gejala ? 'Edit Gejala' : 'Tambah Gejala Baru' }}</h1>
            <p class="text-slate-500 text-sm">{{ $gejala ? 'Perbarui data gejala kerusakan.' : 'Tambahkan gejala baru ke basis pengetahuan.' }}</p>
        </div>
        <a href="{{ route('admin.gejala.index') }}" class="btn-admin-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ $gejala ? route('admin.gejala.update', $gejala) : route('admin.gejala.store') }}"
          method="POST">
        @csrf
        @if($gejala) @method('PUT') @endif

        <div class="admin-card space-y-4">
            <h2 class="font-semibold text-white text-sm pb-3 border-b border-white/5 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 18h8"/><path d="M3 22h18"/><path d="M14 22a7 7 0 1 0 0-14h-1"/><path d="M9 14h2"/>
                    <path d="M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z"/><path d="M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"/>
                </svg>
                Data Gejala
            </h2>

            <div>
                <label class="admin-label">Kode Gejala <span class="text-red-400">*</span></label>
                <input type="text" name="kode" value="{{ old('kode', $gejala?->kode) }}"
                       placeholder="Contoh: G001" maxlength="10"
                       class="admin-input font-mono" style="text-transform: uppercase;">
                <p class="text-xs text-slate-600 mt-1.5">Format: G diikuti 3 digit angka (G001, G064, dst)</p>
                @error('kode') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="admin-label">Kategori <span class="text-red-400">*</span></label>
                <div class="flex gap-2">
                    <select name="kategori" id="kategori-select" class="admin-input flex-1"
                            onchange="toggleKategoriInput(this.value)">
                        @php
                            $builtinKat = ['Display & Layar', 'Keyboard & Input', 'Performa & Sistem', 'Daya & Baterai', 'Penyimpanan & Boot', 'Pendinginan & Suhu', 'Kamera & Multimedia'];
                            $currentKat = old('kategori', $gejala?->kategori ?? '');
                        @endphp
                        @foreach($kategoriList as $kat)
                        <option value="{{ $kat }}" {{ $currentKat === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                        <option value="__new__">+ Kategori Baru...</option>
                    </select>
                </div>
                <input type="text" id="kategori-new" name="kategori_new" placeholder="Nama kategori baru..."
                       class="admin-input mt-2 hidden">
                @error('kategori') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="admin-label">Deskripsi Gejala <span class="text-red-400">*</span></label>
                <textarea name="deskripsi" rows="3" placeholder="Jelaskan gejala secara detail dan mudah dipahami pengguna..."
                          class="admin-input resize-none">{{ old('deskripsi', $gejala?->deskripsi) }}</textarea>
                <p class="text-xs text-slate-600 mt-1.5">Gunakan bahasa yang mudah dipahami pengguna awam.</p>
                @error('deskripsi') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-admin-primary px-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    {{ $gejala ? 'Simpan Perubahan' : 'Tambah Gejala' }}
                </button>
                <a href="{{ route('admin.gejala.index') }}" class="btn-admin-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function toggleKategoriInput(val) {
    const input = document.getElementById('kategori-new');
    const select = document.getElementById('kategori-select');
    if (val === '__new__') {
        input.classList.remove('hidden');
        input.required = true;
        input.focus();
        // Override the select name
        select.name = '';
        input.name = 'kategori';
    } else {
        input.classList.add('hidden');
        input.required = false;
        select.name = 'kategori';
        input.name = 'kategori_new';
    }
}
</script>
@endpush

@endsection
