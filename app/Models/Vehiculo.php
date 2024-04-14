<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'db_vehiculo';

    protected $primaryKey = 'idvehiculo';

    protected $fillable = [  
                            'idpersona', 
                            'idmodelo',
                            'n_placa', 
                            'cat_clase', 
                            'combustible',
                            'serie',
                            'año_fabricacion',
                            'n_asientos',
                            'motor',
                            'color',
                            'carroceria',
                            'mes',
                            'tipologia',
                            'año',
                            'n_recibo',
                            'monto_recibo',
                            'fecha_recibo',
                            'n_padron',
                            'pago_padron',
                            'flag',
                            'expediente_doc',
                            'fecha_expediente'
                        ];

    public $timestamps = true;
}
