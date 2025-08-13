@extends('layouts.app')

@section('title', 'Dashboard - Sistema RRHH')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard - Sistema de Recursos Humanos</h1>
        <p class="text-gray-600">Bienvenido al panel de control principal</p>
    </div>
    
    <!-- Métricas principales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Empleados</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalEmpleados ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-building text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Departamentos</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $totalDepartamentos ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Presente Hoy</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $presentesHoy ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-briefcase text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Cargos Activos</h3>
                    <p class="text-2xl font-bold text-red-600">{{ $totalCargos ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enlaces rápidos -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Acciones Rápidas</h2>
            <div class="space-y-3">
                <a href="{{ route('empleados.create') }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <i class="fas fa-user-plus text-blue-600 mr-3"></i>
                    <span class="text-blue-800">Nuevo Empleado</span>
                </a>
                <a href="{{ route('departamentos.index') }}" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition">
                    <i class="fas fa-building text-green-600 mr-3"></i>
                    <span class="text-green-800">Gestionar Departamentos</span>
                </a>
                <a href="{{ route('asistencia.index') }}" class="flex items-center p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                    <i class="fas fa-clock text-yellow-600 mr-3"></i>
                    <span class="text-yellow-800">Control Asistencia</span>
                </a>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Departamentos</h2>
            <div class="space-y-3">
                @forelse($departamentosConEmpleados ?? [] as $departamento)
                    <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                        <span class="text-gray-700">{{ $departamento->nombre }}</span>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                            {{ $departamento->empleados_count }} empleados
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No hay departamentos registrados</p>
                @endforelse
                <a href="{{ route('departamentos.index') }}" class="block text-center text-blue-600 hover:text-blue-800 text-sm mt-3">
                    Ver todos los departamentos →
                </a>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Estado del Sistema</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Departamentos activos:</span>
                    <span class="text-green-600">{{ $totalDepartamentos ?? 0 }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Cargos disponibles:</span>
                    <span class="text-blue-600">{{ $totalCargos ?? 0 }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Empleados activos:</span>
                    <span class="text-purple-600">{{ $totalEmpleados ?? 0 }}</span>
                </div>
                @if(($presentesHoy ?? 0) > 0)
                <div class="flex justify-between">
                    <span class="text-gray-600">Presentes hoy:</span>
                    <span class="text-green-600">{{ $presentesHoy ?? 0 }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection