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

// Obtener el IdProfesor de la reserva actual
$sqlProfesor = "SELECT IdProfesor FROM Reservas WHERE IdReserva = ?";
$stmtProfesor = $db->prepare($sqlProfesor);
$stmtProfesor->bind_param("i", $idReserva);
$stmtProfesor->execute();
$resultProfesor = $stmtProfesor->get_result();
$reservaProfesor = $resultProfesor->fetch_assoc();
$stmtProfesor->close();

if (!$reservaProfesor) {
    die("Error: No se encontró el profesor de la reserva.");
}

$idProfesorReserva = $reservaProfesor['IdProfesor'];

// Verificar si la combinación de curso, asignatura y profesor existe en Profesor_Curso_Asignatura
$sql_check_curso_asignatura_profesor = "SELECT 1 FROM Profesor_Curso_Asignatura CA
                                        WHERE CA.IdCurso = ? AND CA.IdAsignatura = ? AND CA.IdProfesor = ?";
$stmt_check_curso_asignatura_profesor = $db->prepare($sql_check_curso_asignatura_profesor);
$stmt_check_curso_asignatura_profesor->bind_param("iii", $idCurso, $idAsignatura, $idProfesorReserva);
$stmt_check_curso_asignatura_profesor->execute();
$result_check_curso_asignatura_profesor = $stmt_check_curso_asignatura_profesor->get_result();

if ($result_check_curso_asignatura_profesor->num_rows === 0) {
    die("Error: La combinación de curso y asignatura no está asociada con el profesor.");
}

// Obtener la fecha de la reserva
$sqlReserva = "SELECT Fecha
    from Reservas
    WHERE IdReserva = ?";
$stmtReserva = $db->prepare($sqlReserva);
$stmtReserva->bind_param("i", $idReserva);
$stmtReserva->execute();
$resultReserva = $stmtReserva->get_result();
$reserva = $resultReserva->fetch_assoc();
$stmtReserva->close();

if (!$reserva) {
    die("Reserva no encontrada.");
}

$fecha = $reserva['Fecha'];
$idTramo = $reserva['IdTramo'];


//Número máximo de alumnos permitidos en todos los tramos
$queryAlumnosTotales = "SELECT MAX(TotalAlumnos) AS MaxTotalAlumnos 
                            FROM (
                                SELECT SUM(Reservas.NumAlumnos) AS TotalAlumnos
                                FROM Reservas
                                RIGHT JOIN Reserva_Tramos ON Reservas.IdReserva = Reserva_Tramos.IdReserva
                                INNER JOIN Tramos ON Reserva_Tramos.IdTramo = Tramos.IdTramo
                                WHERE Reservas.Fecha = ?
                                GROUP BY Tramos.IdTramo
                            ) AS Subconsulta;";

$stmtAlumnosTotales = $db->prepare($queryAlumnosTotales);
$stmtAlumnosTotales->bind_param("s", $fecha);
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
