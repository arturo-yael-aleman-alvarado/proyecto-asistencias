<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Asistencias</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-white text-lg font-bold">Sistema de Asistencias</h1>
            <div>
                <a href="{{ route('login') }}" class="text-white mr-4 hover:underline">Iniciar Sesión</a>
                <!--<a href="{{ route('register') }}" class="text-white hover:underline">Registrarse</a>-->
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-10">
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-500 text-white p-4 rounded mb-4">
                {{ session('info') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="max-w-md mx-auto bg-white p-8 border border-gray-300 rounded shadow">
            <h2 class="text-2xl font-bold mb-4 text-center">Marcar Asistencia</h2>
            <form action="{{ route('asistencia.marcar') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="clave" class="block text-gray-700">Clave de Empleado:</label>
                    <input type="text" name="clave" id="clave" maxlength="4" required
                        class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div class="mb-4">
                    <label for="contrasena" class="block text-gray-700">Contraseña:</label>
                    <input type="password" name="contrasena" id="contrasena" maxlength="6" required
                        class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
                    Marcar Asistencia
                </button>
            </form>
        </div>
    </div>

</body>
</html>
