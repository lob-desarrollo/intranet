<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'nombres', 'apellidos', 'genero', 'nacimiento', 'ingreso', 'puesto', 'departamento', 'movil', 'telefono', 'extension', 'avatar', 'fondo'];
}