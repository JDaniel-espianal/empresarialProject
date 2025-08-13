<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'codigo_empleado',
        'nombre',
        'apellidos',
        'email',
        'telefono',
        'cedula',
        'fecha_nacimiento',
        'genero',
        'direccion',
        'fecha_ingreso',
        'departamento_id',
        'cargo_id',
        'salario',
        'estado',
        'foto'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
        'salario' => 'decimal:2'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellidos;
    }
}
