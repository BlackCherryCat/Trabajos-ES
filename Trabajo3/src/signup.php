<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
</head>
<body>
    <h1>Registrarse</h1>
    <form action="signup.php" method="POST">
        <label for="user">Usuario: </label><input type="text" name="user" require /><br><br>
        <label for="pass">Contraseña: </label><input type="password" name="pass" require /><br><br>
        <select name="tipoUsuario" id="tipoUsuario" required>
            <option value="empleado">Empleado</option>
            <option value="administrador">Administrador</option>
        </select>
        <input type="submit" value="Enviar" />

        <p> Si ya tienes un usuario <a href="login.php">haz click aquí</a></p>
    </form>
</body>
</html>