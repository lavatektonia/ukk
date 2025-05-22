<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'nip', 'gender', 'alamat', 'kontak', 'email'];

    public function pkls()
    {
        return $this->hasMany(Pkl::class); //relasi dengan pkl
    }
}
