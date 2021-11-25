<?php

namespace App\Models;

use App\Inventario\Vehiculo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarios extends Model
{
    use HasFactory;

    protected $table = 'inventarios';
    protected $fillable = ['id', 'descripcion', 'marca', 'numero_llantas', 'potencia_motor'];

    public static function guardar(Vehiculo $vehiculo){
//        print_r($vehiculo->toArray());
        $inventario = new Inventarios();
        $inventario->descripcion = $vehiculo->descripcion;
        $inventario->marca = $vehiculo->marca;
        $inventario->numero_llantas = $vehiculo->numero_llantas;
        $inventario->potencia_motor = $vehiculo->potencia_motor;
        $inventario->volante = $vehiculo->hasVolante();
        $inventario->clasificacion = $vehiculo->getClasificacion();
        $inventario->save();
    }

}
