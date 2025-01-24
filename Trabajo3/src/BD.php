<?php
trait BD
{
    public function guardar($usuario, $contraseña, $dato)
    {
        try {
            $conexion = mysqli_connect("localhost", $usuario, $contraseña, "Trabajo3");
            $query = "INSERT INTO Productos (nombreProducto,precio,stock) VALUES ('$dato[0]',$dato[1],$dato[2])";
            mysqli_query($conexion, $query);
        } catch (Exception $e) {
            echo "Error al guardar";
        }
    }
    public function eliminar($usuario, $contraseña, $dato)
    {
        try {
            $conexion = mysqli_connect("localhost", $usuario, $contraseña, "Trabajo3");
            $query = "DELETE FROM Productos WHERE nombreProducto='$dato'";
            mysqli_query($conexion, $query);
        } catch (Exception $e) {
            echo "Error al eliminar";
        }
    }
    public function modificar($usuario, $contraseña, $dato1, $dato2)
    {
        try {
            $conexion = mysqli_connect("localhost", $usuario, $contraseña, "Trabajo3");
            $query = "UPDATE Productos SET nombreProducto='$dato2' WHERE nombreProducto='$dato1'";
            mysqli_query($conexion, $query);
        } catch (Exception $e) {
            echo "Error al modificar";
        }
    }
    public function consultar($usuario, $contraseña, $dato)
    {
        try {
            $conexion = mysqli_connect("localhost", $usuario, $contraseña, "Trabajo3");
            $query = "SELECT * FROM Productos WHERE nombreProducto='$dato'";
            $resultado = mysqli_query($conexion, $query);
            while ($registro = mysqli_fetch_assoc($resultado)) {
                echo "Id |" . $registro["IdProducto"];
                echo "| Nombre " . "|" . $registro["nombreProducto"] . "|";
                echo "<br/>";
            }
        } catch (Exception $e) {
            echo "Error al consultar";
        }
    }
}
