<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserKec extends Model
{
    use
        HasFactory,
        HasFactory,
        Notifiable;

    protected $fillable = [
        'id_kecamatan',
        'nama_penanggung_jawab',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',

    ];
}
