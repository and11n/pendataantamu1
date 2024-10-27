<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pegawai extends Authenticatable
{
    use Notifiable;
    protected $primaryKey = 'nip';
    protected $fillable = ["nip", "id_user", "ptk", "no_telp"];
    use HasFactory;

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
        return $this->hasMany(Tamu::class, 'id_pegawai');
    }
}
