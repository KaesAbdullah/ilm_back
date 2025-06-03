<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    protected $table = 'attendance';
    protected $fillable = [
        'fecha',
        'clase_id',
        'alumno_id',
        'estado',
    ];

    public function clase(): BelongsTo
    {
        return $this->belongsTo(Clase::class, 'clase_id');
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(User::class, 'alumno_id');
    }

    public function justificacion(): HasOne
    {
        return $this->hasOne(Reason::class, 'asistencia_id');
    }
}
