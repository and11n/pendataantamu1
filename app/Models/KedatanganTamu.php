<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KedatanganTamu extends Model
{
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, "id_pegawai");
    }
    protected $fillable = ['nama', 'instansi', 'alamat', 'id_pegawai', 'id_user', 'foto', 'no_telp', 'email', 'tujuan', 'qr_code', 'waktu_perjanjian', 'waktu_kedatangan', 'status', 'keterangan'];
    use HasFactory;
}
