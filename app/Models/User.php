<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [ //Agar password dan token tidak ikut muncul saat data user dikirim ke frontend atau API (diserialisasi).
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed', //proses mengacak data (misal password) jadi bentuk yang nggak bisa dibaca 
        ];
    }

    public function skripsi()
    {
        return $this->hasOne(Skripsi::class, 'mahasiswa_id'); //satu mahasiswa hanya boleh punya 1 skripsi
    }

    public function semuaSkripsi()
    {
        return $this->hasMany(Skripsi::class, 'mahasiswa_id'); //relasi untuk untuk ambil semua skripsi yang pernah diajukan
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->password)) {
                $user->password = bcrypt('12345678');
            }
        });
    }

    public function sudahPunyaSkripsiDisetujui(): bool
    {
        return $this->semuaSkripsi && $this->semuaSkripsi->contains(fn($skripsi) => $skripsi->status === 'Disetujui');
    }

    public function skripsiDisetujui()
    {
        return $this->hasOne(Skripsi::class, 'mahasiswa_id')->where('status', 'Disetujui');
    }

    public function skripsiDiajukan()
    {
        return $this->hasMany(Skripsi::class, 'mahasiswa_id')->where('status', 'Diajukan');
    }
}
