<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    protected $table = 'skripsi';

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function coDosen()
    {
        return $this->belongsTo(User::class, 'co_dosen_id');
    }

    public function ujians()
    {
        return $this->hasMany(UjianSkripsi::class);
    }
    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'skripsi_id');
    }
}
