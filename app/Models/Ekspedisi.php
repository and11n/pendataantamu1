<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekspedisi extends Model
{
    use HasFactory;
    protected $table='ekspedisis';
    protected $fillable = ['id_ekspedisi', 'nama_kurir', 'ekspedisi', 'no_telp'];

    protected $primaryKey = 'id_ekspedisi';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        // Generate id_ekspedisi before saving
        static::creating(function ($model) {
            // Ambil record terakhir
            $lastRecord = self::orderBy('id_ekspedisi', 'desc')->first();
            // Ambil angka dari id terakhir dan tambahkan 1
            $lastIdNumber = $lastRecord ? (int)substr($lastRecord->id_ekspedisi, 4) : 0;
            // Generate id baru
            $model->id_ekspedisi = 'EKS_' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
        });
    }
    public function kedatanganEkspedisis()
    {
        return $this->hasMany(KedatanganEkspedisi::class, 'id_ekspedisi', 'id_ekspedisi');
    }
}
