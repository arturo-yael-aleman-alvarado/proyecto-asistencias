<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    protected $dates = ['hora_entrada', 'hora_salida'];

    public function marcar(Request $request)
    {
        $request->validate([
            'clave' => 'required|numeric|digits:4',
            'contrasena' => 'required|numeric|digits:6',
        ]);

        $empleado = Empleado::where('clave', $request->clave)
            ->where('contraseña', $request->contrasena)
            ->first();

        if (!$empleado) {
            return redirect()->back()->withErrors(['error' => 'Credenciales inválidas.']);
        }

        $fechaHoy = now()->toDateString();

        $asistencia = Asistencia::where('empleado_id', $empleado->id)
            ->where('fecha', $fechaHoy)
            ->first();

        if ($asistencia) {
            if ($asistencia->hora_salida) {
                return redirect()->back()->withErrors(['error' => 'Ya se registró asistencia completa para hoy.']);
            }

            $asistencia->update(['hora_salida' => now()]);
            return redirect()->back()->with('success', 'Hora de salida registrada.');
        }

        Asistencia::create([
            'empleado_id' => $empleado->id,
            'hora_entrada' => now(),
            'fecha' => $fechaHoy,
        ]);

        return redirect()->back()->with('info', 'Hora de entrada registrada.');
    }

    public function index()
    {
        $asistencias = Asistencia::with('empleado')->get();
        return view('asistencias.index', compact('asistencias'));
    }

}
