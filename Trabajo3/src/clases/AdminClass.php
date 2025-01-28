<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require 'BD.php';
        require_once 'Usuarios.php';
        //La clase admin hereda de Usuario e implementa la interfaz base de datos
        class Admin extends Usuario{

            public $credenciales;
            //Atributos de la clase admin
            function __construct($idUsuario, $email, $pass, $nombre, $credenciales){
                parent::__construct($idUsuario, $email, $pass, $nombre); 
                $this -> crendeciales = $credenciales;
            }

            public function __get($propiedad) {
                return isset($this->$propiedad) ? $this->$propiedad : null;
            }
        

            public function __set($propiedad, $valor) {
        if ($propiedad == "precio" && $valor <= 0) {
            echo "El precio debe ser mayor a 0.<br>";
        } else {
            $this->$propiedad = $valor;
        }
    }

            use BD;
        }

    ?>
</body>
</html>