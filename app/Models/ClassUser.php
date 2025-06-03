<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassUser extends Model
{
    use HasFactory;

    protected $table = 'class_user';

    protected $fillable = [
        'usuario_id',
        'clase_id'
    ];

    // Aqui definimos las relaciones...
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class, 'clase_id');
    }
}
