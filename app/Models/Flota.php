<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flota extends Model
{
    use HasFactory;

    protected $table = 'db_emp_flota';

    protected $primaryKey = 'idflota';

    protected $fillable = [  
                            'idempresa', 
                            'idvehiculo',                            
                            'idpersona', 
                            'correlativo', 
                            'sustitucion',
                            'tipologia',
                            'flag'    
                        ];

    public $timestamps = true;
}
