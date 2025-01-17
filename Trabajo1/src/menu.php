<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Bienvenido, <?php echo $_SESSION["user"] ?></h1>
    <a href="calculadora.php" style="margin-right: 20px;">Calculadora</a>
    <a href="emailValidator.php">Validador de emails</a>
    <br>
    <br>
    <a href="login.php">Cerrar sesión</a>
</body>

</html>