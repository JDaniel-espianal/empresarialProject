<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Empleado;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asistencias = Asistencia::with('empleado')
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_entrada', 'desc')
            ->get();
        $empleados = Empleado::where('estado', 'Activo')->get();
        
        return view('asistencia.index', compact('asistencias', 'empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empleados = Empleado::where('estado', 'Activo')->get();
        return view('asistencia.create', compact('empleados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha' => 'required|date',
            'hora_entrada' => 'nullable|date_format:H:i',
            'hora_salida' => 'nullable|date_format:H:i|after:hora_entrada',
            'estado' => 'required|in:presente,tarde,falta_justificada,falta_injustificada',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // Verificar si ya existe asistencia para ese empleado en esa fecha
        $existeAsistencia = Asistencia::where('empleado_id', $request->empleado_id)
            ->where('fecha', $request->fecha)
            ->exists();

        if ($existeAsistencia) {
            return redirect()->back()
                ->with('error', 'Ya existe un registro de asistencia para este empleado en la fecha seleccionada.')
                ->withInput();
        }

        Asistencia::create($request->all());

        return redirect()->route('asistencia.index')
            ->with('success', 'Asistencia registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $asistencia = Asistencia::with('empleado')->findOrFail($id);
        return view('asistencia.show', compact('asistencia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $asistencia = Asistencia::findOrFail($id);
        $empleados = Empleado::where('estado', 'Activo')->get();
        return view('asistencia.edit', compact('asistencia', 'empleados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $asistencia = Asistencia::findOrFail($id);
        
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha' => 'required|date',
            'hora_entrada' => 'nullable|date_format:H:i',
            'hora_salida' => 'nullable|date_format:H:i|after:hora_entrada',
            'estado' => 'required|in:presente,tarde,falta_justificada,falta_injustificada',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $asistencia->update($request->all());

        return redirect()->route('asistencia.index')
            ->with('success', 'Asistencia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asistencia = Asistencia::findOrFail($id);
        $asistencia->delete();
        
        return redirect()->route('asistencia.index')
            ->with('success', 'Registro de asistencia eliminado exitosamente.');
    }

    /**
     * Marcar entrada del empleado
     */
    public function marcarEntrada(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id'
        ]);

        $hoy = Carbon::today();
        $ahora = Carbon::now();
        
        // Verificar si ya marcó entrada hoy
        $asistenciaHoy = Asistencia::where('empleado_id', $request->empleado_id)
            ->where('fecha', $hoy)
            ->first();

        if ($asistenciaHoy) {
            return response()->json([
                'success' => false,
                'message' => 'Ya has marcado entrada hoy.'
            ]);
        }

        // Determinar el estado basado en la hora
        $estado = 'presente';
        if ($ahora->hour > 8 || ($ahora->hour == 8 && $ahora->minute > 30)) {
            $estado = 'tarde';
        }

        Asistencia::create([
            'empleado_id' => $request->empleado_id,
            'fecha' => $hoy,
            'hora_entrada' => $ahora->format('H:i:s'),
            'estado' => $estado,
            'observaciones' => $estado == 'tarde' ? 'Llegada tardía' : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Entrada marcada exitosamente.',
            'estado' => $estado
        ]);
    }

    /**
     * Marcar salida del empleado
     */
    public function marcarSalida(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id'
        ]);

        $hoy = Carbon::today();
        $ahora = Carbon::now();
        
        $asistenciaHoy = Asistencia::where('empleado_id', $request->empleado_id)
            ->where('fecha', $hoy)
            ->first();

        if (!$asistenciaHoy) {
            return response()->json([
                'success' => false,
                'message' => 'No has marcado entrada hoy.'
            ]);
        }

        if ($asistenciaHoy->hora_salida) {
            return response()->json([
                'success' => false,
                'message' => 'Ya has marcado salida hoy.'
            ]);
        }

        $asistenciaHoy->update([
            'hora_salida' => $ahora->format('H:i:s')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Salida marcada exitosamente.'
        ]);
    }
}
