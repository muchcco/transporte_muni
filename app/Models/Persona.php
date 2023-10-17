<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'db_persona';

    protected $primaryKey = 'idpersona';

    protected $fillable = [  
                            'dni', 
                            'nombre',
                            'apellido_pat', 
                            'apellido_mat', 
                            'sexo',
                            'direccion',
                            'ref_direccion',
                            'tipo_documento',
                            'correo',
                            'celular',
                            'flag'    
                        ];

    public $timestamps = true;
}
