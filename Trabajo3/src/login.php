<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form action="login.php" method="POST">
        <label for="user">Email: </label><input type="email" name="email" id="user" require /><br><br>
        <label for="pass">Contraseña: </label><input type="password" name="pass" require /><br><br>
        <input type="submit" value="Enviar" />

        <p> Si no tienes un usuario <a href="signup.php">haz click aquí</a></p>
    </form>
</body>
</html>

<?php

    require_once './clases/AdminClass.php';
    require_once './clases/Cliente.php';
    session_start();
    /*
    $admin = new Admin(1, "javier@example.com" , "pass1234", "Javier", "");
    $admin -> consultar("root", "", 1);
    */
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"]) && isset($_POST["pass"])){
        //Definimos las credenciales de la base de datos
        $host = "localhost";
        $user = "root";
        $pass = "";
        $name_db = "Trabajo3";

        $email = $_POST["email"];
        $passU = $_POST["pass"];

        //Establecer Conexion
        $conexion = mysqli_connect($host, $user, $pass, $name_db);
        //Sentencia SQL
        $query = "Select * from usuario where email = '$email' and pass = '$passU'";
        //Consultamos en la base de datos
        $resultado = mysqli_query($conexion, $query);
        //Si obtenemos un resultado, login correcto
        if(mysqli_num_rows($resultado) == 1){
            //Sacamos el usuario logeado
            $logIn = mysqli_fetch_assoc($resultado);

            //Si es admin, lo redirigimos a la pagina de admin;
            if($logIn["isAdmin"] == 1){
                $administrador = new Admin($logIn["idUsuario"], $logIn["email"],$logIn["pass"], $logIn["nombre"], "Modificar Credenciales");
                $_SESSION["admin"] = $administrador;
                //Redirigimos a la página panel.php de administrados
                header("location: panel.php");
            }else{
                //Si no es admin, lo llevamos a la página de productos
                //Creamos el objeto cliente
                $cliente = new Cliente($logIn["idUsuario"], $logIn["email"],$logIn["pass"], $logIn["nombre"], MetodoDePago::TARJETA );
                $_SESSION["cliente"] = $cliente;
                header("location: productos.php");
            }
        }else{
            echo "El usuario no existe o la contraseña no es válida";
        }
    }
?>