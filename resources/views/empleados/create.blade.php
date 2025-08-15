<div id="employeeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center h-full w-full hidden z-50 p-4">
    <div class="relative bg-white rounded-lg shadow-lg w-[90%] h-[90%] max-w-none max-h-none overflow-hidden">
        <!-- Header fijo -->
        <div class="flex justify-between items-center p-6 border-b bg-cyan-900 sticky top-0 z-10">
            <h3 class="text-2xl font-bold text-cyan-50">Nuevo Empleado</h3>
            <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Contenido scrollable -->
        <div class="overflow-y-auto h-full pb-20">
            <div class="p-6">
                <form id="employeeForm" action="{{ route('empleados.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Información Personal -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Información Personal</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Código de Empleado*</label>
                                <input type="text" name="codigo_empleado" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" placeholder="EMP001" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cédula*</label>
                                <input type="text" name="cedula" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" placeholder="01234567890" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre*</label>
                                <input type="text" name="nombre" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Juan" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos*</label>
                                <input type="text" name="apellidos" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Pérez García" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                                <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" placeholder="empleado@empresa.com" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                <input type="tel" name="telefono" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" placeholder="000 000 0000">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento*</label>
                                <input type="date" name="fecha_nacimiento" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                            </div>
                            
                            <x-simple-select 
                                name="genero"
                                label="Género"
                                :required="true"
                                placeholder="Seleccionar género"
                                :options="[
                                    ['value' => 'M', 'text' => 'Masculino'],
                                    ['value' => 'F', 'text' => 'Femenino'],
                                    ['value' => 'Otro', 'text' => 'Otro']
                                ]"
                            />
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                            <textarea name="direccion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Calle 123 #45-67, Ciudad"></textarea>
                        </div>
                    </div>
                    
                    <!-- Información Laboral -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Información Laboral</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Ingreso*</label>
                                <input type="date" name="fecha_ingreso" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                            </div>
                            
                            <x-select 
                                name="departamento_id"
                                id="departamento_select_create"
                                label="Departamento"
                                :required="true"
                                option-text="nombre"
                                :options="$departamentos ?? []"
                            />

                            <x-select 
                                name="cargo_id"
                                id="cargo_select_create"
                                label="Cargo"
                                :required="true"
                                option-text="nombre"
                                :options="$cargos ?? []"
                                filter-by="departamento_id"
                            />
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Salario*</label>
                                <input type="number" name="salario" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" placeholder="1000000.00" required>
                            </div>
                            
                            <x-simple-select 
                                name="estado"
                                label="Estado"
                                :required="true"
                                placeholder="Seleccionar estado"
                                :options="[
                                    ['value' => 'Activo', 'text' => 'Activo'],
                                    ['value' => 'Inactivo', 'text' => 'Inactivo'],
                                    ['value' => 'Vacaciones', 'text' => 'Vacaciones'],
                                    ['value' => 'Licencia', 'text' => 'Licencia']
                                ]"
                            />
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                                <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Footer fijo -->
        <div class="absolute bottom-0 left-0 right-0 bg-white border-t p-3">
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeCreateModal()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 text-sm">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </button>
                <button type="submit" form="employeeForm" class="bg-cyan-900 text-white px-6 py-2 rounded-lg hover:bg-blue-700 text-sm">
                    <i class="fas fa-save mr-2"></i>Guardar Empleado
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Funciones para el modal de creación
function openCreateModal() {
    document.getElementById('employeeForm').reset();
    document.getElementById('employeeModal').classList.remove('hidden');
    // Establecer fecha de ingreso como hoy
    document.querySelector('input[name="fecha_ingreso"]').value = new Date().toISOString().split('T')[0];
    
    // Resetear componentes Alpine.js
    Alpine.nextTick(() => {
        // Trigger re-initialization of Alpine components
        document.querySelectorAll('[x-data]').forEach(el => {
            if (el._x_dataStack) {
                el._x_dataStack.forEach(data => {
                    if (data.selectedValue !== undefined) {
                        data.selectedValue = '';
                        data.selectedText = data.selectedText.includes('Seleccionar') ? data.selectedText : 'Seleccionar...';
                    }
                });
            }
        });
    });
}

function closeCreateModal() {
    document.getElementById('employeeModal').classList.add('hidden');
}

// Cerrar modal al hacer clic fuera de él
document.addEventListener('click', function(e) {
    const modal = document.getElementById('employeeModal');
    if (e.target === modal) {
        closeCreateModal();
    }
});

// Cerrar modal con tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateModal();
    }
});

// Debug: Verificar que los datos se envían correctamente
document.getElementById('employeeForm').addEventListener('submit', function(e) {
    const formData = new FormData(this);
    console.log('Datos del formulario:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
});
</script>