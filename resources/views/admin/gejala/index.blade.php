@extends('layouts.admin')

@section('title', 'Manajemen Gejala')
@section('breadcrumb')
<span class="text-slate-300">Gejala</span>
@endsection

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display font-bold text-2xl text-white mb-1">Manajemen Gejala</h1>
        <p class="text-slate-500 text-sm">{{ $gejalaList->count() }} gejala terdaftar dalam basis pengetahuan.</p>
    </div>
    <a href="{{ route('admin.gejala.create') }}" class="btn-admin-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14"/><path d="M5 12h14"/>
        </svg>
        Tambah Gejala
    </a>
</div>

<!-- Filter by Kategori -->
<div class="flex gap-2 mb-5 overflow-x-auto pb-2" id="filter-tabs">
    <button class="category-tab active" data-filter="all" onclick="filterGejala('all', this)">
        Semua ({{ $gejalaList->count() }})
    </button>
    @foreach($kategoriList as $kat)
    @php $countKat = $gejalaList->where('kategori', $kat)->count(); @endphp
    <button class="category-tab" data-filter="{{ $kat }}" onclick="filterGejala('{{ $kat }}', this)">
        {{ $kat }} ({{ $countKat }})
    </button>
    @endforeach
</div>

<!-- Gejala Table -->
<div class="admin-card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full admin-table">
            <thead>
                <tr style="background: rgba(0,0,0,0.2);">
                    <th>Kode</th>
                    <th>Deskripsi Gejala</th>
                    <th>Kategori</th>
                    <th>Rules CF</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="gejala-tbody">
                @foreach($gejalaList as $gejala)
                <tr class="gejala-row" data-kategori="{{ $gejala->kategori }}">
                    <td>
                        <span class="font-mono text-xs font-bold text-violet-400">{{ $gejala->kode }}</span>
                    </td>
                    <td class="max-w-sm">
                        <p class="text-sm text-slate-300 leading-relaxed">{{ $gejala->deskripsi }}</p>
                    </td>
                    <td>
                        <span class="px-2 py-1 rounded-lg text-[10px] font-medium whitespace-nowrap"
                              style="background: rgba(139,92,246,0.15); color: #c4b5fd; border: 1px solid rgba(139,92,246,0.2);">
                            {{ $gejala->kategori }}
                        </span>
                    </td>
                    <td>
                        <span class="font-bold text-sm {{ $gejala->rules_count > 0 ? 'text-pink-400' : 'text-slate-600' }}">
                            {{ $gejala->rules_count }}
                        </span>
                        <span class="text-slate-600 text-xs ml-1">rules</span>
                    </td>
                    <td>
                        <div class="flex gap-1.5">
                            <a href="{{ route('admin.gejala.edit', $gejala) }}" class="btn-admin-edit text-xs py-1.5 px-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.gejala.destroy', $gejala) }}" method="POST"
                                  onsubmit="return confirm('Hapus gejala ini? Rules terkait juga akan terhapus.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-admin-danger text-xs py-1.5 px-2">
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
</div>

@push('scripts')
<script>
    function filterGejala(filter, btn) {
        document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.gejala-row').forEach(row => {
            if (filter === 'all' || row.dataset.kategori === filter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endpush

@endsection
