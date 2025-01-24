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

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function _toString() {
        return "Nombre: " . $this->nombre . ", Descripcion: " . $this->descripcion . ", Precio: " . 
            $this->precio . ", Stock" . $this->stock . "."; 
    }
}

?>