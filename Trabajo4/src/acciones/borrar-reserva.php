<?php
require_once '../includes/conexion.php';

if (isset($_GET['id']) && isset($_GET['idTramo'])) {
    $idReserva = (int) $_GET['id']; // Convertir a entero para evitar inyección SQL
    $idTramo = (int) $_GET['idTramo'];

    if ($idReserva > 0 && $idTramo > 0) {
        // Eliminar la relación del tramo con la reserva
        $consulta = "DELETE FROM Reserva_Tramos WHERE IdReserva = $idReserva AND IdTramo = $idTramo";
        $eliminarTramo = mysqli_query($db, $consulta);

        if ($eliminarTramo) {
            // Verificar si quedan más tramos en la reserva
            $consultaCheck = "SELECT COUNT(*) AS total FROM Reserva_Tramos WHERE IdReserva = $idReserva";
            $resultado = mysqli_query($db, $consultaCheck);
            $fila = mysqli_fetch_assoc($resultado);

            $_SESSION['correcto'] = "Tramo eliminado con éxito.";

            // Si no hay más tramos, eliminar la reserva
            if ($fila['total'] == 0) {
                $consultaEliminarReserva = "DELETE FROM Reservas WHERE IdReserva = $idReserva";
                $eliminarReserva = mysqli_query($db, $consultaEliminarReserva);

                if ($eliminarReserva) {
                    $_SESSION['correcto'] = "Reserva eliminada correctamente.";
                } else {
                    $_SESSION['error_general'] = "Error al eliminar la reserva.";
                }
            }

        } else {
            $_SESSION['error_general'] = "Error al eliminar el tramo.";
        }
    } else {
        $_SESSION['error_general'] = "ID de reserva o tramo inválido.";
    }
} else {
    $_SESSION['error_general'] = "No se proporcionó un ID de reserva o tramo.";
}

header("Location: ../mis-reservas.php");
exit;
