<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    protected $table = "bimbingan";

    public function skripsi() {
        return $this->belongsTo(Skripsi::class, 'skripsi_id');
    }
}
