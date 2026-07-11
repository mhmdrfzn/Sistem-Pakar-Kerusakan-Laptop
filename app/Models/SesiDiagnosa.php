<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiDiagnosa extends Model
{
    use HasFactory;

    protected $table = 'sesi_diagnosa';

    protected $fillable = [
        'nama_pengguna',
        'nama_laptop',
        'gejala_dipilih',
        'hasil_diagnosa',
        'ip_address',
    ];

    protected $casts = [
        'gejala_dipilih' => 'array',
        'hasil_diagnosa' => 'array',
    ];
}
