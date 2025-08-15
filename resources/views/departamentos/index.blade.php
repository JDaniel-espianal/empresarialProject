@extends('layouts.app')

@section('title', 'Departamentos - Sistema RRHH')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestión de Departamentos</h1>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700" onclick="openCreateModal()">
            <i class="fas fa-plus mr-2"></i>Nuevo Departamento
        </button>
    </div>
    
    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-building text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Total Departamentos</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $departamentos->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Activos</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $departamentos->where('activo', true)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Total Empleados</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $departamentos->sum(function($dept) { return $dept->empleados->count(); }) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Lista de departamentos -->
    <div class="bg-white rounded-lg shadow">
        @if($departamentos->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empleados</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cargos</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($departamentos as $departamento)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $departamento->nombre }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ Str::limit($departamento->descripcion, 50) ?? 'Sin descripción' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($departamento->activo) bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $departamento->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                                        {{ $departamento->empleados->count() }} empleados
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">
                                        {{ $departamento->cargos->count() }} cargos
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button onclick="viewDepartment({{ $departamento->id }})" class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="editDepartment({{ $departamento->id }})" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($departamento->empleados->count() == 0 && $departamento->cargos->count() == 0)
                                            <form action="{{ route('departamentos.destroy', $departamento->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este departamento?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400" title="No se puede eliminar: tiene empleados o cargos asociados">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6">
                <div class="text-center py-12">
                    <i class="fas fa-building text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay departamentos registrados</h3>
                    <p class="text-gray-500 mb-4">Comienza creando los departamentos de tu empresa</p>
                    <button onclick="openCreateModal()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Crear Primer Departamento
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal para crear/editar departamento -->
<div id="departmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Nuevo Departamento</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="departmentForm" action="{{ route('departamentos.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Departamento*</label>
                    <input type="text" id="nombre" name="nombre" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ej: Recursos Humanos" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Descripción del departamento..."></textarea>
                </div>
                
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" id="activo" name="activo" checked class="rounded">
                        <span class="ml-2 text-sm text-gray-700">Departamento activo</span>
                    </label>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Nuevo Departamento';
    document.getElementById('departmentForm').action = "{{ route('departamentos.store') }}";
    document.getElementById('departmentForm').reset();
    document.getElementById('activo').checked = true;
    document.getElementById('departmentModal').classList.remove('hidden');
}

function editDepartment(id) {
    // Aquí cargarías los datos del departamento y abrirías el modal en modo edición
    console.log('Editar departamento ID:', id);
}

function viewDepartment(id) {
    // Aquí mostrarías los detalles del departamento
    console.log('Ver departamento ID:', id);
}

function closeModal() {
    document.getElementById('departmentModal').classList.add('hidden');
}

// Cerrar modal al hacer clic fuera de él
document.getElementById('departmentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection