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

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user"]) && isset($_POST["pass"])){

    }
    
?>