<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UjianSkripsi extends Model
{
    protected $table = 'ujian_skripsi';

    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class);
    }

    public function berkas()
    {
        return $this->hasMany(BerkasUjian::class);
    }

    public function scopeSeminarProposalTerverifikasi(Builder $query): Builder
    {
        return $query->where('jenis_ujian', 'Seminar Proposal')->where('status', 'Terverifikasi');
    }
    public function scopeSeminarHasilTerverifikasi(Builder $query): Builder
    {
        return $query->where('jenis_ujian', 'Seminar Hasil')->where('status', 'Terverifikasi');
    }
    public function scopeSidangSkripsiTerverifikasi(Builder $query): Builder
    {
        return $query->where('jenis_ujian', 'Sidang Skripsi')->where('status', 'Terverifikasi');
    }

    public function penguji1()
    {
        return $this->belongsTo(User::class, 'penguji_1_id');
    }

    public function penguji2()
    {
        return $this->belongsTo(User::class, 'penguji_2_id');
    }
}
