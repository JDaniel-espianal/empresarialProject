<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asistencia;
use App\Models\Empleado;
use Carbon\Carbon;

class AsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empleados = Empleado::all();
        
        // Generar asistencias para los últimos 30 días
        for ($i = 29; $i >= 0; $i--) {
            $fecha = Carbon::now()->subDays($i);
            
            // Solo generar para días laborables (lunes a viernes)
            if ($fecha->isWeekday()) {
                foreach ($empleados as $empleado) {
                    // 85% de probabilidad de asistencia normal
                    $rand = rand(1, 100);
                    
                    if ($rand <= 85) {
                        // Asistencia normal
                        $horaEntrada = $fecha->copy()->setTime(8, rand(0, 30), 0);
                        $horaSalida = $fecha->copy()->setTime(17, rand(0, 30), 0);
                        
                        Asistencia::create([
                            'empleado_id' => $empleado->id,
                            'fecha' => $fecha->format('Y-m-d'),
                            'hora_entrada' => $horaEntrada->format('H:i:s'),
                            'hora_salida' => $horaSalida->format('H:i:s'),
                            'estado' => 'presente',
                            'observaciones' => null,
                        ]);
                    } elseif ($rand <= 95) {
                        // Llegada tarde
                        $horaEntrada = $fecha->copy()->setTime(8, rand(31, 59), 0);
                        $horaSalida = $fecha->copy()->setTime(17, rand(0, 30), 0);
                        
                        Asistencia::create([
                            'empleado_id' => $empleado->id,
                            'fecha' => $fecha->format('Y-m-d'),
                            'hora_entrada' => $horaEntrada->format('H:i:s'),
                            'hora_salida' => $horaSalida->format('H:i:s'),
                            'estado' => 'tarde',
                            'observaciones' => 'Llegada tardía',
                        ]);
                    } else {
                        // Falta justificada o injustificada
                        $estado = (rand(1, 2) == 1) ? 'falta_justificada' : 'falta_injustificada';
                        $observacion = $estado == 'falta_justificada' ? 'Permiso médico' : 'Falta sin justificar';
                        
                        Asistencia::create([
                            'empleado_id' => $empleado->id,
                            'fecha' => $fecha->format('Y-m-d'),
                            'hora_entrada' => null,
                            'hora_salida' => null,
                            'estado' => $estado,
                            'observaciones' => $observacion,
                        ]);
                    }
                }
            }
        }
    }
}
