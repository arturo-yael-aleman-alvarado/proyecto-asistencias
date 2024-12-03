<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados'));
    }

    // Método para mostrar el formulario de creación de empleado
    public function create()
    {
        return view('empleados.create');
    }

    // Método para almacenar un nuevo empleado
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'clave' => 'required|digits:4|unique:empleados',
            'contraseña' => 'required|digits:6',  // Aquí no se encripta aún
            'nombre' => 'required|string|max:255',
            'puesto' => 'required|string|max:255',
            'edad' => 'required|integer|min:18',
        ]);

        try {

            // Crear el nuevo empleado
            $empleado = new Empleado($validated);
            $empleado->save();

            // Redirigir a la vista de empleados con un mensaje de éxito
            return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
        } catch (\Exception $e) {
            // Si hay un error, redirigir con un mensaje de error
            return redirect()->route('empleados.index')->with('error', 'Ocurrió un error al crear el empleado: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Empleado $empleado)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'required|digits:4|unique:empleados,clave,' . $empleado->id,
            'puesto' => 'required|string|max:255',
            'edad' => 'required|integer|min:18',
            'contraseña' => 'nullable|digits:6', // La contraseña es opcional durante la edición
        ]);

        try {
            // Actualizar los datos del empleado
            $empleado->update([
                'nombre' => $validated['nombre'],
                'clave' => $validated['clave'],
                'puesto' => $validated['puesto'],
                'edad' => $validated['edad'],
                'contraseña' => $validated['contraseña'] ? Hash::make($validated['contraseña']) : $empleado->contraseña,
            ]);

            return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('empleados.index')->with('error', 'Ocurrió un error al actualizar el empleado: ' . $e->getMessage());
        }
    }

    public function destroy(Empleado $empleado)
    {
        try {
            $empleado->delete();
            return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('empleados.index')->with('error', 'Ocurrió un error al eliminar el empleado: ' . $e->getMessage());
        }
    }
}
