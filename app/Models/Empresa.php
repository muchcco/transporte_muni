<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'db_empresa';

    protected $primaryKey = 'idempresa';

    protected $fillable = [  
                            'idsubtipo', 
                            'ruc',                            
                            'razon_social', 
                            'resolucion', 
                            'fecha_registro', 
                            'fecha_inicio',
                            'fecha_fin',
                            'ruta',
                            'n_flota',
                            'foto',
                            'origen',
                            'destino',
                            'flag'    
                        ];

    public $timestamps = true;
}
