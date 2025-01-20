<html>
    <body>
        <h1>Creación de usuario</h1>
        <form action="create.php" method="POST"> 
            <label for="user">Usuario: </label><input type="text" name="user" required/><br><br>
            <label for="pass">Contraseña: </label><input type="password" name="pass" required/><br><br>
            <label for="passConfirm">Confirma la contraseña: </label><input type="password" name="passConfirm" required/><br><br>
            <input type="submit" value="Enviar"/>
            <p> Si ya tienes un usuario <a href="login.php">haz click aquí</a></p>
        </form>
    </body>
</html>
<?php
    if(isset($_POST["user"])){
        $user = $_POST["user"];
        $pass = $_POST["pass"];
        $passConfirm = $_POST["passConfirm"];

        class WrongConfirmationException extends Exception{}
        try{
            if($pass != $passConfirm){
                throw new WrongConfirmationException("Las contraseñas no coinciden.");
            }
        }catch(Exception $e){
            echo "Error: " . $e->getMessage() . "Vuelva a intentarlo";
            exit();
        }

        
        $registro = $user . ":" . $pass . PHP_EOL; // PHP_EOL --> salto de linea
        
        file_put_contents("./usuarios.txt",$registro,FILE_APPEND);

        echo "Usuario creado correctamente";
    }
    
?>
