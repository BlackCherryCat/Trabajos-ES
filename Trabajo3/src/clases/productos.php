<html>
    <body>
        <?php
            session_start();
            if(isset($_SESSION["idUsuario"])){
                include 'clases/Cliente.php';
                include 'clases/AdminClass.php';
                include 'clases/Producto.php'
                
                $idUsuario = $_SESSION["idUsuario"];
                $email = $_SESSION["email"];
                $pass = $_SESSION["pass"];
                $nombre = $_SESSION["nombre"];

                $cliente = new Cliente($idUsuario, $email, $pass, $nombre, MeotodoDePago::TARJETA);
                $admin = new Admin(1, "javier@example.com" , "pass1234", "Javier", "");

                echo "<p>Hola " . $nombre . "</p><br>";

                $conexion = mysqli_connect("localhost", "root", "", "Trabajo3");
                $query = "SELECT * FROM producto WHERE idProducto = '$idProducto'";
                $resultado = mysqli_query($conexion, $query);

                if ($registro = mysqli_fetch_assoc($resultado)) {
                    $producto = new Producto(
                        $registro["idProducto"],
                        $registro["nombre"],
                        $registro["precio"],
                        $registro["stock"],
                        $registro["descripcion"]
                    );
            
                    $cliente->agregarCarrito($producto);
            
                    $_SESSION["cliente"] = $cliente;
                }

                mysqli_free_result($resultado);
                mysqli_close($conexion);

                $conexion = mysqli_connect("localhost", "root", "", "Trabajo3");
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
                            <td>" . htmlspecialchars($registro["descripcion"]). "</td>
                            <td>
                                <form method='POST'>
                                    <input type='hidden' name='idProducto' value='" . $registro["idProducto"] . "'>
                                    <button type='submit'>Añadir al carrito</button>
                                </form>
                            </td>
                          </tr>";
                }
                echo "</table>";
            }else{
                echo "Acceso denegado. Debes iniciar sesión.";
            }
                
        ?>
    </body>
</html>
