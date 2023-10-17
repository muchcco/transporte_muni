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
                            'año',
                            'n_padron',
                            'pago_padron',
                            'flag'    
                        ];

    public $timestamps = true;
}
