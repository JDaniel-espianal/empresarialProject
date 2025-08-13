<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar seeders en orden de dependencias
        $this->call([
            DepartamentoSeeder::class,
            CargoSeeder::class,
            UsuarioAdminSeeder::class, // Seeder simplificado para usuarios y empleados
            // EmpleadoSeeder::class, // Omitido temporalmente
            // AsistenciaSeeder::class, // Depende de empleados
        ]);
    }
}
