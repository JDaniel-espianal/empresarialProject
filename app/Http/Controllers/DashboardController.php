<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Cargo;
use App\Models\Empleado;
use App\Models\Asistencia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $totalDepartamentos = Departamento::where('activo', true)->count();
        $totalCargos = Cargo::where('activo', true)->count();
        $totalEmpleados = Empleado::where('estado', 'Activo')->count();
        
        // Asistencias de hoy
        $today = Carbon::today();
        $asistenciasHoy = Asistencia::whereDate('fecha', $today)->count();
        $presentesHoy = Asistencia::whereDate('fecha', $today)
            ->where('estado', 'presente')->count();
        $tardesHoy = Asistencia::whereDate('fecha', $today)
            ->where('estado', 'tarde')->count();
        $faltasHoy = Asistencia::whereDate('fecha', $today)
            ->whereIn('estado', ['falta_justificada', 'falta_injustificada'])->count();
        
        // Departamentos con más empleados
        $departamentosConEmpleados = Departamento::withCount('empleados')
            ->where('activo', true)
            ->orderBy('empleados_count', 'desc')
            ->take(5)
            ->get();
        
        // Últimas asistencias
        $ultimasAsistencias = Asistencia::with('empleado')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalDepartamentos',
            'totalCargos', 
            'totalEmpleados',
            'asistenciasHoy',
            'presentesHoy',
            'tardesHoy',
            'faltasHoy',
            'departamentosConEmpleados',
            'ultimasAsistencias'
        ));
    }
}
