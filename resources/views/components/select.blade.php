@props([
    'name',
    'id' => null,
    'label',
    'required' => false,
    'placeholder' => 'Seleccionar...',
    'options' => [],
    'optionValue' => 'id',
    'optionText' => 'name',
    'selected' => null,
    'class' => '',
    'filterBy' => null,
    'searchable' => true
])

@php
    $componentId = $id ?? 'select_' . uniqid();
@endphp

<div class="relative" x-data="{ 
    open: false, 
    selectedValue: '{{ $selected }}', 
    selectedText: '{{ $placeholder }}',
    searchQuery: '',
    filteredOptions: {{ json_encode($options) }},
    init() {
        this.filteredOptions = {{ json_encode($options) }};
        if (this.selectedValue) {
            const selected = this.filteredOptions.find(option => 
                (typeof option === 'object' ? option.{{ $optionValue }} : option['{{ $optionValue }}']) == this.selectedValue
            );
            if (selected) {
                this.selectedText = typeof selected === 'object' ? selected.{{ $optionText }} : selected['{{ $optionText }}'];
            }
        }
    },
    filterOptions() {
        if (!this.searchQuery) {
            this.filteredOptions = {{ json_encode($options) }};
            return;
        }
        
        this.filteredOptions = {{ json_encode($options) }}.filter(option => {
            const text = typeof option === 'object' ? option.{{ $optionText }} : option['{{ $optionText }}'];
            return text.toLowerCase().includes(this.searchQuery.toLowerCase());
        });
    },
    selectOption(value, text) {
        this.selectedValue = value;
        this.selectedText = text;
        this.searchQuery = '';
        this.open = false;
        this.filteredOptions = {{ json_encode($options) }};
    },
    openDropdown() {
        this.open = true;
        this.searchQuery = '';
        this.filteredOptions = {{ json_encode($options) }};
        this.$nextTick(() => {
            this.positionDropdown();
            if (this.$refs.searchInput) {
                this.$refs.searchInput.focus();
            }
            // Reposicionar si el usuario hace scroll
            window.addEventListener('scroll', () => {
                if (this.open) {
                    this.positionDropdown();
                }
            }, { passive: true });
        });
    },
    positionDropdown() {
        const button = this.$refs.button;
        const dropdown = this.$refs.dropdown;
        const rect = button.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const windowWidth = window.innerWidth;
        const dropdownHeight = 288;
        
        // Calcular espacios disponibles
        const spaceBelow = windowHeight - rect.bottom;
        const spaceAbove = rect.top;
        const spaceRight = windowWidth - rect.left;
        
        // Determinar posicionamiento vertical
        const shouldOpenUpward = spaceBelow < dropdownHeight && spaceAbove > spaceBelow;
        
        // Ajustar ancho si no hay espacio suficiente a la derecha
        const dropdownWidth = Math.min(rect.width, spaceRight - 16);
        
        dropdown.style.width = dropdownWidth + 'px';
        dropdown.style.left = Math.max(16, rect.left) + 'px';
        
        if (shouldOpenUpward) {
            dropdown.style.top = 'auto';
            dropdown.style.bottom = (windowHeight - rect.top + 4) + 'px';
            dropdown.classList.add('origin-bottom');
            dropdown.classList.remove('origin-top');
            
            // Ajustar altura máxima si es necesario
            const maxHeight = Math.min(dropdownHeight, spaceAbove - 16);
            dropdown.style.maxHeight = maxHeight + 'px';
        } else {
            dropdown.style.top = (rect.bottom + 4) + 'px';
            dropdown.style.bottom = 'auto';
            dropdown.classList.add('origin-top');
            dropdown.classList.remove('origin-bottom');
            
            // Ajustar altura máxima si es necesario
            const maxHeight = Math.min(dropdownHeight, spaceBelow - 16);
            dropdown.style.maxHeight = maxHeight + 'px';
        }
    }
}">
    <label class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    <!-- Input hidden para el formulario -->
    <input type="hidden" 
           name="{{ $name }}" 
           @if($id) id="{{ $id }}" @endif
           :value="selectedValue"
           {{ $required ? 'required' : '' }}
    />
    
    <!-- Botón del dropdown -->
    <button type="button" 
        x-ref="button"
        @click="openDropdown()"
        @click.away="open = false"
        class="w-full px-4 py-3 pr-10 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-sm transition-all duration-200 hover:border-gray-400 text-left {{ $class }}"
        :class="{ 'ring-2 ring-cyan-500 border-cyan-500': open }"
    >
        <span x-text="selectedText" class="block truncate"></span>
        <span class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
            <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-200" 
            :class="{ 'rotate-180': open }"></i>
        </span>
    </button>
    
    <!-- Dropdown menu -->
    <div x-show="open" 
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="fixed z-[9999] mt-1 bg-white rounded-lg shadow-lg border border-gray-200 max-h-72 overflow-hidden origin-top"
        style="display: none;"
        x-ref="dropdown"
    >
        @if($searchable)
        <!-- Buscador -->
        <div class="p-3 border-b border-gray-200">
            <div class="relative">
                <input 
                    type="text" 
                    x-ref="searchInput"
                    x-model="searchQuery"
                    @input="filterOptions()"
                    placeholder="Buscar..."
                    class="w-full px-3 py-2 pl-9 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-sm"
                    @click.stop
                >
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400 text-sm"></i>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Lista de opciones -->
        <div class="max-h-60 overflow-y-auto">
            <ul class="py-1">
                <template x-for="option in filteredOptions" :key="typeof option === 'object' ? option.{{ $optionValue }} : option['{{ $optionValue }}']">
                    <li>
                        <button type="button"
                                @click="selectOption(
                                    typeof option === 'object' ? option.{{ $optionValue }} : option['{{ $optionValue }}'],
                                    typeof option === 'object' ? option.{{ $optionText }} : option['{{ $optionText }}']
                                )"
                                class="w-full px-4 py-3 text-left text-sm text-gray-700 hover:bg-cyan-50 hover:text-cyan-900 focus:bg-cyan-50 focus:text-cyan-900 focus:outline-none transition-colors duration-150"
                                :class="{ 'bg-cyan-100 text-cyan-900': selectedValue === (typeof option === 'object' ? option.{{ $optionValue }} : option['{{ $optionValue }}']) }"
                                @if($filterBy)
                                    :data-{{ $filterBy }}="typeof option === 'object' ? option.{{ $filterBy }} : option['{{ $filterBy }}']"
                                @endif
                        >
                            <span x-text="typeof option === 'object' ? option.{{ $optionText }} : option['{{ $optionText }}']"></span>
                        </button>
                    </li>
                </template>
                
                <!-- Mensaje cuando no hay resultados -->
                <li x-show="filteredOptions.length === 0" class="px-4 py-3 text-sm text-gray-500 text-center">
                    No se encontraron resultados
                </li>
            </ul>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endpush
@endonce