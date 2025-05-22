<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'nis', 'gender', 'rombel', 'alamat', 'kontak', 'email', 'foto', 'status_lapor_pkl'];

    public function pkls()
    {
        return $this->hasMany(Pkl::class); //relasi dengan pkl
    }
}
