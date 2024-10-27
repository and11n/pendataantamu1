<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KedatanganTamu extends Model
{
    protected $table = 'kedatangan_tamus';

    protected $fillable = [
        'instansi',
        'id_pegawai',
        'id_tamu',
        'foto',
        'tujuan',
        'qr_code',
        'waktu_perjanjian',
        'waktu_kedatangan',
        'status',
        'alasan',
        'token'
    ];

    // Relasi ke model Pegawai
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    // Relasi ke model Tamu
    public function tamu(): BelongsTo
    {
        return $this->belongsTo(Tamu::class, 'id_tamu'); // Pastikan id_tamu adalah foreign key
    }

    use HasFactory;
}
