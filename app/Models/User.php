<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dni',
        'nombre',
        'apellido1',
        'apellido2',
        'fecha_nacimiento',
        'genero',
        'numero_telefono',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
    * Los alumnos pueden tener 1 o mas clases.
    */
    public function clases_alumno(): BelongsToMany
    {
        return $this->belongsToMany(Clase::class, 'class_user', 'usuario_id', 'clase_id');
    }

    /*
    * El profe tiene una clase.
    */
    public function clase_profe(): HasOne
    {
        return $this->hasOne(Clase::class, 'profe_id');
    }

    /*
    * Los alumnos pueden muchas asistencias
    */
    public function attendances(): HasMany
    {
        return $this->hasMany(Asistencia::class, 'alumno_id',);
    }
}
