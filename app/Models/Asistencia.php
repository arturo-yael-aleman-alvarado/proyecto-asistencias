<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = ['empleado_id', 'hora_entrada', 'hora_salida', 'fecha'];

    protected $casts = [
        'hora_entrada' => 'datetime',
        'hora_salida' => 'datetime',
        'fecha' => 'date',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
