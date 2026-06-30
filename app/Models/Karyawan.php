<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Model untuk karyawan yang berisi informasi dasar seperti nama, jabatan, dan telepon.
class Karyawan extends Model
{// Menentukan kolom yang dapat diisi secara massal.
    protected $fillable = ['nama', 'jabatan', 'telepon'];
}