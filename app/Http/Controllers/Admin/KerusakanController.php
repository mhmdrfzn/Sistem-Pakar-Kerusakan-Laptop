<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;
use Illuminate\Http\Request;

class KerusakanController extends Controller
{
    public function index()
    {
        $kerusakanList = Kerusakan::withCount(['gejala', 'rules'])->orderBy('kode')->get();
        return view('admin.kerusakan.index', compact('kerusakanList'));
    }

    public function create()
    {
        return view('admin.kerusakan.form', ['kerusakan' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode'                => 'required|string|max:10|unique:kerusakan,kode',
            'nama'                => 'required|string|max:255',
            'komponen_pengganti'  => 'required|string',
            'est_part_min'        => 'required|integer|min:0',
            'est_part_max'        => 'required|integer|min:0|gte:est_part_min',
            'service_fee'         => 'required|integer|min:0',
            'kategori'            => 'required|string|max:100',
            'solutions'           => 'required|array|min:1',
            'solutions.*'         => 'required|string',
        ], [
            'kode.unique'           => 'Kode kerusakan sudah digunakan.',
            'est_part_max.gte'      => 'Harga maksimal harus lebih besar atau sama dengan harga minimal.',
            'solutions.required'    => 'Minimal satu solusi harus diisi.',
        ]);

        // Filter empty solutions
        $validated['solutions'] = array_values(array_filter($validated['solutions'], fn($s) => !empty(trim($s))));

        Kerusakan::create($validated);

        return redirect()->route('admin.kerusakan.index')
            ->with('success', 'Kerusakan berhasil ditambahkan.');
    }

    public function edit(Kerusakan $kerusakan)
    {
        return view('admin.kerusakan.form', compact('kerusakan'));
    }

    public function update(Request $request, Kerusakan $kerusakan)
    {
        $validated = $request->validate([
            'kode'                => 'required|string|max:10|unique:kerusakan,kode,' . $kerusakan->id,
            'nama'                => 'required|string|max:255',
            'komponen_pengganti'  => 'required|string',
            'est_part_min'        => 'required|integer|min:0',
            'est_part_max'        => 'required|integer|min:0|gte:est_part_min',
            'service_fee'         => 'required|integer|min:0',
            'kategori'            => 'required|string|max:100',
            'solutions'           => 'required|array|min:1',
            'solutions.*'         => 'required|string',
        ], [
            'est_part_max.gte'  => 'Harga maksimal harus lebih besar atau sama dengan harga minimal.',
        ]);

        $validated['solutions'] = array_values(array_filter($validated['solutions'], fn($s) => !empty(trim($s))));

        $kerusakan->update($validated);

        return redirect()->route('admin.kerusakan.index')
            ->with('success', 'Data kerusakan berhasil diperbarui.');
    }

    public function destroy(Kerusakan $kerusakan)
    {
        $kerusakan->delete();
        return redirect()->route('admin.kerusakan.index')
            ->with('success', 'Kerusakan berhasil dihapus beserta semua rules-nya.');
    }

    public function show(Kerusakan $kerusakan)
    {
        $kerusakan->load(['gejala', 'rules.gejala']);
        return view('admin.kerusakan.show', compact('kerusakan'));
    }
}
