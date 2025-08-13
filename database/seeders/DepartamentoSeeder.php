<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departamento;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentos = [
            [
                'nombre' => 'Recursos Humanos',
                'descripcion' => 'Gestión del talento humano, reclutamiento y desarrollo organizacional',
                'activo' => true,
            ],
            [
                'nombre' => 'Tecnología',
                'descripcion' => 'Desarrollo de software, infraestructura IT y soporte técnico',
                'activo' => true,
            ],
            [
                'nombre' => 'Finanzas',
                'descripcion' => 'Contabilidad, presupuestos y análisis financiero',
                'activo' => true,
            ],
            [
                'nombre' => 'Ventas',
                'descripcion' => 'Comercialización de productos y servicios',
                'activo' => true,
            ],
            [
                'nombre' => 'Marketing',
                'descripcion' => 'Estrategias de mercadeo y comunicación',
                'activo' => true,
            ],
            [
                'nombre' => 'Operaciones',
                'descripcion' => 'Gestión de procesos operativos y logística',
                'activo' => true,
            ],
        ];

        foreach ($departamentos as $departamento) {
            Departamento::create($departamento);
        }
    }
}
