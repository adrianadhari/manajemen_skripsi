<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapSkripsi extends Model
{
    protected $fillable = ['status', 'jumlah'];

    public $timestamps = false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

}
