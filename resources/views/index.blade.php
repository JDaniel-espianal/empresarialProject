@extends('layouts.app')

@section('title', 'Inicio - Mi Empresa')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center mb-8">Bienvenido a Mi Empresa</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Contenido de tu página principal -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Nuestros Productos</h2>
            <p class="text-gray-600">Descripción de tus productos principales.</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Nuestros Servicios</h2>
            <p class="text-gray-600">Descripción de tus servicios principales.</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Contacto</h2>
            <p class="text-gray-600">Información de contacto.</p>
        </div>
    </div>
</div>
@endsection