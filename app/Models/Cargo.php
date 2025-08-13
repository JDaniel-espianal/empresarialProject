<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'salario_base',
        'departamento_id',
        'activo'
    ];

    protected $casts = [
        'salario_base' => 'decimal:2',
        'activo' => 'boolean'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }
}
