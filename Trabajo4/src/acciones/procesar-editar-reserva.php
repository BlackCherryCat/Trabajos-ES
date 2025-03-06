<?php
session_start();
require_once '../includes/conexion.php';

if (!$db) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

if (!isset($_POST['idReserva']) || empty($_POST['idReserva'])) {
    die("No se ha especificado un ID de reserva.");
}

$idReserva = $_POST['idReserva'];
$numAlumnos = $_POST['numAlumnos'];
$idCurso = $_POST['curso'];
$idAsignatura = $_POST['asignatura'];

// Obtener la fecha y tramo de la reserva
$sqlReserva = "SELECT Fecha, NumAlumnos, (SELECT IdTramo FROM Reserva_Tramos WHERE IdReserva = ?) AS IdTramo 
               FROM Reservas WHERE IdReserva = ?";
$stmtReserva = $db->prepare($sqlReserva);
$stmtReserva->bind_param("ii", $idReserva, $idReserva);
$stmtReserva->execute();
$resultReserva = $stmtReserva->get_result();
$reserva = $resultReserva->fetch_assoc();
$stmtReserva->close();

if (!$reserva) {
    die("Reserva no encontrada.");
}

$fecha = $reserva['Fecha'];
$idTramo = $reserva['IdTramo'];
$numAlumnosActual = $reserva['NumAlumnos']; // Número de alumnos actual en la reserva

// Verificar el máximo de alumnos permitidos
$sqlMax = "SELECT COALESCE(SUM(NumAlumnos), 0) AS AlumnosOcupados 
           FROM Reservas
           INNER JOIN Reserva_Tramos ON Reservas.IdReserva = Reserva_Tramos.IdReserva
           WHERE Reservas.Fecha = ? AND Reserva_Tramos.IdTramo = ?";
$stmtMax = $db->prepare($sqlMax);
$stmtMax->bind_param("si", $fecha, $idTramo);
$stmtMax->execute();
$resultMax = $stmtMax->get_result();
$rowMax = $resultMax->fetch_assoc();
$stmtMax->close();

// Calcular el nuevo máximo disponible sumando los alumnos originales de esta reserva
$maxAlumnos = ($rowMax['AlumnosOcupados'] - $numAlumnosActual) + $numAlumnosActual;

if ($numAlumnos > $maxAlumnos) {
    die("Error: No puedes ingresar más alumnos de los permitidos en este tramo.");
}

// Actualizar la reserva
$sqlUpdate = "UPDATE Reservas SET NumAlumnos = ?, IdCurso = ?, IdAsignatura = ? WHERE IdReserva = ?";
$stmtUpdate = $db->prepare($sqlUpdate);
$stmtUpdate->bind_param("iiii", $numAlumnos, $idCurso, $idAsignatura, $idReserva);

if ($stmtUpdate->execute()) {
    header("Location: ../mis-reservas.php?mensaje=Reserva%20actualizada%20con%20éxito");
} else {
    die("Error al actualizar la reserva: " . $stmtUpdate->error);
}

$stmtUpdate->close();
?>
