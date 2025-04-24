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
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function skripsi()
    {
        return $this->hasOne(Skripsi::class, 'mahasiswa_id');
    }

    public function semuaSkripsi()
    {
        return $this->hasMany(Skripsi::class, 'mahasiswa_id');
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
}
