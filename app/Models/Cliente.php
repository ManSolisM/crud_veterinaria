<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'nombre_mascota',
        'raza',
        'especie',
        'edad_mascota',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

    public function vacunas()
    {
        return $this->hasMany(Vacuna::class);
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->apellido_paterno} {$this->apellido_materno} {$this->nombres}";
    }
}