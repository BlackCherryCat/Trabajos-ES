<?php
trait BD
{
    public function guardar($usuario, $contraseña, $id, $nombre, $precio, $stock, $descripcion)
    {
        try {
            $conexion = mysqli_connect("localhost", $usuario, $contraseña, "Trabajo3");
            $query = "INSERT INTO producto (idProducto, nombre, precio, stock, descripcion) VALUES ('$usuario', '$contraseña', '$id', '$nombre', '$precio', '$stock', '$descripcion')";
            mysqli_query($conexion, $query);
        } catch (Exception $e) {
            echo "Error al guardar";
        }
    }
    public function eliminar($usuario, $contraseña, $id)
    {
        try {
            $conexion = mysqli_connect("localhost", $usuario, $contraseña, "Trabajo3");
            $query = "DELETE FROM producto WHERE idProducto='$id'";
            mysqli_query($conexion, $query);
        } catch (Exception $e) {
            echo "Error al eliminar";
        }
    }
    public function modificar($usuario, $contraseña, $campo, $datoactual, $datonuevo)
    {
        try {
            $conexion = mysqli_connect("localhost", $usuario, $contraseña, "Trabajo3");
            $query = "UPDATE producto SET '$campo'='$datonuevo' WHERE '$campo'='$datoactual'";
            mysqli_query($conexion, $query);
        } catch (Exception $e) {
            echo "Error al modificar";
        }
    }
    public function consultar($usuario, $contraseña, $id)
    {
        try {
            $conexion = mysqli_connect("localhost", $usuario, $contraseña, "Trabajo3");
            $query = "SELECT * FROM producto WHERE idProducto='$id'";
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
                echo "<tr>" . "<td>" . $registro["idProducto"] . "</td>" .  "<td>" . $registro["nombre"] . "</td>" .  "<td>" . $registro["precio"] . "</td>" . "<td>" . $registro["stock"] . "</td>" . "<td>" . $registro["descripcion"] . "</td>" . "</tr>";
            }
            echo "</table>";
        } catch (Exception $e) {
            echo "Error al consultar";
        }
    }
}
