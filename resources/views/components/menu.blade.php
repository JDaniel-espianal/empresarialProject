<nav class="bg-gray-800 text-white">
    <div class="container mx-auto px-4">
        <div class="flex space-x-8">
            <a href="{{ route('home') }}" 
               class="py-4 px-2 border-b-2 {{ request()->routeIs('home') ? 'border-blue-500' : 'border-transparent' }} 
                      hover:border-blue-500 transition duration-300">
                <i class="fas fa-home mr-1"></i> Dashboard
            </a>
            
            <!-- Módulo Empleados -->
            <a href="{{ route('empleados.index') }}" 
               class="py-4 px-2 border-b-2 {{ request()->routeIs('empleados*') ? 'border-blue-500' : 'border-transparent' }} 
                      hover:border-blue-500 transition duration-300">
                <i class="fas fa-users mr-1"></i> Empleados
            </a>
            
            <!-- Módulo Departamentos -->
            <a href="{{ route('departamentos.index') }}" 
               class="py-4 px-2 border-b-2 {{ request()->routeIs('departamentos*') ? 'border-blue-500' : 'border-transparent' }} 
                      hover:border-blue-500 transition duration-300">
                <i class="fas fa-building mr-1"></i> Departamentos
            </a>
            
            <!-- Módulo Asistencia -->
            <a href="{{ route('asistencia.index') }}" 
               class="py-4 px-2 border-b-2 {{ request()->routeIs('asistencia*') ? 'border-blue-500' : 'border-transparent' }} 
                      hover:border-blue-500 transition duration-300">
                <i class="fas fa-clock mr-1"></i> Asistencia
            </a>
            
            <!-- Módulo Vacaciones -->
            <a href="{{ route('vacaciones.index') }}" 
               class="py-4 px-2 border-b-2 {{ request()->routeIs('vacaciones*') ? 'border-blue-500' : 'border-transparent' }} 
                      hover:border-blue-500 transition duration-300">
                <i class="fas fa-calendar mr-1"></i> Vacaciones
            </a>
            
            {{-- <!-- Configuración -->
            <div class="relative group">
                <a href="#" class="py-4 px-2 border-b-2 border-transparent hover:border-blue-500 transition duration-300 flex items-center">
                    <i class="fas fa-cog mr-1"></i> Config
                    <i class="fas fa-chevron-down ml-1 text-xs"></i>
                </a>
                <div class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Mi Perfil</a>
                    <a href="{{ route('usuarios.index') }}" class="block px-4 py-2 hover:bg-gray-100">Usuarios</a>
                    <hr>
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                            Cerrar Sesión
                         </button>
                    </form>
                </div>
            </div>             --}}
                
            
        </div>
    </div>
</nav>