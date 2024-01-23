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
                            'foto_conductor',
                            'fecha_expedicion_brevete', 
                            'fecha_vencimiento_brevete', 
                            'n_padron',
                            'mes',
                            'monto_recibo',
                            'año',
                            'expediente_doc',
                            'fecha_registro',
                            'pago_padron',
                            'nota_conductor',
                            'n_recibo',
                            'fecha_recibo',
                            'flag'    
                        ];

    public $timestamps = true;
}
