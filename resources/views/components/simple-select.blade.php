@props([
    'name',
    'id' => null,
    'label',
    'required' => false,
    'placeholder' => 'Seleccionar...',
    'options' => [],
    'selected' => null,
    'class' => ''
])

@php
    $componentId = $id ?? 'simple_select_' . uniqid();
@endphp

<div class="relative" x-data="{ 
    open: false, 
    selectedValue: '{{ $selected }}', 
    selectedText: '{{ $placeholder }}',
    init() {
        if (this.selectedValue) {
            const selected = {{ json_encode($options) }}.find(option => option.value === this.selectedValue);
            if (selected) {
                this.selectedText = selected.text;
            }
        }
    },
    selectOption(value, text) {
        this.selectedValue = value;
        this.selectedText = text;
        this.open = false;
    },
    openDropdown() {
        this.open = true;
        this.$nextTick(() => {
            this.positionDropdown();
        });
    },
    positionDropdown() {
        const button = this.$refs.button;
        const dropdown = this.$refs.dropdown;
        const rect = button.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const dropdownHeight = 192; // max-h-48 = ~192px
        
        // Calcular espacio disponible arriba y abajo
        const spaceBelow = windowHeight - rect.bottom;
        const spaceAbove = rect.top;
        
        // Determinar si debe abrirse hacia arriba
        const shouldOpenUpward = spaceBelow < dropdownHeight && spaceAbove > spaceBelow;
        
        dropdown.style.width = rect.width + 'px';
        dropdown.style.left = rect.left + 'px';
        
        if (shouldOpenUpward) {
            // Posicionar hacia arriba
            dropdown.style.top = 'auto';
            dropdown.style.bottom = (windowHeight - rect.top + 4) + 'px';
            dropdown.classList.add('origin-bottom');
            dropdown.classList.remove('origin-top');
        } else {
            // Posicionar hacia abajo (normal)
            dropdown.style.top = (rect.bottom + 4) + 'px';
            dropdown.style.bottom = 'auto';
            dropdown.classList.add('origin-top');
            dropdown.classList.remove('origin-bottom');
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
    
    <!-- Dropdown menu simple -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="fixed z-[9999] mt-1 bg-white rounded-lg shadow-lg border border-gray-200 max-h-48 overflow-y-auto origin-top"
         style="display: none;"
         x-ref="dropdown"
    >
        <ul class="py-1">
            @foreach($options as $option)
                <li>
                    <button type="button"
                            @click="selectOption('{{ $option['value'] }}', '{{ $option['text'] }}')"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-cyan-50 hover:text-cyan-900 focus:bg-cyan-50 focus:text-cyan-900 focus:outline-none transition-colors duration-150"
                            :class="{ 'bg-cyan-100 text-cyan-900': selectedValue === '{{ $option['value'] }}' }"
                    >
                        {{ $option['text'] }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>

@once
    @push('scripts')
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endpush
@endonce