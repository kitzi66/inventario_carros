<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventarioRequest;
use App\Inventario\Motocicleta;
use App\Inventario\Sedan;
use App\Models\Inventarios;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request  $request){
        try {
            $status = 200;
            $json['status'] = 'ok';
            $json['data']['inventarios'] = Inventarios::all();
        }catch (\Exception $error){
            $status = 400;
            $json = ['status' => 'error', 'message' => $error->getMessage()];
        }
        return response()->json($json, $status);
    }

    public function store(StoreInventarioRequest $request){
        $json = ['status' => 'ok', 'message' => 'Registro guardado correctamente'];
        $status = 200;
        if($request->numero_llantas <= 4 && $request->potencia_motor < 1000){
            $vehiculo = new Motocicleta($request->toArray());
        }else{
            $vehiculo = new Sedan($request->toArray());
        }

        try {
            Inventarios::guardar($vehiculo);
        }catch (\Exception $error){
            $status = 400;
            $json = ['status' => 'error', 'message' => $error->getMessage()];
        }
        return response()->json($json, $status);
    }
}
