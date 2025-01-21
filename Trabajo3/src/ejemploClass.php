<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        class Coche {
            //Atributos, pueden ser publicos o privados o protected
            public $marca;
            private $modelo;
            protected $matricula;

            //Constructor de la clase, haciendo uso de this y ->
            function __construct($marca, $modelo, $matricula){
                $this -> marca = $marca;
                $this -> modelo = $modelo;
                $this -> matricula = $matricula;
            }

            //Los métodos se definen con function
            function verCoche(){
                echo "Marca: ".$this -> marca;
                echo "Modelo: ".$this -> modelo;
                echo "Matrícula: ".$this -> matricula;
            }
        }
        //Ejemplo instanciación Objeto
        //Con el constructor por defecto, sin parámetros
        $miCoche = new Coche();
        //Ejemplo de instanciación haciendo uso de un constructor
        //Al que se le pasan los attributos por parámetro
        $miCoche2 = new Coche("Seat", "Ibiza", "00000FFF");

        //LLamamos a la función verCoche() del Coche 2
        $miCoche2 -> verCoche();

    ?>
</body>
</html>