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
