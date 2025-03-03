<?php
require_once '../includes/conexion.php';

if (isset($_GET['id']) && isset($_GET['idTramo'])) {
    $idReserva = $_GET['id'];
    $idTramo = $_GET['idTramo'];

    

    if (is_numeric($idReserva) && is_numeric($idTramo)) {
        // Borrar solo la relación de este tramo con la reserva
        $sql = "DELETE FROM Reserva_Tramos WHERE IdReserva = ? AND IdTramo = ?";

        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param("ii", $idReserva, $idTramo);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: ../mis-reservas.php?mensaje=Tramo eliminado con éxito");
            } else {
                echo "Error al eliminar el tramo.";
            }
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta.";
        }
    } else {
        echo "ID de reserva o tramo inválido.";
    }
} else {    
    echo "No se proporcionó un ID de reserva o tramo.";
}
?>