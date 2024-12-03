<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencias</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-white text-lg font-bold">Sistema de Asistencias</h1>
            <div class="flex items-center">
                <!-- Menu -->
                <a href="{{ route('asistencias.index') }}" class="text-white mr-4 hover:underline">Asistencias</a>
                <a href="{{ route('empleados.index') }}" class="text-white mr-4 hover:underline">Empleados</a>
                
                <!-- Cerrar sesión -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-white hover:underline">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-10">
        <div class="max-w-3xl mx-auto bg-white p-8 border border-gray-300 rounded shadow">
            <h2 class="text-2xl font-bold mb-4 text-center">Asistencias Registradas</h2>

            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Empleado</th>
                        <th class="py-2 px-4 border-b">Fecha</th>
                        <th class="py-2 px-4 border-b">Hora de Entrada</th>
                        <th class="py-2 px-4 border-b">Hora de Salida</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asistencias as $asistencia)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $asistencia->empleado->nombre }}</td>
                            <td class="py-2 px-4 border-b">{{ $asistencia->fecha->format('d/m/Y') }}</td>
                            <td class="py-2 px-4 border-b {{$asistencia->hora_entrada->format('H:i') > strtotime('5:59') ? 'text-rose-500' : 'text-lime-500'}}">{{ $asistencia->hora_entrada ? $asistencia->hora_entrada->format('H:i') : 'No registrada'}}</td>
                            <td class="py-2 px-4 border-b">{{ $asistencia->hora_salida ? $asistencia->hora_salida->format('H:i') : 'No registrada' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</body>
</html>
