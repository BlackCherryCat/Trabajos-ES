<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include 'BD.php';
        include_once 'Usuarios.php';
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
                $this->$propiedad = $valor;
            }
            //Método que registra un usuario en la base de datos
        public function registerBD(){
            $host = "localhost";
            $user = "admin";
            $pass = "admin";
            $name_db = "Trabajo3";

            $conexion = mysqli_connect($host, $user, $pass, $name_db);

            $search = "SELECT * FROM usuario WHERE email = '$this->email'";

            $busqueda = mysqli_query($conexion, $search);

            if(mysqli_num_rows($busqueda) == 0){
                $query = "INSERT into usuario (nombre, email, pass, isAdmin) VALUES
                ('$this->nombre', '$this->email', '$this->pass', 1);";

                $resultado = mysqli_query($conexion, $query);

                if(mysqli_affected_rows($conexion) == 1){
                    echo "Usurio registrado correctamente";
                }else{
                    echo "Error al registrar usuario. Consulte su proveedor de Bases de Datos";
                }
            }else{
                echo "El email proporcionado ya está registrado en nuestra base de datos, pruebe con otro";
            }
        }
            use BD;
        }

    ?>
</body>
</html>