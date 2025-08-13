<footer class="bg-gray-800 text-white mt-8">
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Información de la empresa -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Sistema RRHH</h3>
                <p class="text-gray-300 mb-4">
                    Gestión integral de recursos humanos para tu empresa.
                </p>
            </div>
            
            <!-- Enlaces rápidos -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Enlaces Rápidos</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white">Dashboard</a></li>
                    <li><a href="{{ route('empleados.index') }}" class="text-gray-300 hover:text-white">Empleados</a></li>
                    <li><a href="{{ route('departamentos.index') }}" class="text-gray-300 hover:text-white">Departamentos</a></li>
                </ul>
            </div>
            
            <!-- Contacto -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Contacto</h3>
                <div class="space-y-2 text-gray-300">
                    <p><i class="fas fa-phone mr-2"></i>+999 999 9999</p>
                    <p><i class="fas fa-envelope mr-2"></i>info@empresa.com</p>
                </div>
            </div>
            
            <!-- Soporte -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Soporte</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white">Ayuda</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white">Documentación</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-gray-700 mt-8 pt-4 text-center text-gray-300">
            <p>&copy; {{ date('Y') }} Sistema RRHH. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>