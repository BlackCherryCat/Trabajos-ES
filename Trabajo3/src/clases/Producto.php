<?php

class Producto {

    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;

    public function __construct ($nombre, $descripcion, $precio, $stock) {
        $this->$nombre = $nombre;
        $this->$descripcion = $descripcion;
        $this->$precio = $precio;
        $this->$stock = $stock;
    }

    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new Exception("La propiedad " . $name . " no existe.");
    }

    public function __set($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
            return;
        }
        throw new Exception("La propiedad " . $name . " no existe.");
    }


    public function _toString() {
        return "Nombre: " . $this->nombre . ", Descripcion: " . $this->descripcion . ", Precio: " . 
            $this->precio . ", Stock" . $this->stock . "."; 
    }
}

?>