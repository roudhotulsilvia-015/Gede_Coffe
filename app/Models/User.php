<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Model untuk pengguna yang berisi informasi dasar seperti nama, username, password, dan peran.
#[Fillable(['name', 'username', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{// Menentukan kolom yang dapat diisi secara massal.
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
// Mendefinisikan tipe data untuk kolom tertentu.
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
// Mendefinisikan relasi one-to-many dengan model Transaksi.
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
