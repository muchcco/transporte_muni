<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Empresa\EmpresaController;
use App\Http\Controllers\Registro\ConductorController;
use App\Http\Controllers\RecursosController;
use App\Http\Controllers\Empresa\FlotaController;
use App\Http\Controllers\ExternoController;
use App\Http\Controllers\Registro\VehiculoController;
use App\Http\Controllers\Asset\UsuarioController;

Route::get('externo', [ExternoController::class, 'externo'])->name('externo');

Route::get('vehiculo', [ExternoController::class, 'vehiculo'])->name('vehiculo');
Route::post('search_vehiculo', [ExternoController::class, 'search_vehiculo'])->name('search_vehiculo');
Route::get('view_vehiculo/{id}', [ExternoController::class, 'view_vehiculo'])->name('view_vehiculo');

Route::get('conductor', [ExternoController::class, 'conductor'])->name('conductor');
Route::post('search_conductor', [ExternoController::class, 'search_conductor'])->name('search_conductor');
Route::get('view_conductor/{id}', [ExternoController::class, 'view_conductor'])->name('view_conductor');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [PagesController::class, 'index'])->name('inicio');

    Route::group(['prefix'=>'empresa.html','as'=>'empresa.' ],function () {
        Route::get('/empresa' , [EmpresaController::class, 'empresa'])->name('empresa');
        Route::get('/tablas/tb_empresa' , [EmpresaController::class, 'tb_empresa'])->name('tablas.tb_empresa');
        Route::post('/modals/md_crea_empresa' , [EmpresaController::class, 'md_crea_empresa'])->name('modals.md_crea_empresa');
        Route::post('/modals/md_ver_empresa' , [EmpresaController::class, 'md_ver_empresa'])->name('modals.md_ver_empresa');
        Route::post('/modals/md_edit_empresa' , [EmpresaController::class, 'md_edit_empresa'])->name('modals.md_edit_empresa');
        Route::get('/subtipo_id/{tipoid}' , [EmpresaController::class, 'subtipo_id'])->name('subtipo_id');  // para el modal obtener el id subtipo 
        Route::post('/e_store' , [EmpresaController::class, 'e_store'])->name('e_store');        
        Route::post('/e_update' , [EmpresaController::class, 'e_update'])->name('e_update');
        Route::post('/e_delete' , [EmpresaController::class, 'e_delete'])->name('e_delete');
        Route::post('/foto_eliminar' , [EmpresaController::class, 'foto_eliminar'])->name('foto_eliminar'); // elimnar foto de perfil de la empresa

        /* INGRESAMOS AL DETALLE DE LAS FLOTAS POR CADA EMPRESA */
        Route::group(['prefix'=>'flota','as'=>'flota.' ],function () {

            Route::get('/index/{idempresa}' , [FlotaController::class, 'index'])->name('index');
            Route::get('/tablas/tb_index' , [FlotaController::class, 'tb_index'])->name('tablas.tb_index');
            Route::post('/modals/md_crea_flota' , [FlotaController::class, 'md_crea_flota'])->name('modals.md_crea_flota');
            Route::post('/store_flota' , [FlotaController::class, 'store_flota'])->name('store_flota');            
            Route::get('/flota_vista/{idflota}' , [FlotaController::class, 'flota_vista'])->name('flota_vista');
            Route::post('/modals/baja_flota' , [FlotaController::class, 'baja_flota'])->name('modals.baja_flota');
            Route::post('/store_baja' , [FlotaController::class, 'store_baja'])->name('store_baja');
            Route::post('/update_flota' , [FlotaController::class, 'update_flota'])->name('update_flota');

            Route::post('/add_vehiculo' , [FlotaController::class, 'add_vehiculo'])->name('add_vehiculo'); /// SE AÑADE EL ID DEL VEHICULO A LA TABLA BD_EMP_FLOTA
            
        });
    });

    Route::group(['prefix'=>'conductor.html','as'=>'conductor.' ],function () {
        Route::get('/index' , [ConductorController::class, 'index'])->name('index');
        Route::get('/reg_completo/{idconductor}' , [ConductorController::class, 'reg_completo'])->name('reg_completo');
        Route::get('/tablas/tb_index' , [ConductorController::class, 'tb_index'])->name('tablas.tb_index');
        Route::post('/modals/md_crea_conductor' , [ConductorController::class, 'md_crea_conductor'])->name('modals.md_crea_conductor');
        Route::post('/store_conductor' , [ConductorController::class, 'store_conductor'])->name('store_conductor');
        Route::post('/modals/md_edit_persona' , [ConductorController::class, 'md_edit_persona'])->name('modals.md_edit_persona');
        Route::post('/update_conductor' , [ConductorController::class, 'update_conductor'])->name('update_conductor'); // GUARDATOS DE LA PERSONA
        Route::post('/modals/md_edit_conductor' , [ConductorController::class, 'md_edit_conductor'])->name('modals.md_edit_conductor');
        Route::post('/update_conductor_princ' , [ConductorController::class, 'update_conductor_princ'])->name('update_conductor_princ'); // GUARAR DATOS DEL CONDUCTOR
        Route::post('/modals/md_vehiculo' , [ConductorController::class, 'md_vehiculo'])->name('modals.md_vehiculo');
        Route::post('/store_vehiculo' , [ConductorController::class, 'store_vehiculo'])->name('store_vehiculo'); // GUARAR DATOS DEL CONDUCTOR
        Route::post('/modals/md_vehiculo_edit' , [ConductorController::class, 'md_vehiculo_edit'])->name('modals.md_vehiculo_edit');
        Route::post('/update_vehiculo' , [ConductorController::class, 'update_vehiculo'])->name('update_vehiculo'); // GUARAR DATOS DEL CONDUCTOR
        Route::post('/store_tip_dato' , [ConductorController::class, 'store_tip_dato'])->name('store_tip_dato'); // GUARAR DATOS DEL CONDUCTOR
        Route::post('/delete_tip_dato' , [ConductorController::class, 'delete_tip_dato'])->name('delete_tip_dato'); // GUARAR DATOS DEL CONDUCTOR

        Route::get('/padron_conductor_pdf/{idconductor}' , [ConductorController::class, 'padron_conductor_pdf'])->name('padron_conductor_pdf'); // EXPORTA EN UN FORMATO PDF


        
    });

    Route::group(['prefix'=>'vehiculo.html','as'=>'vehiculo.' ],function () {
        Route::get('/index' , [VehiculoController::class, 'index'])->name('index');
        Route::get('/tablas/tb_index' , [VehiculoController::class, 'tb_index'])->name('tablas.tb_index');
        Route::post('/modals/md_crea_vehiculo' , [VehiculoController::class, 'md_crea_vehiculo'])->name('modals.md_crea_vehiculo');
        Route::post('/store_vehiculo' , [VehiculoController::class, 'store_vehiculo'])->name('store_vehiculo');
        Route::get('/reg_completo/{idvehiculo}' , [VehiculoController::class, 'reg_completo'])->name('reg_completo');
        Route::post('/modals/md_vehiculo_edit' , [VehiculoController::class, 'md_vehiculo_edit'])->name('modals.md_vehiculo_edit');
        Route::post('/update_vehiculo' , [VehiculoController::class, 'update_vehiculo'])->name('update_vehiculo'); // GUARAR DATOS DEL CONDUCTOR
        Route::post('/store_tip_dato' , [VehiculoController::class, 'store_tip_dato'])->name('store_tip_dato'); // GUARAR DATOS DEL CONDUCTOR
        Route::post('/delete_tip_dato' , [VehiculoController::class, 'delete_tip_dato'])->name('delete_tip_dato'); // GUARAR DATOS DEL CONDUCTOR

        Route::get('/padron_vehiculo_pdf/{idvehiculo}' , [VehiculoController::class, 'padron_vehiculo_pdf'])->name('padron_vehiculo_pdf'); // EXPORTA EN UN FORMATO PDF

    });

    Route::group(['prefix'=>'usuarios.html','as'=>'usuarios.' ],function () {
        Route::get('/index' , [UsuarioController::class, 'index'])->name('index');
        Route::get('/tablas/tb_index' , [UsuarioController::class, 'tb_index'])->name('tablas.tb_index');                
        Route::post('/modals/md_add_usuario' , [UsuarioController::class, 'md_add_usuario'])->name('modals.md_add_usuario');
        Route::post('/modals/md_edit_usuario' , [UsuarioController::class, 'md_edit_usuario'])->name('modals.md_edit_usuario');
        Route::post('/modals/md_editpass_usuario' , [UsuarioController::class, 'md_editpass_usuario'])->name('modals.md_editpass_usuario');
        Route::post('/store_usuario' , [UsuarioController::class, 'store_usuario'])->name('store_usuario');
        Route::post('/update_usuario' , [UsuarioController::class, 'update_usuario'])->name('update_usuario');
        Route::post('/update_password_usuario' , [UsuarioController::class, 'update_password_usuario'])->name('update_password_usuario');
        Route::post('/delete_usuario' , [UsuarioController::class, 'delete_usuario'])->name('delete_usuario');
    });


    /******************  RECURSOS  ********************/

    Route::post('/buscar_ruc' , [RecursosController::class, 'buscar_ruc'])->name('buscar_ruc');
    Route::post('/buscar_dni' , [RecursosController::class, 'buscar_dni'])->name('buscar_dni'); 
    Route::get('provincias/{departamento_id}', [RecursosController::class, 'provincias'])->name('provincias');
    Route::get('distritos/{provincia_id}', [RecursosController::class, 'distritos'])->name('distritos');
    Route::get('subtipo_vehiculo/{idsubtipo_vehiculo}', [RecursosController::class, 'subtipo_vehiculo'])->name('subtipo_vehiculo');
});