<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-4 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Navbar -->
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-white text-lg font-bold">Sistema de Asistencias</h1>
            <div class="flex items-center">
                <a href="{{ route('asistencias.index') }}" class="text-white mr-4 hover:underline">Asistencias</a>
                <a href="{{ route('empleados.index') }}" class="text-white mr-4 hover:underline">Empleados</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-white hover:underline">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-10">
        <div class="max-w-3xl mx-auto bg-white p-8 border border-gray-300 rounded shadow">
            <h2 class="text-2xl font-bold mb-4 text-center">Gestión de Empleados</h2>

            <!-- New Employee Form -->
            <div class="mb-6">
                <form action="{{ route('empleados.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="nombre" class="block text-gray-700">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div class="mb-4">
                            <label for="clave" class="block text-gray-700">Clave (4 dígitos):</label>
                            <input type="text" name="clave" id="clave" maxlength="4" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div class="mb-4">
                            <label for="contraseña" class="block text-gray-700">Contraseña (6 dígitos):</label>
                            <input type="password" name="contraseña" id="contraseña" maxlength="6" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div class="mb-4">
                            <label for="puesto" class="block text-gray-700">Puesto:</label>
                            <input type="text" name="puesto" id="puesto" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div class="mb-4">
                            <label for="edad" class="block text-gray-700">Edad:</label>
                            <input type="number" name="edad" id="edad" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">Crear Empleado</button>
                </form>
            </div>

            <!-- Employee List -->
            <h3 class="text-xl font-semibold mb-4">Lista de Empleados</h3>
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Clave</th>
                        <th class="py-2 px-4 border-b">Nombre</th>
                        <th class="py-2 px-4 border-b">Puesto</th>
                        <th class="py-2 px-4 border-b">Edad</th>
                        <th class="py-2 px-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $empleado)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $empleado->clave }}</td>
                            <td class="py-2 px-4 border-b">{{ $empleado->nombre }}</td>
                            <td class="py-2 px-4 border-b">{{ $empleado->puesto }}</td>
                            <td class="py-2 px-4 border-b">{{ $empleado->edad }}</td>
                            <td class="py-2 px-4 border-b">
                                <button onclick="openEditModal({{ $empleado }})" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Editar</button>
                                <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600" 
                                            onclick="return confirm('¿Estás seguro de eliminar este empleado?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Editar Empleado -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
            <h2 class="text-lg font-bold mb-4">Editar Empleado</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editId">

                <div class="mb-4">
                    <label for="editNombre" class="block text-gray-700">Nombre:</label>
                    <input type="text" id="editNombre" name="nombre" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="editClave" class="block text-gray-700">Clave:</label>
                    <input type="text" id="editClave" name="clave" class="w-full p-2 border rounded" maxlength="4" required>
                </div>
                <div class="mb-4">
                    <label for="editPuesto" class="block text-gray-700">Puesto:</label>
                    <input type="text" id="editPuesto" name="puesto" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="editEdad" class="block text-gray-700">Edad:</label>
                    <input type="number" id="editEdad" name="edad" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="editContraseña" class="block text-gray-700">Nueva Contraseña (opcional):</label>
                    <input type="password" id="editContraseña" name="contraseña" class="w-full p-2 border rounded" maxlength="6">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Guardar Cambios</button>
            </form>
            <button onclick="closeEditModal()" class="mt-4 w-full bg-gray-500 text-white py-2 rounded hover:bg-gray-600">Cerrar</button>
        </div>
    </div>

    <script>
        function openEditModal(empleado) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editForm').action = `/empleados/${empleado.id}`;
            document.getElementById('editNombre').value = empleado.nombre;
            document.getElementById('editClave').value = empleado.clave;
            document.getElementById('editPuesto').value = empleado.puesto;
            document.getElementById('editEdad').value = empleado.edad;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>


</body>
</html>
