<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;
    protected $table='tamus';
    protected $fillable = ['id_tamu', 'nama', 'email', 'alamat', 'no_telp'];

    protected $primaryKey = 'id_tamu';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tamu) {
            $maxId = static::max('id_tamu');
            if ($maxId) {
                $nomorUrut = intval(substr($maxId, 2)) + 1;
            } else {
                $nomorUrut = 1;
            }
            $tamu->id_tamu = 'TM' . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
        });
    }

    public function tamu(): BelongsTo
    {
        return $this->belongsTo(Tamu::class, 'id_tamu');
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

}
