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
$sqlReserva = "SELECT Fecha, (SELECT IdTramo FROM Reserva_Tramos WHERE IdReserva = ?) AS IdTramo 
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

// Obtener el número total de alumnos en ese tramo y fecha
$queryAlumnosTotales = "SELECT SUM(Reservas.NumAlumnos) AS TotalAlumnos 
                        FROM Reservas
                        RIGHT JOIN Reserva_Tramos ON Reservas.IdReserva = Reserva_Tramos.IdReserva
                        INNER JOIN Tramos ON Reserva_Tramos.IdTramo = Tramos.IdTramo
                        WHERE Reservas.Fecha = ? AND Tramos.IdTramo = ?";

$stmtAlumnosTotales = $db->prepare($queryAlumnosTotales);
$stmtAlumnosTotales->bind_param("si", $fecha, $idTramo);
$stmtAlumnosTotales->execute();
$resultAlumnosTotales = $stmtAlumnosTotales->get_result();
$rowAlumnosTotales = $resultAlumnosTotales->fetch_assoc();
$stmtAlumnosTotales->close();

$totalAlumnosTramo = $rowAlumnosTotales['TotalAlumnos'] ?? 0;

// Calcular los alumnos disponibles
$maxAlumnos = 100 - ($totalAlumnosTramo - $numAlumnos);

// Validar si el número de alumnos supera el límite
if ($numAlumnos > $maxAlumnos) {
    die("Error: No puedes ingresar más alumnos de los permitidos en este tramo.");
}

// Verificar si la combinación de curso y asignatura existe en Curso_Asignatura
$sql_check_curso_asignatura = "SELECT 1 FROM Curso_Asignatura 
                               WHERE IdCurso = ? AND IdAsignatura = ?";
$stmt_check_curso_asignatura = $db->prepare($sql_check_curso_asignatura);
$stmt_check_curso_asignatura->bind_param("ii", $idCurso, $idAsignatura);
$stmt_check_curso_asignatura->execute();
$result_check_curso_asignatura = $stmt_check_curso_asignatura->get_result();

if ($result_check_curso_asignatura->num_rows === 0) {
    die("La combinación de curso y asignatura no existe en el sistema.");
}

// Actualizar la reserva
$sql = "UPDATE Reservas 
        SET NumAlumnos = ?, IdCurso = ?, IdAsignatura = ?
        WHERE IdReserva = ?";

$stmt = $db->prepare($sql);
$stmt->bind_param("iiii", $numAlumnos, $idCurso, $idAsignatura, $idReserva);

if ($stmt->execute()) {
    header("Location: ../mis-reservas.php?mensaje=Reserva%20actualizada%20con%20éxito");
} else {
    die("Error al actualizar la reserva: " . $stmt->error);
}

$stmt->close();
?>
