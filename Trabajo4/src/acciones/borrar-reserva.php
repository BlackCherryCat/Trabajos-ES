<?php
// Conectar a la base de datos
require_once '../includes/conexion.php';

// Comprobar que el ID de la reserva ha sido pasado por GET
if (isset($_GET['id'])) {
    $idReserva = $_GET['id'];

    // Verificar que el ID de la reserva es válido
    if (is_numeric($idReserva)) {
        // Consulta para borrar la reserva
        $sql = "DELETE FROM Reservas WHERE IdReserva = ?";

        // Preparar la consulta
        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param("i", $idReserva);
            $stmt->execute();

            // Verificar si la eliminación fue exitosa
            if ($stmt->affected_rows > 0) {
                // Redirigir a "Mis reservas" después de eliminarla
                header("Location: ../mis-reservas.php?mensaje=Reserva eliminada con éxito");
            } else {
                // Si no se pudo eliminar
                echo "Error al eliminar la reserva.";
            }
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta.";
        }
    } else {
        echo "ID de reserva inválido.";
    }
} else {
    echo "No se proporcionó un ID de reserva.";
}

?>
