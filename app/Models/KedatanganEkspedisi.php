<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KedatanganEkspedisi extends Model
{
    protected $fillable = ['nama_kurir', 'id_ekspedisi', 'id_pegawai', 'id_user', 'foto'];
    public function ekspedisi(): BelongsTo
    {
        return $this->belongsTo(Ekspedisi::class, 'id_ekspedisi');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
    use HasFactory;
}
