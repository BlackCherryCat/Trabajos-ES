<html>
    <body>
        <h1>Iniciar Sesión</h1>
        <form action="login.php" method="POST"> 
            <label for="user">Usuario: </label><input type="text" name="user" require/><br><br>
            <label for="pass">Contraseña: </label><input type="password" name="pass" require/><br><br>
            <input type="submit" value="Enviar"/>

            <p> Si no tienes un usuario <a href="create.php">haz click aquí</a></p>
        </form>
    </body>
</html>

<?php
    if(isset($_POST["user"])){
        function wrongLogin($errno, $errstr, $errfile, $errline) {
            echo "Error personalizado: [$errno] $errstr<br>";
            echo "Error en la linea $errline en el archivo $errfile<br>";
        }

        set_error_handler("wrongLogin");
        
        $usuario = $_POST["user"];
        $contrasena = $_POST["pass"];

        $lineas = file("./ficheros/usuarios.txt", FILE_IGNORE_NEW_LINES);

        foreach ($lineas as $linea){
            list($user,$pass) = explode(":",$linea);
            if ($usuario == $user && $contrasena == $pass) {

            } else {
                trigger_error("Los datos introducidos nos son correctos");
            }

        }
    }


?>
