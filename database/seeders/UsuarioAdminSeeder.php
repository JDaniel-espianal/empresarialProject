<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Cargo;
use Illuminate\Support\Facades\Hash;

class UsuarioAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador solo si no existe
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@empresa.com'],
            [
                'name' => 'Administrador Sistema',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Obtener un cargo para asignar al admin
        $gerenteRRHH = Cargo::where('nombre', 'Gerente de RRHH')->first();
        
        if ($gerenteRRHH && !Empleado::where('email', 'admin@empresa.com')->exists()) {
            // Crear empleado admin solo si no existe
            Empleado::create([
                'codigo_empleado' => 'EMP001',
                'nombre' => 'Administrador',
                'apellidos' => 'Sistema',
                'cedula' => '00000000',
                'email' => 'admin@empresa.com',
                'telefono' => '555-0000',
                'direccion' => 'Oficina Principal',
                'fecha_nacimiento' => '1980-01-01',
                'genero' => 'M',
                'fecha_ingreso' => now()->format('Y-m-d'),
                'departamento_id' => $gerenteRRHH->departamento_id,
                'cargo_id' => $gerenteRRHH->id,
                'salario' => 100000.00,
                'estado' => 'Activo',
            ]);
        }

        // Crear algunos empleados adicionales simplificados
        $cargos = Cargo::take(3)->get();
        
        foreach ($cargos as $index => $cargo) {
            if ($cargo->nombre !== 'Gerente de RRHH') { // Evitar duplicar el gerente de RRHH
                $user = User::create([
                    'name' => 'Empleado ' . ($index + 1),
                    'email' => 'empleado' . ($index + 1) . '@empresa.com',
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]);

                Empleado::create([
                    'codigo_empleado' => 'EMP00' . ($index + 2),
                    'nombre' => 'Empleado',
                    'apellidos' => 'Número ' . ($index + 1),
                    'cedula' => '1111111' . $index,
                    'email' => 'empleado' . ($index + 1) . '@empresa.com',
                    'telefono' => '555-111' . $index,
                    'direccion' => 'Dirección ' . ($index + 1),
                    'fecha_nacimiento' => '1990-0' . (($index % 9) + 1) . '-15',
                    'genero' => ($index % 2 == 0) ? 'M' : 'F',
                    'fecha_ingreso' => now()->subMonths($index)->format('Y-m-d'),
                    'departamento_id' => $cargo->departamento_id,
                    'cargo_id' => $cargo->id,
                    'salario' => $cargo->salario_base,
                    'estado' => 'Activo',
                ]);
            }
        }
    }
}
