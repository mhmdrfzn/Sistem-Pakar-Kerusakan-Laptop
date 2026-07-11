<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Restrukturisasi Rules: Multi-Gejala per Rule dengan CF per Gejala
 *
 * Sebelum: rules(id, kerusakan_id, gejala_id, cf_nilai)
 * Sesudah:
 *   rules(id, kerusakan_id, nama_rule)
 *   rule_gejala(id, rule_id, gejala_id, cf_nilai)
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── STEP 1: Buat tabel pivot rule_gejala ──────────────────────────────
        Schema::create('rule_gejala', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rule_id')
                  ->constrained('rules')
                  ->onDelete('cascade');
            $table->foreignId('gejala_id')
                  ->constrained('gejala')
                  ->onDelete('cascade');
            $table->decimal('cf_nilai', 3, 2)->comment('CF Pakar per gejala dalam rule ini');
            $table->timestamps();
            $table->unique(['rule_id', 'gejala_id']);
        });

        // ── STEP 2: Konversi data lama → Opsi A ───────────────────────────────
        // Kelompokkan semua rules lama per kerusakan_id
        // → 1 kerusakan = 1 rule baru yang memuat semua gejala lamanya
        $kerusakanIds = DB::table('rules')
            ->select('kerusakan_id')
            ->distinct()
            ->pluck('kerusakan_id');

        foreach ($kerusakanIds as $kerusakanId) {
            // Ambil semua baris rule lama untuk kerusakan ini
            $oldRules = DB::table('rules')
                ->where('kerusakan_id', $kerusakanId)
                ->orderBy('id')
                ->get();

            if ($oldRules->isEmpty()) continue;

            // Pakai id rule pertama sebagai "master rule"
            $masterRuleId = $oldRules->first()->id;

            // Pindahkan semua (gejala_id + cf_nilai) ke pivot rule_gejala
            foreach ($oldRules as $oldRule) {
                DB::table('rule_gejala')->insert([
                    'rule_id'    => $masterRuleId,
                    'gejala_id'  => $oldRule->gejala_id,
                    'cf_nilai'   => $oldRule->cf_nilai,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Hapus semua rule lain (selain master) untuk kerusakan ini
            DB::table('rules')
                ->where('kerusakan_id', $kerusakanId)
                ->where('id', '!=', $masterRuleId)
                ->delete();
        }

        // ── STEP 3: Tambah kolom nama_rule ke tabel rules ─────────────────────
        Schema::table('rules', function (Blueprint $table) {
            $table->string('nama_rule')->nullable()->after('kerusakan_id');
        });

        // ── STEP 4: Hapus kolom & constraint lama dari tabel rules ────────────
        // Di MySQL: drop FK dulu → drop unique index → drop column
        Schema::table('rules', function (Blueprint $table) {
            $table->dropForeign(['gejala_id']);       // drop FK dulu
            $table->dropUnique(['kerusakan_id', 'gejala_id']); // baru unique index
            $table->dropColumn(['gejala_id', 'cf_nilai']);     // terakhir baru kolom
        });
    }

    public function down(): void
    {
        // Kembalikan kolom lama
        Schema::table('rules', function (Blueprint $table) {
            $table->foreignId('gejala_id')
                  ->nullable()
                  ->constrained('gejala')
                  ->onDelete('cascade');
            $table->decimal('cf_nilai', 3, 2)->nullable();
            $table->dropColumn('nama_rule');
        });

        // Pindahkan data pivot kembali ke rules
        $ruleGejalas = DB::table('rule_gejala')->get();
        foreach ($ruleGejalas as $rg) {
            $rule = DB::table('rules')->find($rg->rule_id);
            if (!$rule) continue;

            // Update master rule atau insert baru
            $exists = DB::table('rules')
                ->where('kerusakan_id', $rule->kerusakan_id)
                ->where('gejala_id', $rg->gejala_id)
                ->exists();

            if (!$exists) {
                DB::table('rules')->insert([
                    'kerusakan_id' => $rule->kerusakan_id,
                    'gejala_id'    => $rg->gejala_id,
                    'cf_nilai'     => $rg->cf_nilai,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }

        Schema::dropIfExists('rule_gejala');
    }
};
