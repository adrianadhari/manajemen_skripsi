<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasUjian extends Model
{
    protected $table = 'berkas_ujian';

    public function ujian()
    {
        return $this->belongsTo(UjianSkripsi::class, 'ujian_skripsi_id');
    }
}
