<?php
require_once '../includes/redireccion.php';

if ($_SESSION['profesor']['EsAdmin'] != 1) {
    header("Location: index.php");
}
require_once '../includes/conexion.php';
require_once '../includes/funciones.php';

if (isset($_SESSION['profesor']) && isset($_GET['id'])) {
    $idProfesor = $_GET['id'];

    borrarProfesor($db, $idProfesor);
}

header("Location: ../profesores.php");