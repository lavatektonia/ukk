<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pkl extends Model
{
    use HasFactory;
    protected $fillable = ['siswa_id', 'guru_id', 'industri_id', 'mulai', 'selesai'];

    public function guru()
    {
        return $this->belongsTo(Guru::class); //relasi dengan guru
    }
    
    public function industri()
    {
        return $this->belongsTo(Industri::class); //relasi dengan industri
    }
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class); //relasi dengan siswa
    }
}
