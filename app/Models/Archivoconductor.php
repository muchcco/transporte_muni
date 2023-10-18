<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivoconductor extends Model
{
    use HasFactory;

    protected $table = 'db_conductor_archivo';

    protected $primaryKey = 'idconductor_archivo';

    protected $fillable = [  
                            'idtipo_dato', 
                            'idconductor',                            
                            'fecha_expedicion', 
                            'fecha_vencimiento', 
                            'nombre_archivo', 
                            'ruta'                          
                        ];

    public $timestamps = true;
}
