<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    public function index()
    {
        $gejalaList = Gejala::withCount('rules')->orderBy('kode')->get();
        $kategoriList = Gejala::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.gejala.index', compact('gejalaList', 'kategoriList'));
    }

    public function create()
    {
        $kategoriList = Gejala::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.gejala.form', ['gejala' => null, 'kategoriList' => $kategoriList]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode'      => 'required|string|max:10|unique:gejala,kode',
            'deskripsi' => 'required|string',
            'kategori'  => 'required|string|max:100',
        ], [
            'kode.unique' => 'Kode gejala sudah digunakan.',
        ]);

        Gejala::create($validated);

        return redirect()->route('admin.gejala.index')
            ->with('success', 'Gejala berhasil ditambahkan.');
    }

    public function edit(Gejala $gejala)
    {
        $kategoriList = Gejala::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.gejala.form', compact('gejala', 'kategoriList'));
    }

    public function update(Request $request, Gejala $gejala)
    {
        $validated = $request->validate([
            'kode'      => 'required|string|max:10|unique:gejala,kode,' . $gejala->id,
            'deskripsi' => 'required|string',
            'kategori'  => 'required|string|max:100',
        ]);

        $gejala->update($validated);

        return redirect()->route('admin.gejala.index')
            ->with('success', 'Gejala berhasil diperbarui.');
    }

    public function destroy(Gejala $gejala)
    {
        $gejala->delete();
        return redirect()->route('admin.gejala.index')
            ->with('success', 'Gejala berhasil dihapus.');
    }
}
