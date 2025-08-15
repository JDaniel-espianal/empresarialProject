@extends('layouts.app')

@section('title', 'Lista de Empleados - Sistema RRHH')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Lista de Empleados</h1>
        <button onclick="openCreateModal()" class="bg-cyan-900 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Nuevo Empleado
        </button>
    </div>
    
    <!-- AG Grid Container -->
    <div class="bg-white rounded-lg shadow p-4">
        <div id="empleadosGrid" class="ag-theme-alpine" style="height: 600px; width: 100%;"></div>
    </div>
</div>

<!-- Modal de creación de empleado -->
@include('empleados.create')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const empleadosData = @json($empleados);
    
    const columnDefs = [
        { field: 'codigo_empleado', headerName: 'Código', width: 120 },
        { 
            headerName: 'Nombre Completo', 
            width: 220,
            valueGetter: params => `${params.data.nombre || ''} ${params.data.apellidos || ''}`.trim()
        },
        { field: 'email', headerName: 'Email', width: 200 },
        { 
            field: 'departamento.nombre', 
            headerName: 'Departamento', 
            width: 150,
            valueGetter: params => params.data.departamento?.nombre || 'Sin departamento'
        },
        { 
            field: 'cargo.nombre', 
            headerName: 'Cargo', 
            width: 150,
            valueGetter: params => params.data.cargo?.nombre || 'Sin cargo'
        },
        { 
            field: 'estado', 
            headerName: 'Estado', 
            width: 120,
            cellRenderer: function(params) {
                const estado = params.value;
                const colors = {
                    'Activo': 'bg-green-100 text-green-800',
                    'Inactivo': 'bg-red-100 text-red-800',
                    'Vacaciones': 'bg-blue-100 text-blue-800',
                    'Licencia': 'bg-yellow-100 text-yellow-800'
                };
                return `<span class="px-2 py-1 rounded-full text-xs ${colors[estado] || 'bg-gray-100 text-gray-800'}">${estado}</span>`;
            }
        },
        {
            headerName: 'Acciones',
            width: 150,
            cellRenderer: function(params) {
                return `
                    <div class="flex space-x-2">
                        <a href="/empleados/${params.data.id}" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/empleados/${params.data.id}/edit" class="text-yellow-600 hover:text-yellow-900">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="deleteEmpleado(${params.data.id})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ];

    const gridOptions = {
        columnDefs: columnDefs,
        rowData: empleadosData,
        pagination: true,
        paginationPageSize: 20,
        defaultColDef: {
            sortable: true,
            filter: true,
            resizable: true
        }
    };

    const gridDiv = document.querySelector('#empleadosGrid');
    agGrid.createGrid(gridDiv, gridOptions);
});

function deleteEmpleado(id) {
    if (confirm('¿Estás seguro de eliminar este empleado?')) {
        // Crear formulario para DELETE
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/empleados/${id}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush