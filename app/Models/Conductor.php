<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    use HasFactory;

    protected $table = 'db_conductor';

    protected $primaryKey = 'idconductor';

    protected $fillable = [  
                            'idpersona', 
                            'idcategoria_licencia',                            
                            'n_brevete', 
                            'fecha_expedicion_brevete', 
                            'fecha_vencimiento_brevete', 
                            'n_padron',
                            'mes',
                            'año',
                            'pago_padron',
                            'nota_conductor',
                            'flag'    
                        ];

    public $timestamps = true;
}
