<html>

<body>
    <?php
    include 'clases/Cliente.php';
    // include 'clases/Producto.php';
    session_start();

    if (isset($_SESSION["idUsuario"])) {

        // Pasar cliente a carrito (no funciona, lo he explicado en el informe)

        //     

        //     $conexion = mysqli_connect("localhost", "admin", "admin", "Trabajo3");
        //     $query = "SELECT * FROM producto WHERE idProducto = '$idProducto'";
        //     $resultado = mysqli_query($conexion, $query);

        //     if ($registro = mysqli_fetch_assoc($resultado)) {
        //         $producto = new Producto(
        //             $registro["idProducto"],
        //             $registro["nombre"],
        //             $registro["precio"],
        //             $registro["stock"],
        //             $registro["descripcion"]
        //         );

        //         $cliente->agregarCarrito($producto);

        //         $_SESSION["cliente"] = $cliente;
        //     }

        //     mysqli_free_result($resultado);
        //     mysqli_close($conexion);$idUsuario = $_SESSION["idUsuario"];
        //     $email = $_SESSION["email"];
        //     $pass = $_SESSION["pass"];
        //     $nombre = $_SESSION["nombre"];

        //     $cliente = new Cliente($idUsuario, $email, $pass, $nombre, MetodoDePago::TARJETA);
        $idUsuario = $_SESSION["idUsuario"];
        $email = $_SESSION["email"];
        $pass = $_SESSION["pass"];
        $nombre = $_SESSION["nombre"];

        $cliente = new Cliente($idUsuario, $email, $pass, $nombre, MetodoDePago::TARJETA);

        echo "<h1>Hola " . $cliente->nombre . "</h1><br>";

        $conexion = mysqli_connect("localhost", "admin", "admin", "Trabajo3");
        $query = "SELECT * FROM producto";
        $resultado = mysqli_query($conexion, $query);

        echo "<table border=1>";
        echo "<tr>";
        echo "<th>ID de Producto</th>";
        echo "<th>Nombre</th>";
        echo "<th>Precio</th>";
        echo "<th>Stock</th>";
        echo "<th>Descripcion</th>";
        echo "</tr>";

        while ($registro = mysqli_fetch_assoc($resultado)) {
            echo "<tr>
                            <td>" . htmlspecialchars($registro["idProducto"]) . "</td>
                            <td>" . htmlspecialchars($registro["nombre"])     . "</td>
                            <td>" . htmlspecialchars($registro["precio"])     . "</td>
                            <td>" . htmlspecialchars($registro["stock"])      . "</td>
                            <td>" . htmlspecialchars($registro["descripcion"]) . "</td>
                          </tr>";
        }
        echo "</table>";
    } else {
        echo "Acceso denegado. Debes iniciar sesión.";
    }

    ?>
</body>

</html>