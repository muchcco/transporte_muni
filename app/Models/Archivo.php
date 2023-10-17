<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $table = 'db_vehiculo_archivo';

    protected $primaryKey = 'idvehiculo_archivo';

    protected $fillable = [  
                            'idtipo_dato', 
                            'idvehiculo',                            
                            'fecha_expedicion', 
                            'fecha_vencimiento', 
                            'nombre_archivo', 
                            'ruta'                          
                        ];

    public $timestamps = true;
}
