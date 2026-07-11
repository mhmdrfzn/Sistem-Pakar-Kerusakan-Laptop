<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $table = 'gejala';

    protected $fillable = [
        'kode',
        'deskripsi',
        'kategori',
    ];

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function kerusakan()
    {
        return $this->belongsToMany(Kerusakan::class, 'rules')->withPivot('cf_nilai');
    }
}
