<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    /**
     * Daftar semua rules (dikelompokkan per kerusakan)
     */
    public function index(Request $request)
    {
        $query = Rule::with(['kerusakan', 'gejala'])
                     ->orderBy('kerusakan_id');

        if ($request->filled('kerusakan_id')) {
            $query->where('kerusakan_id', $request->kerusakan_id);
        }

        $rules         = $query->paginate(20)->withQueryString();
        $kerusakanList = Kerusakan::orderBy('kode')->get();

        return view('admin.rules.index', compact('rules', 'kerusakanList'));
    }

    /**
     * Form tambah rule baru
     */
    public function create()
    {
        $kerusakanList = Kerusakan::orderBy('kode')->get();
        $gejalaList    = Gejala::orderBy('kode')->get();

        return view('admin.rules.form', [
            'rule'          => null,
            'kerusakanList' => $kerusakanList,
            'gejalaList'    => $gejalaList,
        ]);
    }

    /**
     * Simpan rule baru beserta gejala-gejalanya
     */
    public function store(Request $request)
    {
        $request->validate([
            'kerusakan_id'        => 'required|exists:kerusakan,id',
            'nama_rule'           => 'nullable|string|max:100',
            'gejala'              => 'required|array|min:1',
            'gejala.*.gejala_id'  => 'required|exists:gejala,id',
            'gejala.*.cf_nilai'   => 'required|numeric|min:0.01|max:1.00',
        ], [
            'kerusakan_id.required'       => 'Pilih komponen kerusakan.',
            'gejala.required'             => 'Tambahkan minimal 1 gejala.',
            'gejala.min'                  => 'Tambahkan minimal 1 gejala.',
            'gejala.*.gejala_id.required' => 'Pilih gejala.',
            'gejala.*.cf_nilai.min'       => 'Nilai CF minimal 0.01.',
            'gejala.*.cf_nilai.max'       => 'Nilai CF maksimal 1.00.',
        ]);

        // Cek duplikasi gejala dalam satu request
        $gejalaIds = array_column($request->gejala, 'gejala_id');
        if (count($gejalaIds) !== count(array_unique($gejalaIds))) {
            return back()
                ->withErrors(['gejala' => 'Tidak boleh ada gejala yang sama dalam satu rule.'])
                ->withInput();
        }

        // Buat rule
        $rule = Rule::create([
            'kerusakan_id' => $request->kerusakan_id,
            'nama_rule'    => $request->nama_rule,
        ]);

        // Attach gejala dengan CF ke pivot
        $pivotData = [];
        foreach ($request->gejala as $item) {
            $pivotData[$item['gejala_id']] = [
                'cf_nilai'   => $item['cf_nilai'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        $rule->gejala()->attach($pivotData);

        return redirect()->route('admin.rules.index')
            ->with('success', 'Rule berhasil ditambahkan.');
    }

    /**
     * Form edit rule
     */
    public function edit(Rule $rule)
    {
        $rule->load('gejala');
        $kerusakanList = Kerusakan::orderBy('kode')->get();
        $gejalaList    = Gejala::orderBy('kode')->get();

        return view('admin.rules.form', compact('rule', 'kerusakanList', 'gejalaList'));
    }

    /**
     * Update rule (nama + sync gejala+CF)
     */
    public function update(Request $request, Rule $rule)
    {
        $request->validate([
            'nama_rule'           => 'nullable|string|max:100',
            'gejala'              => 'required|array|min:1',
            'gejala.*.gejala_id'  => 'required|exists:gejala,id',
            'gejala.*.cf_nilai'   => 'required|numeric|min:0.01|max:1.00',
        ], [
            'gejala.required'             => 'Tambahkan minimal 1 gejala.',
            'gejala.*.gejala_id.required' => 'Pilih gejala.',
            'gejala.*.cf_nilai.min'       => 'Nilai CF minimal 0.01.',
            'gejala.*.cf_nilai.max'       => 'Nilai CF maksimal 1.00.',
        ]);

        $rule->update(['nama_rule' => $request->nama_rule]);

        // Sync gejala dengan CF baru
        $pivotData = [];
        foreach ($request->gejala as $item) {
            $pivotData[$item['gejala_id']] = [
                'cf_nilai'   => $item['cf_nilai'],
                'updated_at' => now(),
            ];
        }
        $rule->gejala()->sync($pivotData);

        return redirect()->route('admin.rules.index')
            ->with('success', 'Rule berhasil diperbarui.');
    }

    /**
     * Hapus rule (cascade akan hapus rule_gejala pivot)
     */
    public function destroy(Rule $rule)
    {
        $rule->delete();

        return redirect()->route('admin.rules.index')
            ->with('success', 'Rule berhasil dihapus.');
    }

    /**
     * Manage rules khusus satu kerusakan (tampilkan semua rules + form tambah)
     */
    public function manageByKerusakan(Kerusakan $kerusakan)
    {
        $kerusakan->load(['rules.gejala']);
        $allGejala = Gejala::orderBy('kode')->get();

        return view('admin.rules.manage', compact('kerusakan', 'allGejala'));
    }

    /**
     * Simpan/update rules untuk satu kerusakan dari halaman manage
     */
    public function saveByKerusakan(Request $request, Kerusakan $kerusakan)
    {
        $request->validate([
            'rules'                       => 'nullable|array',
            'rules.*.nama_rule'           => 'nullable|string|max:100',
            'rules.*.gejala'              => 'required_with:rules|array|min:1',
            'rules.*.gejala.*.gejala_id'  => 'required|exists:gejala,id',
            'rules.*.gejala.*.cf_nilai'   => 'required|numeric|min:0.01|max:1.00',
        ]);

        // Hapus semua rules lama untuk kerusakan ini (cascade hapus pivot)
        Rule::where('kerusakan_id', $kerusakan->id)->delete();

        // Insert rules baru
        foreach ($request->input('rules', []) as $ruleData) {
            if (empty($ruleData['gejala'])) continue;

            $rule = Rule::create([
                'kerusakan_id' => $kerusakan->id,
                'nama_rule'    => $ruleData['nama_rule'] ?? null,
            ]);

            $pivotData = [];
            foreach ($ruleData['gejala'] as $item) {
                $pivotData[$item['gejala_id']] = [
                    'cf_nilai'   => $item['cf_nilai'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            $rule->gejala()->attach($pivotData);
        }

        return redirect()
            ->route('admin.kerusakan.show', $kerusakan)
            ->with('success', 'Rules untuk ' . $kerusakan->nama . ' berhasil disimpan.');
    }
}
