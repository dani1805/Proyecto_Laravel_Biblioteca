<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{

    protected $fillable = [
        'titulo', 'descripcion'
    ];

    public function usuarios() {

        return $this->belongsToMany(Usuario::class, 'usuarios_libros')->withTimestamps();
    }
    
}
