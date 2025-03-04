<?php
session_start();
require_once '../includes/conexion.php'; // Ajusta la ruta si es necesario

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

// Verificar el máximo de alumnos permitidos para ese tramo y fecha
$sqlMax = "SELECT SUM(NumAlumnos) - (SELECT NumAlumnos FROM Reservas WHERE IdReserva = ?) AS AlumnosDisponibles 
           FROM Reservas
           INNER JOIN Reserva_Tramos ON Reservas.IdReserva = Reserva_Tramos.IdReserva
           WHERE Reservas.Fecha = ? AND Reserva_Tramos.IdTramo = ?";
$stmtMax = $db->prepare($sqlMax);
$stmtMax->bind_param("isi", $idReserva, $fecha, $idTramo);
$stmtMax->execute();
$resultMax = $stmtMax->get_result();
$rowMax = $resultMax->fetch_assoc();
$stmtMax->close();

$maxAlumnos = $rowMax['AlumnosDisponibles'] ?? 0;

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

// Verificar si la combinación de curso, asignatura y profesor existe en Profesor_Curso_Asignatura
$idProfesor = $_SESSION['profesor']['IdProfesor'];

$sql_check = "SELECT 1 FROM Profesor_Curso_Asignatura 
              WHERE IdCurso = ? AND IdAsignatura = ? AND IdProfesor = ?";
$stmt_check = $db->prepare($sql_check);
$stmt_check->bind_param("iii", $idCurso, $idAsignatura, $idProfesor);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows === 0) {
    // Si no existe, insertar la combinación en Profesor_Curso_Asignatura
    $sql_insert = "INSERT INTO Profesor_Curso_Asignatura (IdCurso, IdAsignatura, IdProfesor)
                   VALUES (?, ?, ?)";
    $stmt_insert = $db->prepare($sql_insert);
    $stmt_insert->bind_param("iii", $idCurso, $idAsignatura, $idProfesor);
    $stmt_insert->execute();
    $stmt_insert->close();
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
