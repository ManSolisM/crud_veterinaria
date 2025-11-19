<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'hora',
        'motivo',
        'cliente_id',
        'numero_telefonico',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}