<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;
    protected $table = 'reason';
    protected $fillable = [
        'asistencia_id',
        'motivo',
        'estado',
    ];

    public function asistencia(): BelongsTo
    {
        return $this->belongsTo(Asistencia::class, 'asistencia_id');
    }
}
