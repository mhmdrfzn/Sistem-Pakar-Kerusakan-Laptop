<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $table = 'rules';

    protected $fillable = [
        'kerusakan_id',
        'nama_rule',
    ];

    /**
     * Kerusakan yang menjadi konklusi rule ini
     */
    public function kerusakan()
    {
        return $this->belongsTo(Kerusakan::class);
    }

    /**
     * Gejala-gejala (premis) dalam rule ini, beserta nilai CF pakar per gejala
     */
    public function gejala()
    {
        return $this->belongsToMany(Gejala::class, 'rule_gejala')
                    ->withPivot('cf_nilai')
                    ->withTimestamps();
    }
}
