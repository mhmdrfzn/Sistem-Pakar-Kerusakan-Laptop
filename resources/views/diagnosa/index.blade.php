@extends('layouts.app')

@section('title', 'Form Diagnosa — Sistem Pakar Laptop')
@section('description', 'Pilih gejala kerusakan laptop Anda untuk memulai proses diagnosa menggunakan Forward Chaining dan Certainty Factor.')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
            <a href="{{ route('home') }}" class="hover:text-indigo-400 transition-colors">Beranda</a>
            <span>/</span>
            <span class="text-slate-300">Diagnosa</span>
        </div>
        <h1 class="font-display font-bold text-3xl md:text-4xl text-white mb-2 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-400"><path d="M6 18h8"/><path d="M3 22h18"/><path d="M14 22a7 7 0 1 0 0-14h-1"/><path d="M9 14h2"/><path d="M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z"/><path d="M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"/></svg>
            Form <span class="gradient-text">Diagnosa Laptop</span>
        </h1>
        <p class="text-slate-400">Pilih semua gejala yang sesuai dengan kondisi laptop Anda, lalu klik tombol diagnosa.</p>
    </div>

    <form action="{{ route('diagnosa.proses') }}" method="POST" id="diagnosa-form">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            <!-- LEFT: Identity & Summary -->
            <div class="lg:col-span-1 space-y-4">
                <!-- Info Pengguna -->
                <div class="glass rounded-2xl p-5" style="border: 1px solid rgba(255,255,255,0.07);">
                    <h3 class="font-semibold text-white text-sm mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-md flex items-center justify-center text-indigo-400" 
                              style="background: rgba(99, 102, 241, 0.2);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
                        </span>
                        Informasi Pengguna
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-xs text-slate-500 block mb-1.5">Nama Anda (Opsional)</label>
                            <input type="text" name="nama_pengguna" 
                                   value="{{ old('nama_pengguna') }}"
                                   placeholder="Masukkan nama Anda"
                                   class="w-full px-3 py-2.5 rounded-xl text-sm text-white placeholder-slate-600 bg-white/5 border border-white/10 focus:border-indigo-500/50 focus:outline-none focus:ring-1 focus:ring-indigo-500/30 transition-all">
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 block mb-1.5">Merk / Tipe Laptop (Opsional)</label>
                            <input type="text" name="nama_laptop" 
                                   value="{{ old('nama_laptop') }}"
                                   placeholder="Contoh: ASUS VivoBook 14"
                                   class="w-full px-3 py-2.5 rounded-xl text-sm text-white placeholder-slate-600 bg-white/5 border border-white/10 focus:border-indigo-500/50 focus:outline-none focus:ring-1 focus:ring-indigo-500/30 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Gejala Counter -->
                <div class="glass rounded-2xl p-5 sticky top-20" style="border: 1px solid rgba(255,255,255,0.07);">
                    <h3 class="font-semibold text-white text-sm mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-md flex items-center justify-center text-indigo-400"
                              style="background: rgba(99, 102, 241, 0.2);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                        </span>
                        Gejala Dipilih
                    </h3>

                    <!-- Counter -->
                    <div class="text-center py-4">
                        <div id="gejala-count" class="font-display font-bold text-4xl text-white mb-1">0</div>
                        <div class="text-slate-500 text-xs">gejala terpilih</div>
                    </div>

                    <!-- Progress -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-slate-500 mb-2">
                            <span>Minimum: 1 gejala</span>
                            <span id="count-label">0/63</span>
                        </div>
                        <div class="cf-bar-container">
                            <div id="selection-bar" class="cf-bar-fill cf-bar-low" style="width: 0%;"></div>
                        </div>
                    </div>

                    <!-- Selected List Preview -->
                    <div id="selected-preview" class="space-y-1 max-h-48 overflow-y-auto mb-4 hidden">
                        <p class="text-xs text-slate-500 mb-2">Gejala terpilih:</p>
                        <div id="selected-tags" class="space-y-1"></div>
                    </div>

                    <!-- Error Message -->
                    @error('gejala')
                    <div class="mb-4 p-3 rounded-xl text-xs text-red-400 bg-red-500/10 border border-red-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                        {{ $message }}
                    </div>
                    @enderror

                    <!-- Submit Button -->
                    <button type="submit" id="submit-btn"
                            class="btn-primary w-full flex items-center justify-center gap-2 text-sm disabled:opacity-40 disabled:cursor-not-allowed"
                            disabled>
                        <span id="submit-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline mr-1"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            Diagnosa Sekarang
                        </span>
                    </button>

                    <!-- Clear Button -->
                    <button type="button" id="clear-btn"
                            onclick="clearAll()"
                            class="btn-outline w-full mt-2 text-sm text-slate-400 hidden inline-flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="m19 6-.867 12.142A2 2 0 0 1 16.138 20H7.862a2 2 0 0 1-1.995-1.858L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                        Hapus Semua Pilihan
                    </button>
                </div>
            </div>

            <!-- RIGHT: Gejala List -->
            <div class="lg:col-span-3">
                <!-- Category Tabs -->
                <div class="mb-5 overflow-x-auto pb-2">
                    <div class="flex gap-2 min-w-max" id="category-tabs">
                        <button type="button" class="category-tab active" data-category="all" onclick="filterCategory('all', this)">
                            <span class="inline-flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                Semua Gejala
                            </span>
                        </button>
                        @foreach($gejalaTerkelompok as $kategori => $gejalaList)
                        <button type="button" class="category-tab" data-category="{{ $kategori }}" onclick="filterCategory('{{ $kategori }}', this)">
                            @php
                                $svgIcons = [
                                    'Display & Layar' => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>',
                                    'Keyboard & Input' => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="M6 8h.001"/><path d="M10 8h.001"/><path d="M14 8h.001"/><path d="M18 8h.001"/><path d="M8 12h.001"/><path d="M12 12h.001"/><path d="M16 12h.001"/><path d="M7 16h10"/></svg>',
                                    'Performa & Sistem' => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="12" x="3" y="4" rx="2"/><line x1="2" x2="22" y1="20" y2="20"/></svg>',
                                    'Daya & Baterai' => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="10" x="2" y="7" rx="2"/><line x1="22" x2="22" y1="11" y2="13"/><line x1="6" x2="6" y1="11" y2="13"/></svg>',
                                    'Penyimpanan & Boot' => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14a9 3 0 0 0 18 0V5"/><path d="M3 12a9 3 0 0 0 18 0"/></svg>',
                                    'Pendinginan & Suhu' => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"/></svg>',
                                    'Kamera & Multimedia' => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>',
                                ];
                                $svgIcon = $svgIcons[$kategori] ?? '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>';
                            @endphp
                            <span class="inline-flex items-center gap-1.5">{!! $svgIcon !!} {{ $kategori }}</span>
                            <span class="ml-1 text-[10px] opacity-60">({{ count($gejalaList) }})</span>
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Gejala Grid by Category -->
                @foreach($gejalaTerkelompok as $kategori => $gejalaList)
                <div class="category-section mb-6" data-category="{{ $kategori }}">
                    <!-- Category Header -->
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-px flex-1" style="background: rgba(255,255,255,0.06);"></div>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 inline-flex items-center gap-1.5">
                            {!! $svgIcons[$kategori] ?? '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>' !!}
                            {{ $kategori }}
                        </span>
                        <div class="h-px flex-1" style="background: rgba(255,255,255,0.06);"></div>
                    </div>

                    <!-- Gejala Items -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach($gejalaList as $gejala)
                        <div class="gejala-wrapper" id="wrap_{{ $gejala->kode }}">
                            {{-- Baris checkbox --}}
                            <label class="gejala-item {{ in_array($gejala->kode, old('gejala', [])) ? 'active' : '' }}"
                                   for="gejala_{{ $gejala->kode }}"
                                   id="label_{{ $gejala->kode }}"
                                   data-category="{{ $gejala->kategori }}">
                                <div class="gejala-checkbox">
                                    <svg class="check-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                </div>
                                <input type="checkbox"
                                       name="gejala[]"
                                       value="{{ $gejala->kode }}"
                                       id="gejala_{{ $gejala->kode }}"
                                       class="sr-only gejala-checkbox-input"
                                       data-kode="{{ $gejala->kode }}"
                                       {{ in_array($gejala->kode, old('gejala', [])) ? 'checked' : '' }}
                                       onchange="updateSelection(); toggleCFSlider('{{ $gejala->kode }}', this.checked)">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start gap-2">
                                        <span class="number-badge flex-shrink-0">{{ $loop->iteration }}</span>
                                        <p class="text-sm text-slate-300 leading-relaxed">{{ $gejala->deskripsi }}</p>
                                    </div>
                                    <span class="text-[10px] text-slate-600 mt-1 block font-mono">{{ $gejala->kode }}</span>
                                </div>
                            </label>

                            {{-- CF User Slider (muncul saat dicentang) --}}
                            <div id="cfslider_{{ $gejala->kode }}"
                                 class="cf-user-slider {{ in_array($gejala->kode, old('gejala', [])) ? '' : 'hidden' }}"
                                 style="margin-top: -2px; padding: 8px 12px 10px; border-radius: 0 0 12px 12px; background: rgba(99,102,241,0.07); border: 1px solid rgba(99,102,241,0.2); border-top: none;">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] text-indigo-400 font-semibold uppercase tracking-wider">Seberapa yakin Anda dengan gejala ini?</span>
                                    <span id="cflabel_{{ $gejala->kode }}" class="text-[10px] font-bold text-indigo-300 px-2 py-0.5 rounded-full"
                                          style="background: rgba(99,102,241,0.2);">Yakin (0.8)</span>
                                </div>
                                <div class="flex gap-1 mb-1">
                                    @foreach([
                                        ['val'=>'0.2','label'=>'Tidak Yakin','color'=>'#64748b'],
                                        ['val'=>'0.4','label'=>'Kurang Yakin','color'=>'#6366f1'],
                                        ['val'=>'0.6','label'=>'Cukup Yakin','color'=>'#eab308'],
                                        ['val'=>'0.8','label'=>'Yakin','color'=>'#f97316'],
                                        ['val'=>'1.0','label'=>'Sangat Yakin','color'=>'#ef4444'],
                                    ] as $opt)
                                    <button type="button"
                                            class="cf-opt-btn flex-1 text-[9px] py-1.5 rounded-lg font-semibold transition-all duration-150"
                                            data-kode="{{ $gejala->kode }}"
                                            data-val="{{ $opt['val'] }}"
                                            data-label="{{ $opt['label'] }}"
                                            data-color="{{ $opt['color'] }}"
                                            onclick="selectCFUser('{{ $gejala->kode }}', '{{ $opt['val'] }}', '{{ $opt['label'] }}', '{{ $opt['color'] }}')"
                                            style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); color: #94a3b8;"
                                            title="{{ $opt['label'] }} = {{ $opt['val'] }}">
                                        {{ $opt['label'] }}
                                    </button>
                                    @endforeach
                                </div>
                                {{-- Hidden input nilai CF User --}}
                                <input type="hidden"
                                       name="cf_user[{{ $gejala->kode }}]"
                                       id="cfval_{{ $gejala->kode }}"
                                       value="0.8">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </form>
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" class="fixed inset-0 z-50 hidden items-center justify-center"
     style="background: rgba(10, 10, 15, 0.9); backdrop-filter: blur(10px);">
    <div class="text-center">
        <div class="spinner mx-auto mb-6" style="width: 60px; height: 60px; border-width: 4px;"></div>
        <h3 class="font-display font-bold text-2xl text-white mb-2">Memproses Diagnosa...</h3>
        <p class="text-slate-400">Mesin inferensi sedang menganalisa gejala Anda</p>
        <div class="mt-6 flex justify-center gap-2">
            <div class="step-dot active" id="dot1"></div>
            <div class="step-dot" id="dot2"></div>
            <div class="step-dot" id="dot3"></div>
        </div>
        <div class="mt-4 text-slate-500 text-xs" id="loading-step">Forward Chaining: Mencocokkan gejala...</div>
    </div>
</div>

@push('scripts')
<script>
    let selectedCount = 0;
    const totalGejala = {{ $gejalaTerkelompok->flatten()->count() }};

    // Init on load
    document.addEventListener('DOMContentLoaded', function() {
        updateSelection();
    });

    function updateSelection() {
        const checkboxes = document.querySelectorAll('.gejala-checkbox-input:checked');
        selectedCount = checkboxes.length;

        // Update counter
        document.getElementById('gejala-count').textContent = selectedCount;
        document.getElementById('count-label').textContent = `${selectedCount}/${totalGejala}`;

        // Update progress bar
        const pct = Math.min((selectedCount / totalGejala) * 100, 100);
        document.getElementById('selection-bar').style.width = pct + '%';

        // Enable/disable submit button
        const btn = document.getElementById('submit-btn');
        const clearBtn = document.getElementById('clear-btn');
        btn.disabled = selectedCount === 0;
        clearBtn.classList.toggle('hidden', selectedCount === 0);

        // Update selected tags
        updateSelectedTags(checkboxes);

        // Update label styling
        document.querySelectorAll('.gejala-item').forEach(label => {
            const input = label.querySelector('.gejala-checkbox-input');
            label.classList.toggle('active', input.checked);
        });
    }

    function updateSelectedTags(checkboxes) {
        const preview = document.getElementById('selected-preview');
        const tagsContainer = document.getElementById('selected-tags');
        tagsContainer.innerHTML = '';

        if (checkboxes.length > 0) {
            preview.classList.remove('hidden');
            checkboxes.forEach(cb => {
                const label = document.querySelector(`label[for="${cb.id}"]`);
                const text = label.querySelector('p')?.textContent?.trim();
                const tag = document.createElement('div');
                tag.className = 'flex items-start gap-2 py-1';
                tag.innerHTML = `
                    <span class="text-indigo-400 text-xs flex-shrink-0 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                    <span class="text-xs text-slate-400 leading-relaxed">${text}</span>
                `;
                tagsContainer.appendChild(tag);
            });
        } else {
            preview.classList.add('hidden');
        }
    }

    function filterCategory(category, btn) {
        // Update tab styles
        document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        // Show/hide sections
        document.querySelectorAll('.category-section').forEach(section => {
            if (category === 'all' || section.dataset.category === category) {
                section.style.display = '';
            } else {
                section.style.display = 'none';
            }
        });
    }

    function clearAll() {
        document.querySelectorAll('.gejala-checkbox-input').forEach(cb => {
            cb.checked = false;
            toggleCFSlider(cb.dataset.kode, false);
        });
        updateSelection();
    }

    /* ---- CF User Slider ---- */
    function toggleCFSlider(kode, show) {
        const slider = document.getElementById('cfslider_' + kode);
        const label  = document.getElementById('label_' + kode);
        if (!slider) return;
        if (show) {
            slider.classList.remove('hidden');
            label.style.borderRadius = '12px 12px 0 0';
            // Set default 0.8 = Yakin saat pertama kali dipilih
            selectCFUser(kode, '0.8', 'Yakin', '#f97316', false);
        } else {
            slider.classList.add('hidden');
            label.style.borderRadius = '';
        }
    }

    function selectCFUser(kode, val, label, color, updateTag = true) {
        // Simpan nilai ke hidden input
        document.getElementById('cfval_' + kode).value = val;

        // Update label badge
        const lbl = document.getElementById('cflabel_' + kode);
        if (lbl) {
            lbl.textContent = label + ' (' + val + ')';
            lbl.style.background = hexToRgba(color, 0.2);
            lbl.style.color = color;
        }

        // Update tombol aktif
        document.querySelectorAll(`.cf-opt-btn[data-kode="${kode}"]`).forEach(btn => {
            const isActive = btn.dataset.val === val;
            btn.style.background = isActive ? hexToRgba(color, 0.25) : 'rgba(255,255,255,0.05)';
            btn.style.borderColor = isActive ? hexToRgba(color, 0.5) : 'rgba(255,255,255,0.08)';
            btn.style.color = isActive ? color : '#94a3b8';
            btn.style.fontWeight = isActive ? '700' : '500';
        });

        if (updateTag) updateSelection();
    }

    function hexToRgba(hex, alpha) {
        const r = parseInt(hex.slice(1,3),16);
        const g = parseInt(hex.slice(3,5),16);
        const b = parseInt(hex.slice(5,7),16);
        return `rgba(${r},${g},${b},${alpha})`;
    }

    // Form submit with loading
    document.getElementById('diagnosa-form').addEventListener('submit', function(e) {
        if (selectedCount === 0) {
            e.preventDefault();
            return;
        }

        const overlay = document.getElementById('loading-overlay');
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');

        // Animate loading steps
        const steps = [
            { dot: 'dot1', text: 'Forward Chaining: Mencocokkan gejala...', delay: 0 },
            { dot: 'dot2', text: 'Certainty Factor: Menghitung keyakinan...', delay: 800 },
            { dot: 'dot3', text: 'Menyusun hasil diagnosa...', delay: 1600 },
        ];

        steps.forEach(step => {
            setTimeout(() => {
                document.getElementById(step.dot).classList.add('active');
                document.getElementById('loading-step').textContent = step.text;
            }, step.delay);
        });
    });
</script>
@endpush

@endsection
