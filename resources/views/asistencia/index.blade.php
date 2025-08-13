@extends('layouts.app')

@section('title', 'Control de Asistencia - Sistema RRHH')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Control de Asistencia</h1>
    
    <!-- Reloj y marcación -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Marcar Entrada/Salida</h2>
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2" id="current-time"></div>
                <div class="text-lg text-gray-600 mb-6" id="current-date"></div>
                
                <div class="space-y-3">
                    <button onclick="marcarEntrada()" class="w-full bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>Marcar Entrada
                    </button>
                    <button onclick="marcarSalida()" class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>Marcar Salida
                    </button>
                </div>
                
                <div class="mt-4 p-3 bg-gray-100 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Tu última marcación fue registrada a las <strong>--:--</strong>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Mi Asistencia de Hoy</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <div>
                        <span class="text-sm text-gray-600">Entrada</span>
                        <div class="font-semibold text-green-700">--:--</div>
                    </div>
                    <div class="text-green-600">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>
                
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <span class="text-sm text-gray-600">Salida</span>
                        <div class="font-semibold text-gray-500">--:--</div>
                    </div>
                    <div class="text-gray-400">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                </div>
                
                <div class="border-t pt-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Horas trabajadas:</span>
                        <span class="font-semibold">-- horas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Estadísticas de asistencia -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Presentes Hoy</h3>
                    <p class="text-2xl font-bold text-green-600">0</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-times text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Ausentes</h3>
                    <p class="text-2xl font-bold text-red-600">0</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Tardanzas</h3>
                    <p class="text-2xl font-bold text-yellow-600">0</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-calendar text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Total Empleados</h3>
                    <p class="text-2xl font-bold text-blue-600">0</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Registro de asistencia del día -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Asistencia del Día</h2>
                <div class="flex space-x-2">
                    <input type="date" id="fecha-filtro" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button onclick="filtrarPorFecha()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <div class="text-center py-12">
                    <i class="fas fa-clock text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay registros de asistencia</h3>
                    <p class="text-gray-500">Los empleados pueden marcar su asistencia usando el sistema</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Actualizar reloj en tiempo real
function updateTime() {
    const now = new Date();
    const timeOptions = { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit',
        hour12: false 
    };
    const dateOptions = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    
    document.getElementById('current-time').textContent = now.toLocaleTimeString('es-ES', timeOptions);
    document.getElementById('current-date').textContent = now.toLocaleDateString('es-ES', dateOptions);
}

// Inicializar reloj
setInterval(updateTime, 1000);
updateTime();

// Establecer fecha actual en el filtro
document.getElementById('fecha-filtro').value = new Date().toISOString().split('T')[0];

function marcarEntrada() {
    const ahora = new Date().toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
    
    // Aquí iría la lógica para enviar al servidor
    console.log('Marcando entrada a las:', ahora);
    
    // Simulación de respuesta exitosa
    alert(`Entrada marcada exitosamente a las ${ahora}`);
    
    // Actualizar la interfaz (esto se haría con datos reales del servidor)
    // actualizarAsistencia('entrada', ahora);
}

function marcarSalida() {
    const ahora = new Date().toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
    
    // Aquí iría la lógica para enviar al servidor
    console.log('Marcando salida a las:', ahora);
    
    // Simulación de respuesta exitosa
    alert(`Salida marcada exitosamente a las ${ahora}`);
    
    // Actualizar la interfaz (esto se haría con datos reales del servidor)
    // actualizarAsistencia('salida', ahora);
}

function filtrarPorFecha() {
    const fecha = document.getElementById('fecha-filtro').value;
    console.log('Filtrando asistencia por fecha:', fecha);
    
    // Aquí iría la lógica para filtrar los datos
    // cargarAsistenciaPorFecha(fecha);
}

function actualizarAsistencia(tipo, hora) {
    // Esta función actualizaría la interfaz con los datos reales
    // Por ahora es solo un placeholder
}
</script>
@endsection
