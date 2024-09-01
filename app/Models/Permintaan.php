<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Permintaan extends Model
{
    use
        HasFactory,
        HasFactory,
        Notifiable;

    protected $fillable = [
        'id_user_kec',
        'id_kecamatan',
        'data_permintaan',
        'jumlah_permintaan_beras',
        'jumlah_rts',

    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function userkec()
    {
        return $this->belongsTo(UserKec::class, 'id_user_kec');
    }
}
