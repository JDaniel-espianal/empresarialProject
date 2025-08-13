@extends('layouts.app')

@section('title', 'Gestión de Vacaciones - Sistema RRHH')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestión de Vacaciones</h1>
        <button onclick="openSolicitudModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Nueva Solicitud
        </button>
    </div>
    
    <!-- Estadísticas de vacaciones -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Pendientes</h3>
                    <p class="text-2xl font-bold text-blue-600">0</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Aprobadas</h3>
                    <p class="text-2xl font-bold text-green-600">0</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-user-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">En Vacaciones</h3>
                    <p class="text-2xl font-bold text-yellow-600">0</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Rechazadas</h3>
                    <p class="text-2xl font-bold text-red-600">0</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filtros -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos los empleados</option>
                    <!-- Aquí se cargarían los empleados -->
                </select>
            </div>
            <div>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos los estados</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Aprobada">Aprobada</option>
                    <option value="Rechazada">Rechazada</option>
                    <option value="En curso">En curso</option>
                </select>
            </div>
            <div>
                <input type="month" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <button class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    <i class="fas fa-search mr-2"></i>Filtrar
                </button>
            </div>
        </div>
    </div>
    
    <!-- Lista de solicitudes -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Solicitudes de Vacaciones</h2>
            
            <div class="text-center py-12">
                <i class="fas fa-calendar-alt text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay solicitudes de vacaciones</h3>
                <p class="text-gray-500 mb-4">Las solicitudes de vacaciones aparecerán aquí</p>
                <button onclick="openSolicitudModal()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>Crear Primera Solicitud
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para nueva solicitud -->
<div id="solicitudModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Nueva Solicitud de Vacaciones</h3>
                <button onclick="closeSolicitudModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="solicitudForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Empleado*</label>
                    <select name="empleado_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Seleccionar empleado...</option>
                        <!-- Aquí se cargarían los empleados -->
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inicio*</label>
                    <input type="date" name="fecha_inicio" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Fin*</label>
                    <input type="date" name="fecha_fin" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Vacaciones*</label>
                    <select name="tipo" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Seleccionar tipo...</option>
                        <option value="Vacaciones Anuales">Vacaciones Anuales</option>
                        <option value="Vacaciones Compensatorias">Vacaciones Compensatorias</option>
                        <option value="Permiso Personal">Permiso Personal</option>
                        <option value="Licencia Médica">Licencia Médica</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Días solicitados</label>
                    <input type="number" name="dias" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
                    <p class="text-sm text-gray-500 mt-1">Se calcula automáticamente</p>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo/Observaciones</label>
                    <textarea name="motivo" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describa el motivo de la solicitud..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeSolicitudModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-paper-plane mr-2"></i>Enviar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openSolicitudModal() {
    document.getElementById('solicitudForm').reset();
    document.getElementById('solicitudModal').classList.remove('hidden');
}

function closeSolicitudModal() {
    document.getElementById('solicitudModal').classList.add('hidden');
}

// Cerrar modal al hacer clic fuera
document.getElementById('solicitudModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeSolicitudModal();
    }
});

// Calcular días automáticamente
document.addEventListener('DOMContentLoaded', function() {
    const fechaInicio = document.querySelector('input[name="fecha_inicio"]');
    const fechaFin = document.querySelector('input[name="fecha_fin"]');
    const diasInput = document.querySelector('input[name="dias"]');
    
    function calcularDias() {
        if (fechaInicio.value && fechaFin.value) {
            const inicio = new Date(fechaInicio.value);
            const fin = new Date(fechaFin.value);
            
            if (fin >= inicio) {
                const diffTime = Math.abs(fin - inicio);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                diasInput.value = diffDays;
            } else {
                diasInput.value = '';
            }
        }
    }
    
    fechaInicio.addEventListener('change', calcularDias);
    fechaFin.addEventListener('change', calcularDias);
});

// Manejar envío del formulario
document.getElementById('solicitudForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    console.log('Solicitud de vacaciones:', {
        empleado_id: formData.get('empleado_id'),
        fecha_inicio: formData.get('fecha_inicio'),
        fecha_fin: formData.get('fecha_fin'),
        tipo: formData.get('tipo'),
        dias: formData.get('dias'),
        motivo: formData.get('motivo')
    });
    
    alert('Solicitud enviada exitosamente');
    closeSolicitudModal();
});
</script>
@endsection
