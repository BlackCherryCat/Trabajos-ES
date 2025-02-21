<?php
session_start();
require_once '../includes/conexion.php'; // Ajusta la ruta si es necesario

// Verificar que la conexión está establecida
if (!$db) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Verificar si se pasa un ID de reserva
if (!isset($_POST['idReserva']) || empty($_POST['idReserva'])) {
    die("No se ha especificado un ID de reserva.");
}

$idReserva = $_POST['idReserva'];
$numAlumnos = $_POST['numAlumnos'];
$idCurso = $_POST['curso'];
$idAsignatura = $_POST['asignatura'];

// Verificar si la combinación de curso y asignatura existe en Curso_Asignatura
$sql_check_curso_asignatura = "SELECT 1 FROM Curso_Asignatura 
                               WHERE IdCurso = ? AND IdAsignatura = ?";
$stmt_check_curso_asignatura = $db->prepare($sql_check_curso_asignatura);
$stmt_check_curso_asignatura->bind_param("ii", $idCurso, $idAsignatura);
$stmt_check_curso_asignatura->execute();
$result_check_curso_asignatura = $stmt_check_curso_asignatura->get_result();

if ($result_check_curso_asignatura->num_rows === 0) {
    // Si la combinación no existe, mostrar un mensaje de error
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

// Ahora actualizar la reserva
$sql = "UPDATE Reservas 
        SET NumAlumnos = ?, IdCurso = ?, IdAsignatura = ?
        WHERE IdReserva = ?";

$stmt = $db->prepare($sql);
$stmt->bind_param("iiii", $numAlumnos, $idCurso, $idAsignatura, $idReserva);

if ($stmt->execute()) {
    // Redirigir con mensaje de éxito
    header("Location: ../mis-reservas.php?mensaje=Reserva%20actualizada%20con%20éxito");
} else {
    // En caso de error
    die("Error al actualizar la reserva: " . $stmt->error);
}

$stmt->close();
?>
