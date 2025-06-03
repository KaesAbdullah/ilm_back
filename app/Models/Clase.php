<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'nombre',
        'profe_id',
        'tipo',
        'nivel',
        'numero_alumnos',
        'imagen_horario',
    ];

    /**
     * La clase le pertenece al profesor, si se puede decir asi.
     * @return BelongsTo
     */
    public function profesor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'profe_id');
    }

    /**
     * Una clase, tiene muchos alumnos.
     * @return BelongsToMany
     */
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'class_user', 'clase_id', 'usuario_id');
    }
    public function attendance(): HasMany
    {
        return $this->hasMany(Asistencia::class, 'clase_id');
    }
}
