<?php

abstract class Usuario {
    // propiedades protegidas para que puedan ser heredadas
    protected $idUsuario;
    protected $email;
    protected $pass;
    protected $nombre;

    // Constructor
    public function __construct($idUsuario, $email, $pass, $nombre) {
        $this->idUsuario = $idUsuario;
        $this->email = $email;
        $this->pass = $pass;
        $this->nombre = $nombre;
    }

    /*
    La función property_exists() verifica si una propiedad dada existe en la clase o en una de sus clases padres.
    Esto es útil para determinar si una propiedad es válida antes de intentar acceder a ella o asignarle un valor.
    En este caso, se utiliza para evitar errores al acceder o modificar propiedades inexistentes.
    */


    // Método mágico __get
    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new Exception("Propiedad " . $name . " no existe.");
    }

    // Método mágico __set
    public function __set($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new Exception("Propiedad " . $name . " no existe o no es accesible.");
        }
    }
    //Metodo abstracto 
    abstract public function registerBD();
    
}

?>