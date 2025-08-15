<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Departamento;
use App\Models\Cargo;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::with('departamento', 'cargo')->get();
        $departamentos = Departamento::where('activo', true)->get();
        $cargos = Cargo::where('activo', true)->get();
        
        return view('empleados.index', compact('empleados', 'departamentos', 'cargos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departamentos = Departamento::where('activo', true)->get();
        $cargos = Cargo::where('activo', true)->get();
        return view('empleados.create', compact('departamentos', 'cargos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug temporal
        \Log::info('Datos recibidos:', $request->all());
        
        try {
            $request->validate([
                'codigo_empleado' => 'required|string|max:50|unique:empleados',
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'email' => 'required|email|unique:empleados',
                'telefono' => 'nullable|string|max:20',
                'cedula' => 'required|string|max:20|unique:empleados',
                'fecha_nacimiento' => 'required|date',
                'genero' => 'required|in:M,F,Otro',
                'direccion' => 'nullable|string',
                'fecha_ingreso' => 'required|date',
                'departamento_id' => 'required|exists:departamentos,id',
                'cargo_id' => 'required|exists:cargos,id',
                'salario' => 'required|numeric|min:0',
                'estado' => 'required|in:Activo,Inactivo,Vacaciones,Licencia',
            ]);

            $empleado = Empleado::create($request->all());
            
            \Log::info('Empleado creado:', $empleado->toArray());

            return redirect()->route('empleados.index')
                ->with('success', 'Empleado creado exitosamente.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación:', $e->errors());
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
                
        } catch (\Exception $e) {
            \Log::error('Error general:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el empleado: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $empleado = Empleado::with('departamento', 'cargo')->findOrFail($id);
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        $departamentos = Departamento::where('activo', true)->get();
        $cargos = Cargo::where('activo', true)->get();
        return view('empleados.edit', compact('empleado', 'departamentos', 'cargos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $empleado = Empleado::findOrFail($id);
        
        $request->validate([
            'codigo_empleado' => 'required|string|max:50|unique:empleados,codigo_empleado,' . $id,
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:empleados,email,' . $id,
            'telefono' => 'nullable|string|max:20',
            'cedula' => 'required|string|max:20|unique:empleados,cedula,' . $id,
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:M,F,Otro',
            'direccion' => 'nullable|string',
            'fecha_ingreso' => 'required|date',
            'departamento_id' => 'required|exists:departamentos,id',
            'cargo_id' => 'required|exists:cargos,id',
            'salario' => 'required|numeric|min:0',
            'estado' => 'required|in:Activo,Inactivo,Vacaciones,Licencia',
        ]);

        $empleado->update($request->all());

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        
        return redirect()->route('empleados.index')
            ->with('success', 'Empleado eliminado exitosamente.');
    }
}
