<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Industri extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'foto', 'bidang_usaha', 'alamat', 'kontak', 'email', 'website'];

    public function pkls()
    {
        return $this->hasMany(Pkl::class); //relasi dengan pkl
    }
}
