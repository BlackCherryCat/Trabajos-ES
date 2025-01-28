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
        <label for="name">Nombre: </label><input type="text" name="name" require /><br><br>
        <label for="email">Email: </label><input type="text" name="email" require /><br><br>
        <label for="pass">Contraseña: </label><input type="password" name="pass" require /><br><br>
        <select name="tipoUsuario" id="tipoUsuario" required>
            <option value="0">Empleado</option>
            <option value="1">Administrador</option>
        </select>
        <input type="submit" value="Enviar" />

        <p> Si ya tienes un usuario <a href="login.php">haz click aquí</a></p>
    </form>
</body>
</html>

<?php
    // Validación si se envió el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include 'clases/Cliente.php';
        include 'clases/AdminClass.php';

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['pass'];
        $tipoUsuario = $_POST['tipoUsuario'];


        if ($tipoUsuario == 0) {
            // Crear un cliente
            $nuevoUsuario = new Cliente(uniqid(), $email, $password, $name, NULL);
            echo "<p>Cliente registrado exitosamente: </p>";
        } elseif ($tipoUsuario == 1) {
            // Crear un administrador
            $nuevoUsuario = new Admin(uniqid(), $email, $password, $name, NULL);
            echo "<p>Administrador registrado exitosamente:</p>";
        } else {
            echo "<p style='color:red;'>Tipo de usuario no válido.</p>";
        }
    }
?>