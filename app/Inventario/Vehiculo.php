<?php

namespace App\Inventario;

abstract class Vehiculo
{
    private $id;
    private $marca;
    private $descripcion;
    private $numero_llantas;
    private $potencia_motor;

    /**
     * @param $datos
     */
    public function __construct(Array $datos)
    {
        foreach ($datos as $propiedad => $valor){
            if(property_exists($this, $propiedad)){
                $this->{$propiedad} = $valor;
            }
        }
    }


    abstract public function hasVolante();

    public function toArray()
    {
        return ['id' => $this->id, 'marca' => $this->marca, 'descripcion' => $this->descripcion,
            'numero_llantas' => $this->numero_llantas, 'potencia_motor' => $this->potencia_motor];
    }

    public function getClasificacion()
    {
        if ($this->numero_llantas <= 4 && $this->potencia_motor < 1000) {
            return 'Moto';
        }
        return 'Sedan';
    }

    public function __get($name)
    {
        return $this->{$name} ?? null;
    }

    public function __set($name, $value)
    {
        if(property_exists($this, $name)) {
            $this->{$name} = $value;
        }
    }


}

