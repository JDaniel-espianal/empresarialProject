<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cargo;
use App\Models\Departamento;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de departamentos
        $rrhh = Departamento::where('nombre', 'Recursos Humanos')->first();
        $tecnologia = Departamento::where('nombre', 'Tecnología')->first();
        $finanzas = Departamento::where('nombre', 'Finanzas')->first();
        $ventas = Departamento::where('nombre', 'Ventas')->first();
        $marketing = Departamento::where('nombre', 'Marketing')->first();
        $operaciones = Departamento::where('nombre', 'Operaciones')->first();

        $cargos = [
            // Recursos Humanos
            [
                'nombre' => 'Gerente de RRHH',
                'descripcion' => 'Responsable de la gestión integral del capital humano',
                'salario_base' => 80000.00,
                'departamento_id' => $rrhh->id,
                'activo' => true,
            ],
            [
                'nombre' => 'Especialista en Reclutamiento',
                'descripcion' => 'Encargado de procesos de selección y reclutamiento',
                'salario_base' => 45000.00,
                'departamento_id' => $rrhh->id,
                'activo' => true,
            ],
            [
                'nombre' => 'Analista de Nómina',
                'descripcion' => 'Procesamiento de nóminas y beneficios',
                'salario_base' => 35000.00,
                'departamento_id' => $rrhh->id,
                'activo' => true,
            ],

            // Tecnología
            [
                'nombre' => 'Gerente de TI',
                'descripcion' => 'Liderazgo en estrategia tecnológica',
                'salario_base' => 90000.00,
                'departamento_id' => $tecnologia->id,
                'activo' => true,
            ],
            [
                'nombre' => 'Desarrollador Senior',
                'descripcion' => 'Desarrollo de aplicaciones y sistemas',
                'salario_base' => 65000.00,
                'departamento_id' => $tecnologia->id,
                'activo' => true,
            ],
            [
                'nombre' => 'Desarrollador Junior',
                'descripcion' => 'Soporte en desarrollo de software',
                'salario_base' => 40000.00,
                'departamento_id' => $tecnologia->id,
                'activo' => true,
            ],
            [
                'nombre' => 'Administrador de Sistemas',
                'descripcion' => 'Gestión de infraestructura IT',
                'salario_base' => 55000.00,
                'departamento_id' => $tecnologia->id,
                'activo' => true,
            ],

            // Finanzas
            [
                'nombre' => 'Gerente Financiero',
                'descripcion' => 'Dirección estratégica financiera',
                'salario_base' => 85000.00,
                'departamento_id' => $finanzas->id,
                'activo' => true,
            ],
            [
                'nombre' => 'Contador',
                'descripcion' => 'Gestión contable y fiscal',
                'salario_base' => 50000.00,
                'departamento_id' => $finanzas->id,
                'activo' => true,
            ],
            [
                'nombre' => 'Analista Financiero',
                'descripcion' => 'Análisis y reportes financieros',
                'salario_base' => 45000.00,
                'departamento_id' => $finanzas->id,
                'activo' => true,
            ],

            // Ventas
            [
                'nombre' => 'Gerente de Ventas',
                'descripcion' => 'Liderazgo del equipo comercial',
                'salario_base' => 75000.00,
                'departamento_id' => $ventas->id,
                'activo' => true,
            ],
            [
                'nombre' => 'Ejecutivo de Ventas',
                'descripcion' => 'Gestión de clientes y ventas directas',
                'salario_base' => 42000.00,
                'departamento_id' => $ventas->id,
                'activo' => true,
            ],
            [
                'nombre' => 'Representante Comercial',
                'descripcion' => 'Atención y desarrollo de clientes',
                'salario_base' => 35000.00,
                'departamento_id' => $ventas->id,
                'activo' => true,
            ],

            // Marketing
            [
                'nombre' => 'Gerente de Marketing',
                'descripcion' => 'Estrategia de marketing y comunicación',
                'salario_base' => 70000.00,
                'departamento_id' => $marketing->id,
                'activo' => true,
            ],
            [
                'nombre' => 'Especialista en Marketing Digital',
                'descripcion' => 'Campañas digitales y redes sociales',
                'salario_base' => 48000.00,
                'departamento_id' => $marketing->id,
                'activo' => true,
            ],

            // Operaciones
            [
                'nombre' => 'Gerente de Operaciones',
                'descripcion' => 'Supervisión de procesos operativos',
                'salario_base' => 75000.00,
                'departamento_id' => $operaciones->id,
                'activo' => true,
            ],
            [
                'nombre' => 'Coordinador Logístico',
                'descripcion' => 'Gestión de logística y distribución',
                'salario_base' => 40000.00,
                'departamento_id' => $operaciones->id,
                'activo' => true,
            ],
        ];

        foreach ($cargos as $cargo) {
            Cargo::create($cargo);
        }
    }
}
