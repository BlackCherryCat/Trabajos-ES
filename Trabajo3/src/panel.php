<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include 'clases/AdminClass.php';
    session_start();
    $admin = new Admin($_SESSION["idUsuario"], $_SESSION["email"], $_SESSION["pass"], $_SESSION["nombre"], $_SESSION["passU"]);
    echo "<h1>Bienvenido " . $admin->nombre . "</h1>";
    ?>
    <h1>Panel de control</h1>
    <fieldset>
        <legend>Ver Productos</legend>
        <form action="" method="POST">
            <button type="submit" name="ver">Presiona para ver productos</button>
        </form>
    </fieldset>
    <br>
    <fieldset>
        <legend>Guardar Productos</legend>
        <form action="" method="POST">

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" require><br><br>
            <label for="precio">Precio</label>
            <input type="text" name="precio" id="precio" require><br><br>
            <label for="stock">Stock</label>
            <input type="text" name="stock" id="stock" require><br><br>
            <label for="descripcion">Descripcion</label>
            <input type="text" name="descripcion" id="descripcion" require><br><br>
            <button type="submit" name="guardar">Presiona para guardar</button>
        </form>
    </fieldset>
    <br>
    <fieldset>
        <legend>Modificar Productos</legend>
        <form action="" method="POST">
            <label for="campo">Campo</label>
            <input type="text" name="campo" id="campo" require><br><br>
            <label for="datoactual">Dato actual</label>
            <input type="text" name="datoactual" id="datoactual" require><br><br>
            <label for="datonuevo">Dato nuevo</label>
            <input type="text" name="datonuevo" id="datonuevo" require><br><br>
            <button type="submit" name="modificar">Presiona para modificar</button>
        </form>
    </fieldset>
    <br>
    <fieldset>
        <legend>Eliminar Productos</legend>
        <form action="" method="POST">
            <label for="id">ID de Producto</label>
            <input type="text" name="id" id="id" require><br><br>
            <button type="submit" name="eliminar">Presiona para eliminar</button>
        </form>
    </fieldset>
    <?php

    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["ver"])) {
            $admin->consultar($_SESSION["nombre"], $_SESSION["passU"]);
        }
        if (isset($_POST["guardar"])) {
            $admin->guardar($_SESSION["nombre"], $_SESSION["passU"], $_POST["nombre"], $_POST["precio"], $_POST["stock"], $_POST["descripcion"]);
        }
        if (isset($_POST["modificar"])) {
            $admin->modificar($_SESSION["nombre"], $_SESSION["passU"], $_POST["campo"], $_POST["datoactual"], $_POST["datonuevo"]);
        }
        if (isset($_POST["eliminar"])) {
            $admin->eliminar($_SESSION["nombre"], $_SESSION["passU"], $_POST["id"]);
        }
    }
    ?>
</body>

</html>