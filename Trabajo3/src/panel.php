<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    require_once "clases\AdminClass.php";
    session_start();
    $admin = $_SESSION['admin'];
    echo "<h1>Bienvenido " . $admin->nombre . "</h1>";
    ?>
    <h1>Panel de control</h1>
    <!-- <button onclick="<?php  ?>"></button> -->
    <a href="carrito.php">Ver carrito</a>
    <a href="compras.php">Ver compras</a>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
