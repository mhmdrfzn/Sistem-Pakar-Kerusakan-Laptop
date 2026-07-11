<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerusakan extends Model
{
    use HasFactory;

    protected $table = 'kerusakan';

    protected $fillable = [
        'kode',
        'nama',
        'komponen_pengganti',
        'est_part_min',
        'est_part_max',
        'service_fee',
        'solutions',
        'icon',
        'kategori',
    ];

    protected $casts = [
        'solutions' => 'array',
        'est_part_min' => 'integer',
        'est_part_max' => 'integer',
        'service_fee' => 'integer',
    ];

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function gejala()
    {
        return $this->belongsToMany(Gejala::class, 'rules')->withPivot('cf_nilai');
    }

    public function getEstimasiTotalMinAttribute()
    {
        return $this->est_part_min + $this->service_fee;
    }

    public function getEstimasiTotalMaxAttribute()
    {
        return $this->est_part_max + $this->service_fee;
    }

    public function formatHarga($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}
