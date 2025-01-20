<html>

<body>
    <h1>Iniciar Sesión</h1>
    <form action="login.php" method="POST">
        <label for="user">Usuario: </label><input type="text" name="user" require /><br><br>
        <label for="pass">Contraseña: </label><input type="password" name="pass" require /><br><br>
        <input type="submit" value="Enviar" />

        <p> Si no tienes un usuario <a href="create.php">haz click aquí</a></p>
    </form>
</body>

</html>

<?php

session_start();

if (isset($_POST["user"])) {
    function wrongLogin($errno, $errstr, $errfile, $errline)
    {
        echo "Error personalizado: [$errno] $errstr<br>";
        echo "Error en la linea $errline en el archivo $errfile<br>";
    }

    $usuario = $_POST["user"];
    $contrasena = $_POST["pass"];

    try {

        if (file_exists("./usuarios.txt")) {
            $lineas = file("./usuarios.txt", FILE_IGNORE_NEW_LINES);
        } else {
            throw new Exception("El fichero no existe");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }

    set_error_handler("wrongLogin");

    foreach ($lineas as $linea) {
        list($user, $pass) = explode(":", $linea);
        if ($usuario == $user && $contrasena == $pass) {
            $_SESSION["user"] = $user;
            echo "Login correcto";
            header("Location: menu.php");
            exit();
        }
    }

    trigger_error("Los datos introducidos nos son correctos");
}


?>